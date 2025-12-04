<?php
// C:\laragon\www\DA_Nhom1\base\controllers\BookingController.php

// Lưu ý: Đảm bảo file helper.php (chứa hàm render) được nạp ở đâu đó trong dự án (ví dụ: index.php gốc)

require_once __DIR__ . '/../models/Booking.php';

class BookingController
{
    private $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
    }
    
    // Hàm gọi render để bao bọc View và main.php (Tái cấu trúc)
    private function loadView($viewName, $data = []) {
        $data['active'] = 'booking';
        $content = render($viewName, $data);
        include dirname(__DIR__) . "/views/main.php"; 
    }


    // ======================================================================
    // 1. CHỨC NĂNG TẠO VÀ LƯU (CREATE & STORE)
    // ======================================================================

    // Hiển thị form tạo booking
    public function create()
    {
        $huongDanViens = $this->bookingModel->getAllHuongDanVien(); 
        $partners = $this->bookingModel->getAllPartners();
        $tours = $this->bookingModel->getAllTours();
        
        $this->loadView('bookings/create', [
            'huongDanViens' => $huongDanViens,
            'partners' => $partners,
            'tours' => $tours,
            'title' => 'Tạo Booking Mới'
        ]);
    }

    // Lưu booking
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingCreate");
            exit;
        }

        // ==========================================================
        // SỬA LỖI UNDEFINED VARIABLE: GÁN DỮ LIỆU TỪ POST VÀO BIẾN CỤC BỘ
        // ==========================================================
        $customer_name      = $_POST['customer_name'] ?? '';
        $customer_phone     = $_POST['customer_phone'] ?? '';
        $tour_name          = $_POST['tour_name'] ?? ''; // <-- Đã được gán
        $tour_date          = $_POST['tour_date'] ?? '';
        $special_request    = $_POST['special_request'] ?? '';
        $type               = $_POST['type'] ?? '';
        $huong_dan_vien_id  = isset($_POST['huong_dan_vien_id']) ? (int)$_POST['huong_dan_vien_id'] : null;
        $partnerIds         = $_POST['partner_ids'] ?? []; // <-- Đã được gán
        // ==========================================================

        // Nếu khách lẻ → số lượng = 1
        $quantity = ($type === 'individual') ? 1 : (int)($_POST['quantity'] ?? 0);
        
        // Kiểm tra số lượng
        $max_slot = 30;
        
        if ($quantity > $max_slot || $quantity <= 0) {
             $error_message = ($quantity <= 0) ? "Số lượng phải lớn hơn 0." : "Số lượng quá lớn! Chỉ còn $max_slot chỗ trống.";
             header("Location: index.php?action=bookingCreate&message=" . urlencode($error_message) . "&type=danger");
             exit;
        }

        // Lấy giá tour từ model theo tên tour
        $tour = $this->bookingModel->getTourByName($tour_name);
        $price_per_person = $tour ? (float)$tour['price'] : 0;
        $total_price = $price_per_person * $quantity;

        $data = [
            'customer_name'     => $customer_name,
            'customer_phone'    => $customer_phone,
            'quantity'          => $quantity,
            'tour_name'         => $tour_name,
            'tour_date'         => $tour_date,
            'special_request'   => $special_request,
            'type'              => $type,
            'status'            => 'Chờ xác nhận',
            'booking_date'      => date('Y-m-d H:i:s'),
            'huong_dan_vien_id' => $huong_dan_vien_id,
            'total_price'       => $total_price, 
        ];

        $this->bookingModel->createBooking($data, $partnerIds);

        header("Location: index.php?action=bookingIndex&message=" . urlencode('Tạo Booking thành công!') . "&type=success");
        exit;
    }

    // ======================================================================
    // 2. CHỨC NĂNG XEM VÀ CẬP NHẬT TRẠNG THÁI (INDEX & UPDATE STATUS & HISTORY)
    // ======================================================================

    // Danh sách booking
    public function index()
    {
        $bookings = $this->bookingModel->getAll();
        $this->loadView('bookings/index', ['bookings' => $bookings, 'title' => 'Danh sách Booking']);
    }

    // Cập nhật trạng thái
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingIndex");
            exit;
        }

        $id     = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$id || !$status) {
            header("Location: index.php?action=bookingIndex&message=Thiếu ID hoặc Trạng thái để cập nhật!&type=danger");
            exit;
        }

        $result = $this->bookingModel->updateStatus($id, $status);

        if (!$result) {
            header("Location: index.php?action=bookingIndex&message=Lỗi khi cập nhật trạng thái hoặc lưu lịch sử!&type=danger");
            exit;
        }

        header("Location: index.php?action=bookingIndex&message=" . urlencode("Cập nhật trạng thái thành công!") . "&type=success");
        exit;
    }

    // Lịch sử trạng thái booking
    public function history()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: index.php?action=bookingIndex&message=Thiếu ID booking!&type=danger");
            exit;
        }

        $history = $this->bookingModel->history($id);
        
        $this->loadView('bookings/history', [
            'history' => $history,
            'booking_id' => $id,
            'title' => 'Lịch sử trạng thái'
        ]);
    }
    
    // ======================================================================
    // 3. CHỨC NĂNG QUẢN LÝ CHI TIẾT (DETAIL, EDIT, UPDATE, DELETE)
    // ======================================================================

    /**
     * Hiển thị chi tiết của một Booking
     * Route: index.php?action=bookingDetail&id=X
     */
    public function detail()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id || !($booking = $this->bookingModel->getById($id))) {
            header('Location: index.php?action=bookingIndex&message=' . urlencode('Không tìm thấy Booking!') . '&type=danger');
            exit;
        }

        $this->loadView('bookings/detail', [ 'booking' => $booking, 'title' => 'Chi tiết Booking #' . $id ]);
    }

    /**
     * Hiển thị form chỉnh sửa Booking
     * Route: index.php?action=bookingEdit&id=X
     */
   public function edit()
{
    $id = $_GET['id'] ?? null;
    
    if (!$id || !($booking = $this->bookingModel->getById($id))) {
        // ... (xử lý lỗi)
    }
    
    // Lấy dữ liệu phụ cho Select Box
    $huongDanViens = $this->bookingModel->getAllHuongDanVien();
    $tours = $this->bookingModel->getAllTours(); 
    
    // BỔ SUNG: Lấy tất cả Nhà cung cấp
    $partners = $this->bookingModel->getAllPartners(); // <--- THÊM DÒNG NÀY

    $title = 'Chỉnh sửa Booking #' . $id;
    
    $this->loadView('bookings/edit', [ 
        'booking' => $booking,
        'huongDanViens' => $huongDanViens,
        'tours' => $tours,
        'partners' => $partners, // <--- TRUYỀN BIẾN PARTNERS
        'title' => 'Chỉnh sửa Booking #' . $id 
    ]);
}

    /**
     * Xử lý cập nhật Booking (POST)
     * Route: index.php?action=bookingUpdate
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=bookingIndex');
            exit;
        }

        $id = $_POST['id'] ?? null;
        
        // Lấy và chuẩn bị dữ liệu từ form POST
        $data = [
            'customer_name'     => $_POST['customer_name'] ?? '',
            'customer_phone'    => $_POST['customer_phone'] ?? '',
            'tour_name'         => $_POST['tour_name'] ?? '',
            'tour_date'         => $_POST['tour_date'] ?? '',
            'special_request'   => $_POST['special_request'] ?? '',
            'quantity'          => (int)($_POST['quantity'] ?? 0),
            'huong_dan_vien_id' => (int)($_POST['huong_dan_vien_id'] ?? 0),
            // 'status' không được gửi để updateBooking() vì nó cần logic lịch sử riêng
        ];
        
        // Tính lại giá tiền nếu cần
        $tour = $this->bookingModel->getTourByName($data['tour_name']);
        $price_per_person = $tour ? (float)$tour['price'] : 0;
        $data['total_price'] = $price_per_person * $data['quantity'];


        $result = $this->bookingModel->updateBooking($id, $data);

        if ($result) {
            header('Location: index.php?action=bookingIndex&message=' . urlencode('Cập nhật Booking thành công!') . '&type=success');
        } else {
            header('Location: index.php?action=bookingEdit&id=' . $id . '&message=' . urlencode('Lỗi cập nhật Booking!') . '&type=danger');
        }
        exit;
    }

    /**
     * Xử lý xóa Booking
     * Route: index.php?action=bookingDelete&id=X
     */
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?action=bookingIndex&message=' . urlencode('Thiếu ID Booking để xóa!') . '&type=danger');
            exit;
        }
        
        $result = $this->bookingModel->deleteBooking($id); 

        if ($result) {
            header('Location: index.php?action=bookingIndex&message=' . urlencode('Xóa Booking thành công!') . '&type=success');
        } else {
            header('Location: index.php?action=bookingIndex&message=' . urlencode('Xóa Booking thất bại!') . '&type=danger');
        }
        exit;
    }
}