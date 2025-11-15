<?php
class Supplier {
    private $conn;
    private $table = 'suppliers'; // Đảm bảo tên bảng này khớp với Database

    public function __construct($db) {
        $this->conn = $db;
    }

    // HÀM ĐÃ SỬA: Chỉ lấy ID và Name để điền vào dropdown (Không JOIN)
    public function getAll() {
        $sql = "SELECT id, name
                FROM {$this->table}
                ORDER BY name ASC"; // Sắp xếp theo tên để dễ chọn

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm thêm nhà cung cấp (CRUD)
    public function create($name, $type_id, $phone, $address) {
        $sql = "INSERT INTO {$this->table} (name, type_id, phone, address)
                VALUES (:name, :type_id, :phone, :address)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        return $stmt->execute();
    }

    // Hàm xóa nhà cung cấp (CRUD)
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>