<h3>Tạo lịch khởi hành</h3>

<form method="POST" action="index.php?action=scheduleSave">
    <label>Chọn Tour</label>
    <select name="tour_id" class="form-control mb-2">
        <?php foreach($tours as $t): ?>
        <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Giờ khởi hành</label>
    <input type="datetime-local" name="start_datetime" class="form-control mb-2">

    <label>Giờ kết thúc</label>
    <input type="datetime-local" name="end_datetime" class="form-control mb-2">

    <label>Điểm tập trung</label>
    <input type="text" name="meeting_point" class="form-control mb-3">

    <button class="btn btn-success">Tiếp tục → Phân bổ nhân sự</button>
</form>
