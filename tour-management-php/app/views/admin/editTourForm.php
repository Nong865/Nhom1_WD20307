<?php 
    include_once __DIR__ . '/../../../public/html/header.php';
    if (!empty($tour['main_image'])): 
    $display_path = str_replace('public/', '', $tour['main_image']);
 ?>

<div class="container">
    <h2 class="mb-4">Sửa Tour: <?php echo htmlspecialchars($tour['name'] ?? 'Không rõ'); ?></h2>
    
    <form method="post" action="index.php?action=editTour" enctype="multipart/form-data">
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour['id'] ?? ''); ?>">
        
        <div class="mb-3">
            <label for="name" class="form-label">Tên Tour:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($tour['name'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá (VND):</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($tour['price'] ?? ''); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="staff_id" class="form-label">Nhân sự Phụ trách:</label>
            <select class="form-select" id="staff_id" name="staff_id" required>
                <option value="">-- Chọn Nhân sự --</option>
                <?php 
                if (!empty($staff_list)) {
                    foreach ($staff_list as $staff) {
                        // So sánh ID cũ để chọn (selected)
                        $selected = ($staff['id'] == ($tour['staff_id'] ?? 0)) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($staff['id']) . '" ' . $selected . '>' . htmlspecialchars($staff['name']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="supplier_id" class="form-label">Nhà Cung cấp:</label>
            <select class="form-select" id="supplier_id" name="supplier_id" required>
                <option value="">-- Chọn Nhà cung cấp --</option>
                <?php 
                if (!empty($supplier_list)) {
                    foreach ($supplier_list as $supplier) {
                        // So sánh ID cũ để chọn (selected)
                        $selected = ($supplier['id'] == ($tour['supplier_id'] ?? 0)) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($supplier['id']) . '" ' . $selected . '>' . htmlspecialchars($supplier['name']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="main_image" class="form-label">Ảnh Chính Mới (Để trống nếu không thay đổi):</label>
            <input type="file" class="form-control" id="main_image" name="main_image">
            <?php if (!empty($tour['main_image'])): ?>
                <small class="form-text text-muted">Ảnh cũ: <small class="form-text text-muted">Ảnh cũ: <img src="<?php echo $base_path . htmlspecialchars($tour['main_image']); ?>" style="width: 50px; height: auto;" alt="Ảnh cũ"></small>
                <input type="hidden" name="current_main_image" value="<?php echo htmlspecialchars($tour['main_image']); ?>">
            <?php endif; ?>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Ngày Bắt đầu:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($tour['start_date'] ?? ''); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">Ngày Kết thúc:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($tour['end_date'] ?? ''); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($tour['description'] ?? ''); ?></textarea>
        </div>


        <button type="submit" class="btn btn-warning me-2">Lưu Thay Đổi</button>
        <a href="index.php?action=listTours" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php include_once __DIR__ . '/../../../public/html/footer.php'; ?>