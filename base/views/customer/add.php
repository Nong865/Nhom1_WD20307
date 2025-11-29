<h3>Thêm khách vào đoàn</h3>

<form method="POST" action="index.php?action=customerAdd">
    <input type="hidden" name="tour_id" value="<?= $_GET['tour_id'] ?>">

    <label>Họ tên:</label>
    <input type="text" name="name" class="form-control" required>

    <label>Giới tính:</label>
    <select name="gender" class="form-select">
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
    </select>

    <label>Năm sinh:</label>
    <input type="number" name="birth_year" class="form-control">

    <label>Điện thoại:</label>
    <input type="text" name="phone" class="form-control">

    <label>Passport/CCCD:</label>
    <input type="text" name="passport" class="form-control">

    <label>Ghi chú đặc biệt:</label>
    <textarea name="special_note" class="form-control"></textarea>

    <label>Thanh toán:</label>
    <select name="payment_status" class="form-select">
        <option value="paid">Đã thanh toán</option>
        <option value="pending">Chưa thanh toán</option>

    </select>

    <button class="btn btn-primary mt-3">Lưu</button>
</form>
