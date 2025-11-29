<?php
require_once __DIR__ . '/../models/Booking.php';

class BookingController
{
    private $booking;


    public function __construct()
    {
        $this->booking = new Booking();
    
    }

    /**
     * Hiển thị form tạo booking, lấy dữ liệu phụ trợ: Staff, Supplier
     */
    public function create()
    {
        $staffs = $this->booking->getAllStaff(); 
        $suppliers = $this->booking->getAllSuppliers();
        
        include __DIR__ . '/../views/bookings/create.php';
    }

    /**
     * Lưu booking (Thêm staff_id và supplier_id)
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingCreate");
            exit;
        }

        $customer_name  = $_POST['customer_name'];
        $customer_phone = $_POST['customer_phone'];
        $tour_name = $_POST['tour_name'];
        $tour_date  = $_POST['tour_date'];
        $special_request = $_POST['special_request'];
        $type = $_POST['type']; 
        
        $staff_id = isset($_POST['staff_id']) ? (int)$_POST['staff_id'] : null;
        $supplier_id = isset($_POST['supplier_id']) ? (int)$_POST['supplier_id'] : null;
        
        if ($type === 'individual') {
            $quantity = 1; 
        } else {
            $quantity = (int)$_POST['quantity']; 
        }

        // Kiểm tra chỗ trống 
        $max_slot = 30; 
        if ($quantity > $max_slot) {
            $error = "Số lượng quá lớn! Chỉ còn $max_slot chỗ trống.";
            $this->create(); // Load lại form với lỗi
            return;
        }

        $data = [
            'customer_name' => $customer_name,
            'customer_phone' => $customer_phone,
            'quantity'  => $quantity,
            'tour_name' => $tour_name,
            'tour_date' => $tour_date,
            'special_request'=> $special_request,
            'type'  => $type,
            'status' => 'Chờ xác nhận',
            'booking_date' => date('Y-m-d H:i:s'),
            'staff_id' => $staff_id, 
            'supplier_id' => $supplier_id 
        ];

        $this->booking->createBooking($data);

        header("Location: index.php?action=bookingIndex");
        exit;
    }

    /**
     * Danh sách booking
     */
    public function index()
    {
        $bookings = $this->booking->getAll();
        include __DIR__ . '/../views/bookings/index.php';
    }

    /**
     * Cập nhật trạng thái và lưu lịch sử
     */
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=bookingIndex");
            exit;
        }

        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$id || !$status) {
            die("Thiếu dữ liệu để cập nhật trạng thái booking!");
        }

        // Gọi hàm Model đã được cập nhật để lưu lịch sử
        $result = $this->booking->updateStatus($id, $status); 
        
        if (!$result) {
            die("Lỗi khi cập nhật trạng thái hoặc lưu lịch sử!");
        }

        header("Location: index.php?action=bookingIndex");
        exit;
    }

    /**
     * Hiển thị lịch sử trạng thái
     */
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