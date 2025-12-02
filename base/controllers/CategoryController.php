<?php
require_once dirname(__DIR__) . '/configs/helper.php'; 
require_once dirname(__DIR__) . '/models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    // Action: index (index.php?controller=Category&action=index)
    // Hiển thị danh sách Danh mục và Form Thêm mới
    public function index()
    {
        // 1. Lấy tất cả danh mục
        $categories = $this->categoryModel->getAll();
        
        // Lấy thông báo (nếu có)
        $message = $_GET['message'] ?? '';
        $type = $_GET['type'] ?? '';
        $active = 'category'; 
        $title = 'Quản lý Danh mục Tour';

        // 2. TẠO NỘI DUNG VIEW và lưu vào biến $content
        $content = render("categories/index", [ 
            'categories' => $categories,
            'message' => $message,
            'type' => $type
        ]);

        // 3. Load Layout Chính (sử dụng đường dẫn tuyệt đối)
        include dirname(__DIR__) . "/views/main.php"; 
    }

    // Action: store (Xử lý POST từ form Thêm mới)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Category&action=index');
            exit;
        }

        $data = ['name' => trim($_POST['name'] ?? '')];

        if (empty($data['name'])) {
            header('Location: index.php?controller=Category&action=index&message=Tên danh mục không được để trống&type=danger');
            exit;
        }

        $result = $this->categoryModel->insert($data);

        if ($result) {
            header('Location: index.php?controller=Category&action=index&message=Thêm danh mục thành công&type=success');
        } else {
            header('Location: index.php?controller=Category&action=index&message=Lỗi cơ sở dữ liệu khi thêm&type=danger');
        }
        exit;
    }

    // Action: edit (index.php?controller=Category&action=edit&id=X)
    // Hiển thị form chỉnh sửa
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id || !($category = $this->categoryModel->find($id))) {
            header('Location: index.php?controller=Category&action=index&message=Không tìm thấy danh mục&type=danger');
            exit;
        }
        
        // Lấy thông báo (nếu có)
        $message = $_GET['message'] ?? '';
        $type = $_GET['type'] ?? '';
        $active = 'category';
        $title = 'Chỉnh sửa Danh mục';
        
        // TẠO NỘI DUNG VIEW và lưu vào biến $content
        $content = render("categories/edit", [
            'category' => $category,
            'message' => $message,
            'type' => $type
        ]);

        // Load Layout Chính
        include dirname(__DIR__) . "/views/main.php"; 
    }

    // Action: update (Xử lý POST từ form Chỉnh sửa)
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Category&action=index');
            exit;
        }
        
        $id = $_POST['id'] ?? null;
        $data = ['name' => trim($_POST['name'] ?? '')];

        if (!$id) {
            header('Location: index.php?controller=Category&action=index&message=Thiếu ID danh mục&type=danger');
            exit;
        }
        
        if (empty($data['name'])) {
            header('Location: index.php?controller=Category&action=edit&id='.$id.'&message=Tên danh mục không được để trống&type=danger');
            exit;
        }

        $result = $this->categoryModel->update($id, $data);

        if ($result) {
            header('Location: index.php?controller=Category&action=index&message=Cập nhật danh mục thành công&type=success');
        } else {
            header('Location: index.php?controller=Category&action=index&message=Lỗi cơ sở dữ liệu khi cập nhật&type=danger');
        }
        exit;
    }
    
    // Action: delete (index.php?controller=Category&action=delete&id=X)
    public function delete()
{
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header('Location: index.php?controller=Category&action=index&message=Thiếu ID danh mục cần xóa&type=danger');
        exit;
    }
    
    // BỔ SUNG: Logic xử lý các Tour đang dùng Danh mục này (tránh lỗi khóa ngoại)
    // 1. Khởi tạo TourModel (đã require_once ở trên)
    $tourModel = new TourModel(); 
    
    // 2. Đặt category_id của tất cả các tour liên quan về NULL
    $tourModel->setCategoryToNull($id); 

    // 3. Tiến hành xóa Danh mục (sau khi đã xử lý khóa ngoại)
    $result = $this->categoryModel->delete($id);

    if ($result) {
        header('Location: index.php?controller=Category&action=index&message=Xóa danh mục thành công&type=success');
    } else {
        header('Location: index.php?controller=Category&action=index&message=Xóa danh mục thất bại&type=danger');
    }
    exit;
}
}