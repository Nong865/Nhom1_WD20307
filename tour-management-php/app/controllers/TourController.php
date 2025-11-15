<?php
// File: app/controllers/TourController.php

// 1. IMPORT TẤT CẢ CÁC MODEL CẦN THIẾT
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/Staff.php'; 
require_once __DIR__ . '/../models/Supplier.php'; 
require_once __DIR__ . '/../models/Photo.php'; // KHẮC PHỤC LỖI CLASS NOT FOUND
require_once __DIR__ . '/../config/database.php';

class TourController {
    private $db;
    private $tourModel;
    private $staffModel;    
    private $supplierModel; 
    private $photoModel; 

    public function __construct() {
        global $conn;
        $this->db = $conn;
        
        // Khởi tạo các Model
        $this->tourModel = new Tour($this->db);
        $this->staffModel = new Staff($this->db);
        $this->supplierModel = new Supplier($this->db);
        $this->photoModel = new Photo($this->db); 
    }

    public function listTours() {
        $tours = $this->tourModel->getAll();
        include __DIR__ . '/../views/admin/tours.php';
    }

    public function showAddForm() {
        // Lấy dữ liệu cho dropdowns
        $staff_list = $this->staffModel->getAll();
        $supplier_list = $this->supplierModel->getAll();
        
        include __DIR__ . '/../views/admin/addTour.php';
    }

    public function showEditForm() {
        $id = $_GET['id'] ?? null;
        
        if (!$id || !is_numeric($id)) {
            header('Location: index.php?action=listTours');
            exit;
        }

        $tour = $this->tourModel->getTourById($id);
        if (!$tour) {
            header('Location: index.php?action=listTours');
            exit;
        }

        $staff_list = $this->staffModel->getAll();
        $supplier_list = $this->supplierModel->getAll();

        include __DIR__ . '/../views/admin/editTourForm.php';
    }

    // HÀM XỬ LÝ XEM ALBUM ẢNH
    public function viewAlbum() {
        $tour_id = $_GET['tour_id'] ?? null;

        if (!$tour_id || !is_numeric($tour_id)) {
            header('Location: index.php?action=listTours');
            exit;
        }

        $photos = $this->photoModel->getPhotosByTourId($tour_id);
        $tour_details = $this->tourModel->getTourById($tour_id); 
        
        include __DIR__ . '/../views/admin/album_view.php';
    }

    public function addTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $main_image_path = null; 

            // 1. XỬ LÝ UPLOAD FILE
            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
                
                $upload_dir = __DIR__ . '/../../../public/uploads/'; 
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true); 
                }

                $file_tmp = $_FILES['main_image']['tmp_name'];
                $file_extension = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid('tour_img_') . '.' . $file_extension;
                $file_destination = $upload_dir . $file_name;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $main_image_path = 'public/uploads/' . $file_name; 
                }
            }

            // 2. GÁN DỮ LIỆU VÀO MODEL
            $this->tourModel->name = $_POST['name'] ?? '';
            $this->tourModel->price = $_POST['price'] ?? 0;
            $this->tourModel->description = $_POST['description'] ?? '';
            $this->tourModel->start_date = $_POST['start_date'] ?? null;
            $this->tourModel->end_date = $_POST['end_date'] ?? null;
            
            $this->tourModel->staff_id = $_POST['staff_id'] ?? null; 
            $this->tourModel->supplier_id = $_POST['supplier_id'] ?? null; 
            
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
    
    public function editTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: index.php?action=listTours');
                exit;
            }

            $old_tour = $this->tourModel->getTourById($id);
            $main_image_path = $old_tour['main_image'] ?? null;

            // XỬ LÝ UPLOAD FILE MỚI
            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../../../public/uploads/'; 
                
                $file_tmp = $_FILES['main_image']['tmp_name'];
                $file_extension = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid('tour_img_') . '.' . $file_extension;
                $file_destination = $upload_dir . $file_name;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $main_image_path = 'public/uploads/' . $file_name; 
                    // Tùy chọn: Xóa file ảnh cũ
                }
            }
            
            // GÁN DỮ LIỆU VÀ GỌI UPDATE
            $this->tourModel->id = $id;
            $this->tourModel->name = $_POST['name'] ?? '';
            $this->tourModel->price = $_POST['price'] ?? 0;
            $this->tourModel->description = $_POST['description'] ?? '';
            $this->tourModel->start_date = $_POST['start_date'] ?? null;
            $this->tourModel->end_date = $_POST['end_date'] ?? null;
            $this->tourModel->staff_id = $_POST['staff_id'] ?? null; 
            $this->tourModel->supplier_id = $_POST['supplier_id'] ?? null; 
            $this->tourModel->main_image = $main_image_path; 
            
            $ok = $this->tourModel->update();
            if ($ok) {
                header('Location: index.php?action=listTours');
                exit;
            } else {
                echo "<p>Không thể cập nhật tour. Vui lòng thử lại.</p>";
            }
        }
    }

    public function deleteTour() {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            header('Location: index.php?action=listTours');
            exit;
        }

        // Tùy chọn: Xóa file ảnh liên quan trước khi xóa bản ghi
        $ok = $this->tourModel->delete($id);

        if ($ok) {
            header('Location: index.php?action=listTours');
            exit;
        } else {
            echo "<p>Không thể xóa tour. Vui lòng thử lại.</p>";
        }
    }
}
?>