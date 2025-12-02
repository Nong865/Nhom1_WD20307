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
        $staffs   = $this->booking->getAllStaff(); 
        $partners = $this->booking->getAllPartners(); // danh sách partner
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

        $customer_name   = $_POST['customer_name'] ?? '';
        $customer_phone  = $_POST['customer_phone'] ?? '';
        $tour_name       = $_POST['tour_name'] ?? '';
        $tour_date       = $_POST['tour_date'] ?? '';
        $special_request = $_POST['special_request'] ?? '';
        $type            = $_POST['type'] ?? '';

        $staff_id       = isset($_POST['staff_id']) ? (int)$_POST['staff_id'] : null;
        $partnerIds     = $_POST['partner_ids'] ?? []; // ⭐ Nhận mảng partner_ids từ form

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

        $data = [
            'customer_name'  => $customer_name,
            'customer_phone' => $customer_phone,
            'quantity'       => $quantity,
            'tour_name'      => $tour_name,
            'tour_date'      => $tour_date,
            'special_request'=> $special_request,
            'type'           => $type,
            'status'         => 'Chờ xác nhận',
            'booking_date'   => date('Y-m-d H:i:s'),
            'staff_id'       => $staff_id
            // ⭐ partner_id bỏ đi, dùng mảng partnerIds
        ];

        $this->booking->createBooking($data, $partnerIds); // truyền mảng partner_ids

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
