<?php

require_once "BaseModel.php";

class CategoryModel extends BaseModel
{
    // Chỉ định bảng làm việc
    protected $table = "categories";

    /**
     * Lấy tất cả danh mục kèm theo số lượng Tour liên quan (tour_count)
     * @return array Danh sách danh mục kèm số lượng tour
     */
    public function getAll()
    {
        $sql = "SELECT 
                    c.*, 
                    COUNT(t.id) AS tour_count
                FROM categories c
                LEFT JOIN tours t ON c.id = t.category_id
                GROUP BY c.id, c.name, c.created_at /* GROUP BY tất cả các cột không phải là aggregate (đã thêm c.created_at) */
                ORDER BY c.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm danh mục mới
     * @param array $data chứa 'name'
     * @return bool
     */
    public function insert($data, $tableName = null)
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
        // Lưu ý: Cần xử lý liên kết tour trước khi gọi hàm này (đã xử lý trong Controller)
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}