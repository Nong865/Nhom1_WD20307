<h3>Thêm Nhà Cung Cấp</h3>

<form method="POST" action="index.php?action=supplierStore">
    
    <label>Tên đơn vị:</label>
    <input name="name" class="form-control mb-2" required>

    <label>Loại nhà cung cấp:</label>
    <select name="type_id" class="form-control mb-2">
        <?php foreach($types as $t): ?>
            <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Địa chỉ:</label>
    <input name="address" class="form-control mb-2">

    <label>Số điện thoại:</label>
    <input name="phone" class="form-control mb-2">

    <label>Email:</label>
    <input name="email" class="form-control mb-2">

    <label>Mô tả dịch vụ:</label>
    <textarea name="description" class="form-control mb-2"></textarea>

    <label>Năng lực cung cấp:</label>
    <textarea name="capacity" class="form-control mb-2"></textarea>

    <label>Dịch vụ đã cung ứng cho tour:</label>
    <textarea name="service_history" class="form-control mb-2"></textarea>

    <button class="btn btn-primary mt-3">Lưu</button>

</form>
