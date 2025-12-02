<?php

require_once "BaseModel.php";

class CategoryModel extends BaseModel
{
    // Chỉ định bảng làm việc
    protected $table = "categories";

    /**
     * Lấy tất cả danh mục
     * (Chúng ta sẽ không cần getAllCategories() trong TourModel nữa nếu dùng Model này)
     */
    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT id, name FROM {$this->table} ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm danh mục mới
     * @param array $data chứa 'name'
     * @return bool
     */
    public function insert($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (name) VALUES (?)");
        return $stmt->execute([$data['name']]);
    }

    /**
     * Lấy một danh mục theo ID
     * @param int $id ID của danh mục
     * @return array|false
     */
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật thông tin danh mục
     * @param int $id ID của danh mục
     * @param array $data chứa 'name' mới
     * @return bool
     */
    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET name=? WHERE id=?");
        return $stmt->execute([$data['name'], $id]);
    }

    /**
     * Xóa danh mục
     * @param int $id ID của danh mục
     * @return bool
     */
    public function delete($id)
    {
        // Lưu ý: Cần xử lý liên kết tour trước khi xóa danh mục
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}