<?php
require_once __DIR__ . "/../models/HuongDanVien.php";

class HdvController {
    private $db;
    private $hdvModel;

    public function __construct($db_connection) {
        $this ->db = $db_connection;
        $this->model = new HuongDanVien($this ->db);
    }

    // Danh sách HDV
public function index()
{
    $nhom = $_GET['nhom'] ?? '';
    $hdvs = $this->model->getAll($nhom);

    include 'app/views/huong_dan_vien/index.php';

}

    // Form thêm
   // Form thêm HDV
public function create() {
    include __DIR__ . "/../views/huong_dan_vien/create.php";
}

// Xử lý thêm mới (store)
public function store() {
    $file = $_FILES['anh']['name'];
    $path = "uploads/" . $file;

    // Upload ảnh nếu có
    if (!empty($file)) {
        move_uploaded_file($_FILES['anh']['tmp_name'], $path);
    }

    $data = [
        "ho_ten" => $_POST['ho_ten'],
        "ngay_sinh" => $_POST['ngay_sinh'],
        "anh" => $file,
        "so_dien_thoai" => $_POST['so_dien_thoai'],
        "email" => $_POST['email'],
        "chung_chi" => $_POST['chung_chi'],
        "ngon_ngu" => $_POST['ngon_ngu'],
        "nam_kinh_nghiem" => $_POST['nam_kinh_nghiem'],
        "lich_su_tour" => $_POST['lich_su_tour'],
        "danh_gia" => $_POST['danh_gia'],
        "suc_khoe" => $_POST['suc_khoe'],
        "ghi_chu" => $_POST['ghi_chu'],
    ];

    $this->model->insert($data);

    header("Location: index.php?action=hdvIndex");
}


    // Form sửa
    public function edit() {
        $id = $_GET['id'];
        $hdv = $this->model->find($id);
        include __DIR__ . "/../views/huong_dan_vien/edit.php";
    }

    // Xử lý sửa
    public function update() {
        $id = $_POST['id'];
        $old = $this->model->find($id);

        // Nếu có upload ảnh mới
        if (!empty($_FILES["anh"]["name"])) {
            $file = $_FILES["anh"]["name"];
            $path = "uploads/" . $file;
            move_uploaded_file($_FILES["anh"]["tmp_name"], $path);
        } else {
            $file = $old["anh"];
        }

        $data = [
            "ho_ten" => $_POST['ho_ten'],
            "ngay_sinh" => $_POST['ngay_sinh'],
            "anh" => $file,
            "so_dien_thoai" => $_POST['so_dien_thoai'],
            "email" => $_POST['email'],
            "chung_chi" => $_POST['chung_chi'],
            "ngon_ngu" => $_POST['ngon_ngu'],
            "nam_kinh_nghiem" => $_POST['nam_kinh_nghiem'],
            "lich_su_tour" => $_POST['lich_su_tour'],
            "danh_gia" => $_POST['danh_gia'],
            "suc_khoe" => $_POST['suc_khoe'],
            "ghi_chu" => $_POST['ghi_chu'],
        ];

        $this->model->update($id, $data);
        header("Location: index.php?action=hdvIndex");
    }

    // Xóa
    public function delete() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: index.php?action=hdvIndex");
    }
}
