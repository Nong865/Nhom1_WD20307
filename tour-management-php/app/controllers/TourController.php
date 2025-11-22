<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/Staff.php'; 
require_once __DIR__ . '/../models/Supplier.php'; 
require_once __DIR__ . '/../config/database.php';

class TourController {
    private $db;
    private $tourModel;
    private $staffModel;    
    private $supplierModel; 

    public function __construct() {
        global $conn;
        $this->db = $conn;
        $this->tourModel = new Tour($this->db);
        $this->staffModel = new Staff($this->db);
        $this->supplierModel = new Supplier($this->db);
    }

    public function listTours() {
        $tours = $this->tourModel->getAll();
        include __DIR__ . '/../views/admin/tours.php';
    }

    public function showAddForm() {
        $staff_list = $this->staffModel->getAll();
        $supplier_list = $this->supplierModel->getAll();
        include __DIR__ . '/../views/admin/addTour.php';
    }

    public function addTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Khai báo biến để lưu đường dẫn ảnh
            $main_image_path = null; 

            // 1. XỬ LÝ UPLOAD FILE
            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
                
                // Định nghĩa thư mục lưu trữ file (ví dụ: tour-management-php/public/uploads/)
                $upload_dir = __DIR__ . '/../../../public/uploads/'; 
                
                // Đảm bảo thư mục uploads tồn tại
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true); // Tạo thư mục nếu chưa có
                }

                $file_tmp = $_FILES['main_image']['tmp_name'];
                
                // Tạo tên file duy nhất để tránh trùng lặp
                $file_extension = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid('tour_img_') . '.' . $file_extension;
                $file_destination = $upload_dir . $file_name;

                // Di chuyển file từ thư mục tạm thời sang thư mục vĩnh viễn
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    // Lưu đường dẫn tương đối (để dùng trong thẻ <img>)
                    $main_image_path = 'public/uploads/' . $file_name; 
                }
            }
            // Hết xử lý file upload

            // 2. GÁN DỮ LIỆU VÀO MODEL
            $this->tourModel->name = $_POST['name'] ?? '';
            $this->tourModel->price = $_POST['price'] ?? 0;
            $this->tourModel->description = $_POST['description'] ?? '';
            $this->tourModel->start_date = $_POST['start_date'] ?? null;
            $this->tourModel->end_date = $_POST['end_date'] ?? null;
            
            // Các trường khóa ngoại
            $this->tourModel->staff_id = $_POST['staff_id'] ?? null; 
            $this->tourModel->supplier_id = $_POST['supplier_id'] ?? null; 
            
            // Gán đường dẫn ảnh chính đã xử lý
            $this->tourModel->main_image = $main_image_path; 
            
            // 3. TẠO TOUR
            $ok = $this->tourModel->create();
            if ($ok) {
                header('Location: index.php?action=listTours');
                exit;
            } else {
                echo "<p>Không thể thêm tour. Vui lòng thử lại.</p>";
            }
        }
    }
}
?>