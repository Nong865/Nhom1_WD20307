<?php
require_once __DIR__ . '/../models/Booking.php';

class BookingController {
    private $booking;

    public function __construct() {
        $this->booking = new Booking(); // BaseModel sẽ tự kết nối PDO
    }

    // Hiển thị danh sách booking
    public function index() {
        $bookings = $this->booking->getAll();
        include __DIR__ . '/../views/bookings/index.php';
    }

    // Tạo booking mới
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'customer_id' => $_POST['customer_id'],
                'tour_name'   => $_POST['tour_name'],
                'status'      => 'Chờ xác nhận',
                'booking_date'=> date('Y-m-d H:i:s')
            ];

            $this->booking->createBooking($data);

            // Redirect về danh sách
            header("Location: index.php?action=bookingIndex");
            exit;
        } else {
            include __DIR__ . '/../views/bookings/create.php';
        }
    }

    // Cập nhật trạng thái booking
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['id'];
            $new_status = $_POST['status'];

            $this->booking->updateStatus($booking_id, $new_status);
        }

        header("Location: index.php?action=bookingIndex");
        exit;
    }

    // Xem lịch sử thay đổi trạng thái
    public function history() {
        $booking_id = $_GET['id'] ?? null;

        if ($booking_id) {
            $history = $this->booking->getStatusHistory($booking_id);
            include __DIR__ . '/../views/bookings/history.php';
        } else {
            echo "Booking ID không hợp lệ!";
        }
    }
   public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'customer_id' => $_POST['customer_id'],
            'tour_name'   => $_POST['tour_name'],
            'status'      => 'Chờ xác nhận',
            'booking_date'=> date('Y-m-d H:i:s')
        ];

        $this->booking->createBooking($data); 

        header("Location: index.php?action=bookingIndex");
        exit;
    } else {
        header("Location: index.php?action=bookingCreate");
        exit;
    }
}


    
}
