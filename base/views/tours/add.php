<h3>Thêm tour</h3>

<form method="post" action="index.php?action=saveTour" enctype="multipart/form-data">

    <label>Tên tour:</label>
    <input name="name" class="form-control" required>

    <label>Giá:</label>
    <input name="price" type="number" class="form-control" required>

    <label>Mô tả:</label>
    <textarea name="description" class="form-control"></textarea>

    <label>Nhân sự (Hướng dẫn viên):</label>
    <select name="staff_id" class="form-control">
        <option value="">-- Chọn Hướng dẫn viên --</option>
        <?php if (!empty($staffs)): ?>
            <?php foreach($staffs as $staff): ?>
                <option value="<?= $staff['id'] ?>"><?= $staff['name'] ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>


    <label>Nhà cung cấp:</label>
    <select name="supplier_id" class="form-control">
        <option value="">-- Chọn Nhà cung cấp --</option>
        <?php if (!empty($suppliers)): ?>
            <?php foreach($suppliers as $supplier): ?>
                <option value="<?= $supplier['id'] ?>"><?= $supplier['name'] ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>

    <label>Ngày bắt đầu:</label>
    <input name="start_date" type="date" class="form-control" required>

    <label>Lịch trình (Số ngày):</label>
    <input name="total_days" type="number" class="form-control" required min="1" placeholder="Nhập số ngày của tour (Ví dụ: 3)">

    <label>Ảnh chính:</label>
    <input type="file" name="main_image" class="form-control">

    <button class="btn btn-success mt-3">Lưu tour</button>
</form>