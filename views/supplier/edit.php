<h3>Sửa Nhà Cung Cấp</h3>

<form method="POST" action="index.php?action=supplierUpdate">

    <input type="hidden" name="id" value="<?= $supplier['id'] ?>">

    <label>Tên đơn vị:</label>
    <input name="name" class="form-control mb-2" 
           value="<?= $supplier['name'] ?>" required>

    <label>Loại nhà cung cấp:</label>
    <select name="type_id" class="form-control mb-2">
        <?php foreach($types as $t): ?>
            <option value="<?= $t['id'] ?>"
                <?= ($supplier['type_id'] == $t['id']) ? 'selected' : '' ?>>
                <?= $t['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Địa chỉ:</label>
    <input name="address" class="form-control mb-2"
           value="<?= $supplier['address'] ?>">

    <label>Số điện thoại:</label>
    <input name="phone" class="form-control mb-2"
           value="<?= $supplier['phone'] ?>">

    <label>Email:</label>
    <input name="email" class="form-control mb-2"
           value="<?= $supplier['email'] ?>">

    <label>Mô tả dịch vụ:</label>
    <textarea name="description" class="form-control mb-2"><?= $supplier['description'] ?></textarea>

    <label>Năng lực cung cấp:</label>
    <textarea name="capacity" class="form-control mb-2"><?= $supplier['capacity'] ?></textarea>

    <label>Dịch vụ đã cung ứng cho tour:</label>
    <textarea name="service_history" class="form-control mb-3"><?= $supplier['service_history'] ?></textarea>

    <button class="btn btn-success">Cập nhật</button>
    <a href="index.php?action=supplierIndex" class="btn btn-secondary">Hủy</a>

</form>
