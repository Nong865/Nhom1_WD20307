<div class="container mt-4">
    <a href="index.php?action=listTours" class="btn btn-secondary mb-4">← Quay lại Danh sách Tour</a>
    
    <h3 class="mb-3">🖼️ Album ảnh Tour: <b><?= $tour['name'] ?? 'Không tìm thấy Tour' ?></b></h3>
    
    <a href="index.php?action=addPhoto&tour_id=<?= $tour['id'] ?>" class="btn btn-success mb-3">
        + Thêm Ảnh mới
    </a>

    <?php if (empty($photos)): ?>
        <div class="alert alert-warning" role="alert">
            Album này hiện chưa có ảnh nào.
        </div>
    <?php else: ?>
        
        <div class="row">
            <?php foreach ($photos as $photo): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="<?= $photo['image_path'] ?>" class="card-img-top" alt="<?= $photo['caption'] ?>">
                        <div class="card-body">
                            <p class="card-text small"><?= htmlspecialchars($photo['caption'] ?? 'Chưa có chú thích') ?></p>
                            
                            <a onclick="return confirm('Xóa ảnh này?')" 
                               href="index.php?action=deletePhoto&id=<?= $photo['id'] ?>&tour_id=<?= $tour['id'] ?>" 
                               class="btn btn-sm btn-danger">Xóa</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>