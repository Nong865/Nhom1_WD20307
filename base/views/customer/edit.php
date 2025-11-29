<h3>Sửa thông tin khách</h3>

<form method="POST" action="index.php?action=customerEdit">
    <input type="hidden" name="id" value="<?= $customer['id'] ?>">
    <input type="hidden" name="tour_id" value="<?= $customer['tour_id'] ?>">

    <label>Họ tên:</label>
    <input type="text" name="name" class="form-control" value="<?= $customer['name'] ?>" required>

    <label>Giới tính:</label>
    <select name="gender" class="form-select">
        <option value="Nam" <?= $customer['gender']=='Nam'?'selected':'' ?>>Nam</option>
        <option value="Nữ" <?= $customer['gender']=='Nữ'?'selected':'' ?>>Nữ</option>
    </select>

    <label>Năm sinh:</label>
    <input type="number" name="birth_year" class="form-control" value="<?= $customer['birth_year'] ?>">

    <label>Điện thoại:</label>
    <input type="text" name="phone" class="form-control" value="<?= $customer['phone'] ?>">

    <label>Passport/CCCD:</label>
    <input type="text" name="passport" class="form-control" value="<?= $customer['passport'] ?>">

    <label>Ghi chú đặc biệt:</label>
    <textarea name="special_note" class="form-control"><?= $customer['special_note'] ?></textarea>

    <label>Thanh toán:</label>
    <select name="payment_status" class="form-select">
        <option value="paid" <?= $customer['payment_status']=='paid'?'selected':'' ?>>Đã thanh toán</option>
        <option value="not_paid" <?= $customer['payment_status']=='not_paid'?'selected':'' ?>>Chưa</option>
    </select>

    <button class="btn btn-primary mt-3">Cập nhật</button>
</form>
