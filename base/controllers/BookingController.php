<?php
require_once __DIR__ . '/../models/Booking.php';

class BookingController
{
    private $booking;

    public function __construct()
    {
        $this->booking = new Booking();
    }

    // Hiển thị form tạo booking
    public function create()
    {
        // THAY ĐỔI: Lấy danh sách Hướng dẫn viên (Tên + Chứng chỉ) thay vì staff
        // Bạn nhớ viết hàm getAllHuongDanVien() trong Model để select id, ho_ten, chung_chi nhé
        $huongDanViens = $this->booking->getAllHuongDanVien(); 
        
        $partners = $this->booking->getAllPartners();
        $tours    = $this->booking->getAllTours();

        include __DIR__ . '/../views/bookings/create.php';
    }

    // Lưu booking
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingCreate");
            exit;
        }

        $customer_name    = $_POST['customer_name'] ?? '';
        $customer_phone   = $_POST['customer_phone'] ?? '';
        $tour_name        = $_POST['tour_name'] ?? '';
        $tour_date        = $_POST['tour_date'] ?? '';
        $special_request  = $_POST['special_request'] ?? '';
        $type             = $_POST['type'] ?? '';

        // THAY ĐỔI: Lấy ID hướng dẫn viên từ form
        // (Lưu ý: Bên view create.php thẻ select cần có name="huong_dan_vien_id")
        $huong_dan_vien_id = isset($_POST['huong_dan_vien_id']) ? (int)$_POST['huong_dan_vien_id'] : null;
        
        $partnerIds       = $_POST['partner_ids'] ?? [];

        // Nếu khách lẻ → số lượng = 1
        if ($type === 'individual') {
            $quantity = 1;
        } else {
            $quantity = (int)($_POST['quantity'] ?? 0);
        }

        // Kiểm tra số lượng
        $max_slot = 30;
        if ($quantity > $max_slot) {
            $error = "Số lượng quá lớn! Chỉ còn $max_slot chỗ trống.";
            $this->create();
            return;
        }

        // Lấy giá tour từ model theo tên tour
        $tour = $this->booking->getTourByName($tour_name);
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
            
            // THAY ĐỔI: Lưu ID hướng dẫn viên vào mảng data
            // (Lưu ý: Cột trong bảng 'bookings' nên đổi từ staff_id thành huong_dan_vien_id cho đồng bộ)
            'huong_dan_vien_id' => $huong_dan_vien_id, 
            
            'total_price'       => $total_price, 
        ];

        $this->booking->createBooking($data, $partnerIds);

        header("Location: index.php?action=bookingIndex");
        exit;
    }

    // Danh sách booking
    public function index()
    {
        $bookings = $this->booking->getAll();
        include __DIR__ . '/../views/bookings/index.php';
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
            die("Thiếu dữ liệu để cập nhật trạng thái booking!");
        }

        $result = $this->booking->updateStatus($id, $status);

        if (!$result) {
            die("Lỗi khi cập nhật trạng thái hoặc lưu lịch sử!");
        }

        header("Location: index.php?action=bookingIndex");
        exit;
    }

    // Lịch sử trạng thái booking
    public function history()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("Thiếu ID booking!");
        }

        $history = $this->booking->history($id);
        include __DIR__ . '/../views/bookings/history.php';
    }
}