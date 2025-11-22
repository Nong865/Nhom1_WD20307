<?php
require_once 'BaseModel.php';

class PhotoModel extends BaseModel {
    protected $table = 'photos'; // bảng mặc định

    // Lấy album theo tour
    public function getAlbumByTour($tour_id) {
        $sql = "SELECT * FROM photos WHERE tour_id = ?";
        return $this->queryAll($sql, [$tour_id]);
    }

    // Thêm ảnh album
    public function addPhoto($tour_id, $path, $caption) {
        $sql = "INSERT INTO photos (tour_id, image_path, caption) VALUES (?, ?, ?)";
        return $this->insertRaw($sql, [$tour_id, $path, $caption]);
    }

    // Xóa 1 ảnh
    public function deletePhoto($id) {
        $sql = "DELETE FROM photos WHERE id = ?";
        return $this->query($sql, [$id]); // trả về statement, bạn có thể kiểm tra rowCount
    }

    // Cập nhật caption
    public function updateCaption($id, $caption) {
        $sql = "UPDATE photos SET caption = ? WHERE id = ?";
        return $this->query($sql, [$caption, $id]); // trả về statement
    }
}
