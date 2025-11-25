<?php
// File: app/views/admin/album_view.php
include_once __DIR__ . '/../../../public/html/header.php';

// --- ĐỊNH NGHĨA BASE PATH ---
// Vui lòng chỉnh sửa giá trị này để khớp với cấu hình server của bạn
// Ví dụ: Nếu URL là http://localhost/duan1/tour-management-php/public/index.php
// thì base path là:
$base_path = '/duan1/tour-management-php/public/';
// --- KẾT THÚC ĐỊNH NGHĨA ---

?>

<div class="container mt-4">
    <h2 class="mb-4">Album Ảnh: <?php echo htmlspecialchars($tour_details['name'] ?? 'Tour'); ?></h2>

    <p>
        <a href="index.php?action=listTours" class="btn btn-secondary me-2">← Quay lại Danh sách Tour</a>
        <a href="index.php?action=addPhotoForm&tour_id=<?php echo htmlspecialchars($tour_details['id'] ?? ''); ?>"
            class="btn btn-success">Thêm Ảnh Mới</a>
    </p>
    <hr>

    <div class="row">
        <?php if (!empty($photos) && is_array($photos)): ?>
            <?php foreach ($photos as $photo):
                // Xử lý đường dẫn ảnh (đã được lưu là uploads/album/ten_file.jpg)
                // Sử dụng ?? '' để khắc phục lỗi Deprecated: str_replace
                $image_url_suffix = $photo['file_path'] ?? '';
            ?>
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <!-- Xây dựng URL hoàn chỉnh: $base_path + $image_url_suffix -->
                        <img src="<?php echo $base_path . htmlspecialchars($image_url_suffix); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($photo['caption'] ?? 'Ảnh Tour'); ?>"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <p class="card-text text-muted small">
                                <?php echo htmlspecialchars($photo['caption'] ?? 'Chưa có chú thích'); ?></p>
                            <a href="index.php?action=deletePhoto&id=<?php echo htmlspecialchars($photo['id']); ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('Xóa ảnh này?');">Xóa</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; // <-- Đóng vòng lặp foreach 
            ?>
        <?php else: ?>
            <p>Tour này chưa có ảnh trong Album. Vui lòng thêm ảnh mới.</p>
        <?php endif; // <-- Đóng câu lệnh if 
        ?>
    </div>
</div>