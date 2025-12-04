<h3 class="mb-3">Thêm tour</h3>

<form method="post" action="index.php?action=saveTour" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Tên tour:</label>
        <input name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Giá (VNĐ):</label>
        <input name="price" type="number" class="form-control" required min="1000">
    </div>

    <div class="mb-3">
        <label class="form-label">Mô tả:</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Danh mục Tour:</label>
        <select name="category_id" class="form-control" required>
            <option value="">-- Chọn Danh mục Tour --</option>
            <?php 
            // Biến $categories được truyền từ TourController
            if (!empty($categories)): 
                foreach($categories as $category): 
            ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php 
                endforeach; 
            endif; 
            ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nhân sự (Hướng dẫn viên):</label>
            <select name="staff_id" class="form-control">
                <option value="">-- Chọn Hướng dẫn viên --</option>
                <?php if (!empty($staffs)): ?>
                    <?php foreach($staffs as $staff): ?>
                        <option value="<?= $staff['id'] ?>"><?= $staff['name'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Nhà cung cấp:</label>
            <select name="supplier_id" class="form-control">
                <option value="">-- Chọn Nhà cung cấp --</option>
                <?php if (!empty($suppliers)): ?>
                    <?php foreach($suppliers as $supplier): ?>
                        <option value="<?= $supplier['id'] ?>"><?= $supplier['name'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Ngày bắt đầu:</label>
            <input name="start_date" type="date" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Lịch trình (Số ngày):</label>
            <input name="total_days" type="number" class="form-control" required min="1" placeholder="Nhập số ngày của tour (Ví dụ: 3)">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Ảnh chính:</label>
        <input type="file" name="main_image" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success mt-3">
        <i class="fas fa-save"></i> Lưu tour
    </button>
    <a href="index.php?action=listTours" class="btn btn-secondary mt-3">Hủy</a>
</form>