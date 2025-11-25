<h3>Sửa tour</h3>

<form method="post" action="index.php?action=updateTour" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $tour['id'] ?? '' ?>">
    <input type="hidden" name="old_image" value="<?= $tour['main_image'] ?? '' ?>">

    <label>Tên tour:</label>
    <input name="name" class="form-control" value="<?= $tour['name'] ?? '' ?>" required>

    <label>Giá:</label>
    <input name="price" type="number" class="form-control" value="<?= $tour['price'] ?? '' ?>" required>

    <label>Mô tả:</label>
    <textarea name="description" class="form-control"><?= $tour['description'] ?? '' ?></textarea>

    <label>Nhân sự (Hướng dẫn viên):</label>
    <select name="staff_id" class="form-control">
        <option value="">-- Chọn Hướng dẫn viên --</option>
        <?php foreach($staffs as $staff): ?>
            <option 
                value="<?= $staff['id'] ?>" 
                <?= (isset($tour['staff_id']) && $tour['staff_id'] == $staff['id']) ? 'selected' : '' ?>>
                <?= $staff['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Nhà cung cấp:</label>
    <select name="supplier_id" class="form-control">
        <option value="">-- Chọn Nhà cung cấp --</option>
        <?php foreach($suppliers as $supplier): ?>
            <option 
                value="<?= $supplier['id'] ?>" 
                <?= (isset($tour['supplier_id']) && $tour['supplier_id'] == $supplier['id']) ? 'selected' : '' ?>>
                <?= $supplier['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Ngày bắt đầu:</label>
    <input name="start_date" type="date" class="form-control" value="<?= $tour['start_date'] ?? '' ?>">

    <label>Lịch trình (Số ngày):</label>
    <input name="total_days" type="number" class="form-control" value="<?= $total_days ?? 0 ?>" required min="1">
    
    <label>Ảnh hiện tại:</label><br>
    <?php if(!empty($tour['main_image'])): ?>
        <img src="<?= $tour['main_image'] ?>" width="120">
    <?php endif; ?>

    <label>Upload ảnh mới:</label>
    <input type="file" name="main_image" class="form-control">

    <button class="btn btn-primary mt-3">Cập nhật</button>
</form>