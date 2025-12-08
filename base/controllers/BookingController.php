<?php
// C:\laragon\www\DA_Nhom1\base\controllers\BookingController.php

require_once __DIR__ . '/../models/Booking.php';

class BookingController
{
    private $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
    }

    private function loadView($viewName, $data = [])
    {
        $data['active'] = 'booking';
        $content = render($viewName, $data);
        include dirname(__DIR__) . "/views/main.php";
    }

    // ======================================================================
    // 1. CREATE & STORE
    // ======================================================================

    public function create()
    {
        $huongDanViens = $this->bookingModel->getAllHuongDanVien();
        $partners      = $this->bookingModel->getAllPartners();
        $tours         = $this->bookingModel->getAllTours();

        $this->loadView('bookings/create', [
            'huongDanViens' => $huongDanViens,
            'partners'      => $partners,
            'tours'         => $tours,
            'title'         => 'Tạo Booking Mới'
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingCreate");
            exit;
        }

        // Lấy và làm sạch dữ liệu
        $customer_name     = trim($_POST['customer_name'] ?? '');
        $customer_phone    = trim($_POST['customer_phone'] ?? '');
        $tour_name         = trim($_POST['tour_name'] ?? '');
        $tour_date         = $_POST['tour_date'] ?? '';
        $special_request   = trim($_POST['special_request'] ?? '');
        $type              = $_POST['type'] ?? 'individual';
        $huong_dan_vien_id = !empty($_POST['huong_dan_vien_id']) ? (int)$_POST['huong_dan_vien_id'] : null;
        $partnerIds        = is_array($_POST['partner_ids'] ?? []) ? array_map('intval', $_POST['partner_ids']) : [];
        $groupMembers      = ($type === 'group') ? (array)($_POST['group_members'] ?? []) : [];

        // Validation cơ bản
        if (empty($customer_name) || empty($customer_phone) || empty($tour_name) || empty($tour_date)) {
            header("Location: index.php?action=bookingCreate&message=" . urlencode('Vui lòng điền đầy đủ thông tin bắt buộc!') . "&type=danger");
            exit;
        }

        // Xử lý số lượng
        $quantity = ($type === 'individual') ? 1 : count(array_filter($groupMembers, 'strlen'));
        if ($type === 'group' && $quantity < 1) {
            header("Location: index.php?action=bookingCreate&message=" . urlencode('Khách đoàn phải có ít nhất 1 thành viên!') . "&type=danger");
            exit;
        }

        if ($quantity > 30) {
            header("Location: index.php?action=bookingCreate&message=" . urlencode('Số lượng tối đa chỉ 30 người!') . "&type=danger");
            exit;
        }

        // Tính tổng tiền
        $tour = $this->bookingModel->getTourByName($tour_name);
        if (!$tour) {
            header("Location: index.php?action=bookingCreate&message=" . urlencode('Tour không tồn tại!') . "&type=danger");
            exit;
        }

        $total_price = (float)$tour['price'] * $quantity;

        // Dữ liệu gửi cho Model
        $data = [
            'customer_name'     => $customer_name,
            'customer_phone'    => $customer_phone,
            'type'              => $type,
            'quantity'          => $quantity,
            'tour_name'         => $tour_name,
            'tour_date'         => $tour_date,
            'special_request'   => $special_request,
            'group_members'     => $groupMembers,
            'huong_dan_vien_id' => $huong_dan_vien_id,
            'total_price'       => $total_price,
            'status'            => 'Chờ xác nhận',  // ĐÚNG VỚI ENUM DB
            'booking_date'      => date('Y-m-d H:i:s')
        ];

        $result = $this->bookingModel->createBooking($data, $partnerIds);

        if ($result) {
            header("Location: index.php?action=bookingIndex&message=" . urlencode("Tạo Booking thành công! ID: #$result") . "&type=success");
        } else {
            header("Location: index.php?action=bookingCreate&message=" . urlencode("Lỗi tạo Booking! Vui lòng thử lại.") . "&type=danger");
        }
        exit;
    }

    // ======================================================================
    // 2. INDEX & STATUS & HISTORY
    // ======================================================================

    public function index()
    {
        $bookings = $this->bookingModel->getAll();
        $this->loadView('bookings/index', [
            'bookings' => $bookings,
            'title'    => 'Danh sách Booking'
        ]);
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingIndex");
            exit;
        }

        $id     = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$id || !$status) {
            header("Location: index.php?action=bookingIndex&message=" . urlencode("Thiếu thông tin cập nhật trạng thái!") . "&type=danger");
            exit;
        }

        $success = $this->bookingModel->updateStatus($id, $status);

        $msg = $success
            ? "Cập nhật trạng thái thành công!"
            : "Lỗi cập nhật trạng thái!";

        $type = $success ? 'success' : 'danger';

        header("Location: index.php?action=bookingIndex&message=" . urlencode($msg) . "&type=$type");
        exit;
    }

    public function history()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?action=bookingIndex&message=" . urlencode("Thiếu ID Booking!") . "&type=danger");
            exit;
        }

        $history = $this->bookingModel->history($id);

        $this->loadView('bookings/history', [
            'history'     => $history,
            'booking_id'  => $id,
            'title'       => "Lịch sử Booking #$id"
        ]);
    }

    // ======================================================================
    // 3. DETAIL, EDIT, UPDATE, DELETE
    // ======================================================================

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id || !($booking = $this->bookingModel->getById($id))) {
            header("Location: index.php?action=bookingIndex&message=" . urlencode("Không tìm thấy Booking!") . "&type=danger");
            exit;
        }

        $this->loadView('bookings/detail', [
            'booking' => $booking,
            'title'   => "Chi tiết Booking #$id"
        ]);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id || !($booking = $this->bookingModel->getById($id))) {
            header("Location: index.php?action=bookingIndex&message=" . urlencode("Không tìm thấy Booking!") . "&type=danger");
            exit;
        }

        $huongDanViens = $this->bookingModel->getAllHuongDanVien();
        $tours         = $this->bookingModel->getAllTours();
        $partners      = $this->bookingModel->getAllPartners();

        $this->loadView('bookings/edit', [
            'booking'       => $booking,
            'huongDanViens' => $huongDanViens,
            'tours'         => $tours,
            'partners'      => $partners,
            'title'         => "Chỉnh sửa Booking #$id"
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingIndex");
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: index.php?action=bookingIndex&message=" . urlencode("Thiếu ID Booking!") . "&type=danger");
            exit;
        }

        $type         = $_POST['type'] ?? 'individual';
        $groupMembers = ($type === 'group') ? (array)($_POST['group_members'] ?? []) : [];
        $quantity     = ($type === 'individual') ? 1 : count(array_filter($groupMembers, 'strlen'));

        if ($type === 'group' && $quantity < 1) {
            header("Location: index.php?action=bookingEdit&id=$id&message=" . urlencode("Khách đoàn phải có ít nhất 1 thành viên!") . "&type=danger");
            exit;
        }

        $tour = $this->bookingModel->getTourByName($_POST['tour_name'] ?? '');
        $total_price = $tour ? (float)$tour['price'] * $quantity : 0;

        $data = [
            'customer_name'     => trim($_POST['customer_name'] ?? ''),
            'customer_phone'    => trim($_POST['customer_phone'] ?? ''),
            'type'              => $type,
            'quantity'          => $quantity,
            'tour_name'         => trim($_POST['tour_name'] ?? ''),
            'tour_date'         => $_POST['tour_date'] ?? '',
            'special_request'   => trim($_POST['special_request'] ?? ''),
            'huong_dan_vien_id' => !empty($_POST['huong_dan_vien_id']) ? (int)$_POST['huong_dan_vien_id'] : null,
            'status'            => $_POST['status'] ?? 'Chờ xác nhận',
            'total_price'       => $total_price,
            'partner_ids'       => is_array($_POST['partner_ids'] ?? []) ? array_map('intval', $_POST['partner_ids']) : [],
            'group_members'     => $groupMembers
        ];

        $success = $this->bookingModel->updateBooking($id, $data);

        $msg  = $success ? "Cập nhật Booking thành công!" : "Lỗi cập nhật Booking!";
        $type = $success ? 'success' : 'danger';

        header("Location: index.php?action=bookingIndex&message=" . urlencode($msg) . "&type=$type");
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?action=bookingIndex&message=" . urlencode("Thiếu ID Booking!") . "&type=danger");
            exit;
        }

        $success = $this->bookingModel->deleteBooking($id);

        $msg  = $success ? "Xóa Booking thành công!" : "Xóa Booking thất bại!";
        $type = $success ? 'success' : 'danger';

        header("Location: index.php?action=bookingIndex&message=" . urlencode($msg) . "&type=$type");
        exit;
    }
}