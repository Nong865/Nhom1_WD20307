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
        $this->db = connectDB();
        $this->tourModel = new Tour($this->db);
        $this->staffModel = new Staff($this->db);
        $this->supplierModel = new Supplier($this->db);
    }

    // Hiển thị danh sách tours
    public function listTours() {
        $tours = $this->tourModel->getAll();
        include __DIR__ . '/../views/admin/tours.php';
    }

    // Hiển thị form thêm tour
    public function showAddForm() {
        $staff_list = $this->staffModel->getAll();
        $supplier_list = $this->supplierModel->getAll();
        include __DIR__ . '/../views/admin/addTour.php';
    }

    // Thêm tour mới
    public function addTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $main_image_path = null;

            // Xử lý upload ảnh
            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../../../public/uploads/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

                $file_tmp = $_FILES['main_image']['tmp_name'];
                $file_ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid('tour_img_') . '.' . $file_ext;
                $file_destination = $upload_dir . $file_name;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $main_image_path = 'public/uploads/' . $file_name;
                }
            }

            // Gán dữ liệu từ form
            $this->tourModel->name = $_POST['name'] ?? '';
            $this->tourModel->price = $_POST['price'] ?? 0;
            $this->tourModel->description = $_POST['description'] ?? '';
            $this->tourModel->start_date = $_POST['start_date'] ?? null;
            $this->tourModel->end_date = $_POST['end_date'] ?? null;
            $this->tourModel->staff_id = $_POST['staff_id'] ?? null;
            $this->tourModel->supplier_id = $_POST['supplier_id'] ?? null;
            $this->tourModel->main_image = $main_image_path;

            // Tạo tour
            if ($this->tourModel->create()) {
                header('Location: index.php?action=listTours');
                exit;
            } else {
                echo "<p>Không thể thêm tour. Vui lòng thử lại.</p>";
            }
        }
    }
}
?>
