<?php
// File: app/views/admin/album_view.php

include_once __DIR__ . '/../../../public/html/header.php';

/* ----------------------------------------
    ĐỊNH NGHĨA BASE PATH ĐỂ HIỂN THỊ ĐÚNG ẢNH
----------------------------------------- */

// Ví dụ nếu ảnh thật ở: 
//     /tour-management-php/public/uploads/album/xyz.jpg
// thì base_path phải trỏ đến thư mục public của bạn

$base_path = '/tour-management-php/public/';  
?>

<div class="container mt-4">
    <h2 class="mb-4">Album Ảnh: <?php echo htmlspecialchars($tour_details['name'] ?? 'Tên tour'); ?></h2>

    <p>
        <a href="index.php?action=listTours" class="btn btn-secondary me-2">← Quay lại Danh sách Tour</a>
        <a href="index.php?action=addPhotoForm&tour_id=<?php echo htmlspecialchars($tour_details['id'] ?? ''); ?>"
           class="btn btn-success">Thêm Ảnh Mới</a>
    </p>
    <hr>

    <div class="row">
        <?php if (!empty($photos) && is_array($photos)): ?>
            <?php foreach ($photos as $photo): ?>

                <?php
                    // ảnh được lưu như uploads/album/ten_file.jpg
                    $image_suffix = $photo['file_path'] ?? '';
                    $image_full_url = $base_path . $image_suffix;
                ?>

                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($image_full_url); ?>"
                             class="card-img-top"
                             alt="<?php echo htmlspecialchars($photo['caption'] ?? 'Ảnh tour'); ?>"
                             style="height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <p class="card-text text-muted small">
                                <?php echo htmlspecialchars($photo['caption'] ?? 'Chưa có mô tả'); ?>
                            </p>

                            <a href="index.php?action=deletePhoto&id=<?php echo htmlspecialchars($photo['id']); ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn có chắc muốn xóa ảnh này?');">
                                Xóa
                            </a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Tour này chưa có ảnh. Vui lòng thêm ảnh mới.</p>
        <?php endif; ?>
    </div>
</div>
