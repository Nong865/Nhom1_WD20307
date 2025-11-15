<?php 
// File: app/views/admin/album_view.php
include_once __DIR__ . '/../../../public/html/header.php'; 
?>

<div class="container mt-4">
    <h2 class="mb-4">Album Ảnh: <?php echo htmlspecialchars($tour_details['name'] ?? 'Tour'); ?></h2>
    
    <p>
        <a href="index.php?action=listTours" class="btn btn-secondary me-2">← Quay lại Danh sách Tour</a>
        <a href="index.php?action=addPhotoForm&tour_id=<?php echo htmlspecialchars($tour_details['id'] ?? ''); ?>" class="btn btn-success">Thêm Ảnh Mới</a>
    </p>
    <hr>

    <div class="row">
        <?php if (!empty($photos)): ?>
            <?php foreach ($photos as $photo): 
                // Xử lý đường dẫn ảnh (giả định $base_path đã được định nghĩa trong header.php)
                $display_path = str_replace('public/', '', $photo['image_path']);
            ?>
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="<?php echo $base_path . htmlspecialchars($display_path); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($photo['caption'] ?? 'Ảnh Tour'); ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <p class="card-text text-muted small"><?php echo htmlspecialchars($photo['caption'] ?? 'Chưa có chú thích'); ?></p>
                            <a href="index.php?action=deletePhoto&id=<?php echo htmlspecialchars($photo['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa ảnh này?');">Xóa</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; // <-- Đóng vòng lặp foreach ?>
        <?php else: ?>
            <p>Tour này chưa có ảnh trong Album. Vui lòng thêm ảnh mới.</p>
        <?php endif; // <-- Đóng câu lệnh if ?>
    </div>
</div>

<?php 
// LỆNH INCLUDE CUỐI CÙNG: Khắc phục lỗi "unexpected end of file"
include_once __DIR__ . '/../../../public/html/footer.php'; 
?>