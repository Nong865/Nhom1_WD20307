<?php
require_once __DIR__ . '/../models/Booking.php';

class BookingController
{
    private $booking;

    public function __construct()
    {
        $this->booking = new Booking();
    }

    // Hiển thị form
    public function create()
    {
        include __DIR__ . '/../views/bookings/create.php';
    }

    // Lưu booking
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingCreate");
            exit;
        }

        $customer_name   = $_POST['customer_name'];
        $customer_phone  = $_POST['customer_phone'];
        $tour_name       = $_POST['tour_name'];
        $tour_date       = $_POST['tour_date'];
        $special_request = $_POST['special_request'];
        $type            = $_POST['type']; // 'individual' hoặc 'group'

        // Xử lý số lượng tùy theo loại khách
        if ($type === 'individual') {
            $quantity = 1; // khách lẻ luôn là 1
        } else {
            $quantity = (int)$_POST['quantity']; // khách đoàn nhập số lượng
        }

        // Kiểm tra chỗ trống
        $max_slot = 30;
        if ($quantity > $max_slot) {
            $error = "Số lượng quá lớn! Chỉ còn $max_slot chỗ trống.";
            include __DIR__ . '/../views/bookings/create.php';
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
            'booking_date'   => date('Y-m-d H:i:s')
        ];

        $this->booking->createBooking($data);

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
        $id     = $_POST['id'];
        $status = $_POST['status'];

        $this->booking->updateStatus($id, $status);

        header("Location: index.php?action=bookingIndex");
        exit;
    }

    // Lịch sử trạng thái
    public function history()
    {
        $id = $_GET['id'];
        $history = $this->booking->getStatusHistory($id);

        include __DIR__ . '/../views/bookings/history.php';
    }
}
