<?php

class Photo {
    private $conn;
    private $table = 'photos'; 

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lấy danh sách ảnh album theo tour_id
     */
    public function getPhotosByTourId($tour_id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE tour_id = ? ORDER BY id DESC");
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm một ảnh mới vào bảng
     */
   public function insertPhoto($data) {
    // SỬA TÊN CỘT TẠI ĐÂY (Ví dụ: thay 'file_path' bằng 'image_url')
    $sql = "INSERT INTO {$this->table} (tour_id, file_path, caption, is_main) VALUES (?, ?, ?, ?)"; 
    
    $stmt = $this->conn->prepare($sql);
    
    return $stmt->execute([
        $data['tour_id'],
        $data['file_path'], // Biến $data['file_path'] vẫn được truyền
        $data['caption'] ?? null,
        $data['is_main'] ?? 0
    ]);
}
}
?>