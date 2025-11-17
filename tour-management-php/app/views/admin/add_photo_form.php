<?php

if (!isset($tour_details)) {
    header('Location: index.php?action=listTours');
    exit;
}
?>
<div class="container mt-5">
    <h2>Thêm Ảnh Mới cho Tour: <?php echo htmlspecialchars($tour_details['name']); ?></h2>
    <p>ID Tour: #<?php echo htmlspecialchars($tour_details['id']); ?></p>
    <hr>
    
    <form action="index.php?action=addPhoto" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour_details['id']); ?>">

        <div class="form-group mb-3">
            <label for="image_file" class="form-label">Chọn Ảnh (Có thể chọn nhiều file):</label>
            <input type="file" class="form-control" name="photo_files[]" id="image_file" multiple required>
        </div>
        
        <div class="form-group mb-4">
            <label for="caption" class="form-label">Mô tả (tùy chọn):</label>
            <input type="text" class="form-control" name="caption" id="caption" maxlength="255">
        </div>

        <button type="submit" class="btn btn-primary">Tải Lên và Lưu Album</button>
        <a href="index.php?action=viewAlbum&tour_id=<?php echo htmlspecialchars($tour_details['id']); ?>" class="btn btn-secondary">Quay lại Album</a>
    </form>
</div>