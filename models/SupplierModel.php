<?php

class SupplierModel extends BaseModel
{
    protected $table = "partners";   // Quan trọng: BaseModel cần thuộc tính này
    protected $key = "id";

    // Lấy tất cả nhà cung cấp + loại
    public function getAll()
    {
        $sql = "
            SELECT s.*, t.name AS type_name
            FROM partners s
            LEFT JOIN partner_types t ON s.type_id = t.id
            ORDER BY s.id ASC
        ";
        return $this->queryAll($sql);
    }

    // Lấy 1 nhà cung cấp
    public function getById($id)
    {
        return $this->find($id); // BaseModel chuẩn
    }

    // Lấy tất cả loại nhà cung cấp
    public function getTypes()
    {
        $sql = "SELECT * FROM partner_types ORDER BY id ASC";
        return $this->queryAll($sql);
    }

    // Thêm nhà cung cấp mới
    public function store($data)
    {
        return $this->insert($data); // BaseModel insert chuẩn
    }

    // Cập nhật nhà cung cấp
    public function updateSupplier($id, $data)
    {
        return $this->update($id, $data); // BaseModel update chuẩn
    }

    // Xóa nhà cung cấp
    public function deleteSupplier($id)
    {
        return $this->delete($id); // BaseModel delete chuẩn
    }
}
