<?php
require_once 'models/PhotoModel.php';

class AlbumController
{
    protected $photoModel;

    public function __construct()
    {
        $this->photoModel = new PhotoModel();
    }

    // Hiển thị danh sách album theo tour
    public function editAlbum($tour_id)
    {
        // Lấy tất cả ảnh theo tour
        $photos = $this->photoModel->getAlbumByTour($tour_id);

        // Truyền dữ liệu ra view (giả sử bạn có view edit_album.php)
        require_once 'views/edit_album.php';
    }

    // Thêm ảnh mới
    public function addPhoto($tour_id, $image_path, $caption)
    {
        $insertId = $this->photoModel->addPhoto($tour_id, $image_path, $caption);

        if ($insertId) {
            echo "Thêm ảnh thành công!";
        } else {
            echo "Thêm ảnh thất bại!";
        }
    }

    // Xóa ảnh
    public function deletePhoto($photo_id)
    {
        $stmt = $this->photoModel->deletePhoto($photo_id);

        if ($stmt->rowCount() > 0) {
            echo "Xóa ảnh thành công!";
        } else {
            echo "Xóa ảnh thất bại!";
        }
    }

    // Cập nhật caption ảnh
    public function updateCaption($photo_id, $caption)
    {
        $stmt = $this->photoModel->updateCaption($photo_id, $caption);

        if ($stmt->rowCount() > 0) {
            echo "Cập nhật caption thành công!";
        } else {
            echo "Cập nhật caption thất bại!";
        }
    }
}
