<?php include_once __DIR__ . '/../../../public/html/header.php'; ?>

<div class="container">
    <h2 class="mb-4">Thêm Tour Mới</h2>
    
    <form method="post" action="index.php?action=addTour" enctype="multipart/form-data">
        
        <div class="mb-3">
            <label for="name" class="form-label">Tên Tour:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá (VND):</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        
        <div class="mb-3">
            <label for="staff_id" class="form-label">Nhân sự Phụ trách:</label>
            <select class="form-select" id="staff_id" name="staff_id" required>
                <option value="">-- Chọn Nhân sự --</option>
                <?php 
                // LƯU Ý: Biến $staff_list PHẢI được Controller cung cấp
                if (!empty($staff_list)) {
                    foreach ($staff_list as $staff) {
                        echo '<option value="' . htmlspecialchars($staff['id']) . '">' . htmlspecialchars($staff['name']) . '</option>';
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
                // LƯU Ý: Biến $supplier_list PHẢI được Controller cung cấp
                if (!empty($supplier_list)) {
                    foreach ($supplier_list as $supplier) {
                        echo '<option value="' . htmlspecialchars($supplier['id']) . '">' . htmlspecialchars($supplier['name']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="main_image" class="form-label">Ảnh Chính:</label>
            <input type="file" class="form-control" id="main_image" name="main_image">
            <small class="form-text text-muted">Chỉ chấp nhận file ảnh (jpg, png, gif).</small>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Ngày Bắt đầu:</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">Ngày Kết thúc:</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-success me-2">Thêm Tour</button>
        <a href="index.php?action=listTours" class="btn btn-secondary">Quay lại danh sách</a>
    </form>
</div>

<?php include_once __DIR__ . '/../../../public/html/footer.php'; ?>