<?php
require_once "./configs/auth.php";
require_once "./models/User.php";

class UserController {

   public function index() {
    // 1. Kiểm tra quyền và Lấy dữ liệu
    requireRole([1]); // Giả sử hàm này kiểm tra quyền Admin
    $model = new User(); // Giả sử class User là Model
    $users = $model->getAll();

    // 2. Định nghĩa các biến cho Layout
    $active = 'user';
    $title = 'Quản lý Tài khoản'; // Đặt tiêu đề trang

    // 3. Dùng hàm render() để tải View và lưu nội dung vào $content
    // Giả sử View nằm ở views/user/index.php
    $content = render("user/index", [
        'users' => $users,
        'title' => $title,
        'active' => $active
    ]);

    // 4. Load Layout Chính (File main.php sẽ hiển thị biến $content)
    require dirname(__DIR__) . "/views/main.php"; 
}

    public function create() {
        requireRole([1]);

        $active = 'user';
        $content = "./views/user/add.php";

        require "./views/main.php";
    }

    public function store() {
        requireRole([1]);

        $model = new User();
        $model->create($_POST);

        header("Location: index.php?action=userIndex");
        exit;
    }
    public function edit() {
        requireRole([1]);

        $model = new User();
        $user = $model->find($_GET['id']);

        $content = "./views/user/edit.php";
        $active = "user";
        require "./views/main.php";
    }

    public function update() {
        requireRole([1]);

        $model = new User();
        $model->update($_POST['id'], $_POST);

        header("Location: index.php?action=userIndex");
        exit;
    }

    public function delete() {
        requireRole([1]);

        $model = new User();
        $model->delete($_GET['id']);

        header("Location: index.php?action=userIndex");
        exit;
    }
}