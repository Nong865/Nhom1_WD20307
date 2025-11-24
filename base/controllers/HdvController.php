<?php
require_once "models/HuongDanVien.php";

class HdvController
{
    private $hdv;

    public function __construct()
    {
        $this->hdv = new HuongDanVien();
    }

    public function index()
{
     requireRole([1, 2]);
    $title = "Danh sách HDV";
    $active = "hdv";

    // Lấy tất cả nhóm để hiển thị dropdown
    $groups = $this->hdv->getGroups();

    // Lấy giá trị filter từ GET
    $groupFilter = $_GET['group'] ?? null;

    if ($groupFilter) {
        $data = $this->hdv->getAllByGroup($groupFilter);
    } else {
        $data = $this->hdv->getAllWithGroups();
    }

    ob_start();
    include "views/hdv/index.php";
    $content = ob_get_clean();

    include "views/main.php";
}

    public function create()
    {
         requireRole([1, 2]);
        $title = "Thêm nhân viên";
        
        $active = "hdv";

        $groups = $this->hdv->getGroups();

        ob_start();
        include "views/hdv/add.php";
        $content = ob_get_clean();

        include "views/main.php";
    }

    public function store()
    {
        $data = [
            "ho_ten" => $_POST['ho_ten'],
            "ngay_sinh" => $_POST['ngay_sinh'],
            "so_dien_thoai" => $_POST['so_dien_thoai'],
            "email" => $_POST['email'],
            "chung_chi" => $_POST['chung_chi'],
            "ngon_ngu" => $_POST['ngon_ngu'],
            "nam_kinh_nghiem" => $_POST['nam_kinh_nghiem'],
            "danh_gia" => $_POST['danh_gia'],
            "suc_khoe" => $_POST['suc_khoe'],
            "ghi_chu" => $_POST['ghi_chu'],
        ];

        // Upload ảnh
        if (!empty($_FILES['anh']['name'])) {
            $filename = time() . "_" . $_FILES['anh']['name'];
            move_uploaded_file($_FILES['anh']['tmp_name'], "assets/uploads/" . $filename);
            $data['anh'] = $filename;
        }

        $id = $this->hdv->insert($data);

        $this->hdv->saveGroups($id, $_POST['groups'] ?? []);

        header("Location: index.php?action=hdvIndex");
    }

    public function edit()
    {
         requireRole([1, 2]);
        $id = $_GET['id'];

        $title = "Sửa thông tin HDV";
        $active = "hdv";

        $row = $this->hdv->find($id);
        $groups = $this->hdv->getGroups();
        $myGroups = array_column($this->hdv->getHdvGroups($id), 'nhom_id');

        ob_start();
        include "views/hdv/edit.php";
        $content = ob_get_clean();

        include "views/main.php";
    }

    public function update()
    {
         
        $id = $_POST['id'];

        $data = [
            "ho_ten" => $_POST['ho_ten'],
            "ngay_sinh" => $_POST['ngay_sinh'],
            "so_dien_thoai" => $_POST['so_dien_thoai'],
            "email" => $_POST['email'],
            "chung_chi" => $_POST['chung_chi'],
            "ngon_ngu" => $_POST['ngon_ngu'],
            "nam_kinh_nghiem" => $_POST['nam_kinh_nghiem'],
            "danh_gia" => $_POST['danh_gia'],
            "suc_khoe" => $_POST['suc_khoe'],
            "ghi_chu" => $_POST['ghi_chu'],
        ];

        if (!empty($_FILES['anh']['name'])) {
            $filename = time() . "_" . $_FILES['anh']['name'];
            move_uploaded_file($_FILES['anh']['tmp_name'], "assets/uploads/" . $filename);
            $data['anh'] = $filename;
        }

        $this->hdv->update($id, $data);

        $this->hdv->saveGroups($id, $_POST['groups'] ?? []);

        header("Location: index.php?action=hdvIndex");
    }

    public function delete()
    {
         requireRole([1, 2]);
        $id = $_GET['id'];
        $this->hdv->delete($id);

        header("Location: index.php?action=hdvIndex");
    }
    public function filler()
{
    $title = "Danh sách HDV";
    $active = "hdv";

    // Lấy tất cả nhóm để hiển thị filter
    $groups = $this->hdv->getGroups();

    // Lấy giá trị filter từ GET
    $groupFilter = $_GET['group'] ?? null;

    if ($groupFilter) {
        // Lấy HDV theo nhóm
        $data = $this->hdv->getAllByGroup($groupFilter);
    } else {
        // Lấy tất cả HDV
        $data = $this->hdv->getAllWithGroups();
    }

    ob_start();
    include "views/hdv/index.php";
    $content = ob_get_clean();

    include "views/main.php";
}

}
