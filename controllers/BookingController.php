<?php
require_once __DIR__ . '/../models/Booking.php';
// Cần thêm model cho Tour nếu bạn muốn lấy danh sách Tour
// require_once __DIR__ . '/../models/Tour.php'; 

class BookingController
{
    private $booking;
    // private $tourModel; // Khai báo nếu dùng Tour Model

    public function __construct()
    {
        $this->booking = new Booking();
        // $this->tourModel = new Tour(); // Khởi tạo Tour Model
    }

    /**
     * Hiển thị form tạo booking, lấy dữ liệu phụ trợ: Staff, Supplier, Tour
     */
    public function create()
    {
        // 1. Lấy danh sách Nhân sự
        $staffs = $this->booking->getAllStaff(); 
        
        // 2. Lấy danh sách Nhà cung cấp
        $suppliers = $this->booking->getAllSuppliers();
        
        // 3. Lấy danh sách Tour (Nên dùng Tour Model nếu có, tạm dùng Booking Model nếu bạn thêm hàm)
        // $tours = $this->tourModel->getAll(); 
        // Vì bạn đã có cột tour_name trong form hiện tại, tôi sẽ không thêm tour model

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

        $customer_name   = $_POST['customer_name'];
        $customer_phone  = $_POST['customer_phone'];
        $tour_name       = $_POST['tour_name'];
        $tour_date       = $_POST['tour_date'];
        $special_request = $_POST['special_request'];
        $type            = $_POST['type']; // 'individual' hoặc 'group'
        
        // --- THÊM CÁC DỮ LIỆU TỪ BẢNG STAFF VÀ SUPPLIERS ---
        // Giả định các trường này được gửi từ form (dùng select box với id)
        $staff_id        = isset($_POST['staff_id']) ? (int)$_POST['staff_id'] : null;
        $supplier_id     = isset($_POST['supplier_id']) ? (int)$_POST['supplier_id'] : null;
        // -----------------------------------------------------

        // Xử lý số lượng tùy theo loại khách
        if ($type === 'individual') {
            $quantity = 1; // khách lẻ luôn là 1
        } else {
            $quantity = (int)$_POST['quantity']; // khách đoàn nhập số lượng
        }

        // Kiểm tra chỗ trống (Giữ nguyên logic kiểm tra, bạn có thể cần join với bảng tours để lấy max_slot)
        $max_slot = 30; 
        if ($quantity > $max_slot) {
            $error = "Số lượng quá lớn! Chỉ còn $max_slot chỗ trống.";
            // Gọi lại create để tải staff/supplier/tour nếu bạn cần hiển thị lại form
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
            
            // --- THÊM staff_id và supplier_id ---
            'staff_id'       => $staff_id, 
            'supplier_id'    => $supplier_id 
            // ------------------------------------
        ];

        $this->booking->createBooking($data);

        header("Location: index.php?action=bookingIndex");
        exit;
    }

    // Danh sách booking (Không cần thay đổi logic, vì model đã join lấy tên)
    public function index()
    {
        $bookings = $this->booking->getAll();
        include __DIR__ . '/../views/bookings/index.php';
    }

    // ... (Giữ nguyên updateStatus và history)
}