<?php

require_once __DIR__ . "/../models/SupplierModel.php";

class SupplierController
{
    private $sup;

    public function __construct()
    {
        $this->sup = new SupplierModel();
    }

    /* ============================================================
        HIỂN THỊ DANH SÁCH NHÀ CUNG CẤP
    ============================================================ */
    public function index()
    {
         requireRole([1, 4]);
        $suppliers = $this->sup->getAll();

        // Thông tin cho layout
        $title  = "Danh sách Nhà cung cấp";
        $active = "ncc";

        ob_start();
        include __DIR__ . "/../views/supplier/index.php";
        $content = ob_get_clean();

        include __DIR__ . "/../views/main.php";
    }


    /* ============================================================
        FORM THÊM
    ============================================================ */
    public function add()
    {
         requireRole([1, 4]);
        $types = $this->sup->getTypes();

        $title  = "Thêm Nhà cung cấp";
        $active = "ncc";

        ob_start();
        include __DIR__ . "/../views/supplier/add.php";
        $content = ob_get_clean();

        include __DIR__ . "/../views/main.php";
    }

    /* ============================================================
        LƯU NHÀ CUNG CẤP MỚI
    ============================================================ */
   public function store()
{
    $data = $_POST;

    // --- Chuyển chuỗi rỗng thành NULL cho cột capacity ---
    $data['capacity'] = ($data['capacity'] === '') ? null : (int)$data['capacity'];

    // Gọi model để lưu
    $this->sup->store($data);

    header("Location: index.php?action=supplierIndex");
    exit;
}


    /* ============================================================
        FORM SỬA
    ============================================================ */
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die("Thiếu ID nhà cung cấp!");

        $supplier = $this->sup->getById($id);
        $types    = $this->sup->getTypes();

        $title  = "Sửa Nhà cung cấp";
        $active = "ncc";

        ob_start();
        include __DIR__ . "/../views/supplier/edit.php";
        $content = ob_get_clean();

        include __DIR__ . "/../views/main.php";
    }


    /* ============================================================
        CẬP NHẬT NHÀ CUNG CẤP
    ============================================================ */
    public function update()
    {
         requireRole([1, 4]);
        $id = $_POST['id'] ?? null;
        if (!$id) die("Thiếu ID!");

        $this->sup->updateSupplier($id, $_POST);

        header("Location: index.php?action=supplierIndex");
        exit;
    }


    /* ============================================================
        XÓA NHÀ CUNG CẤP
    ============================================================ */
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die("Thiếu ID!");

        $this->sup->deleteSupplier($id);

        header("Location: index.php?action=supplierIndex");
        exit;
    }
}
