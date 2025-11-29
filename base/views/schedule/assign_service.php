<h3>Phân bổ dịch vụ cho lịch khởi hành</h3>

<p><b>Tour:</b> <?= $schedule['tour_name'] ?></p>
<p><b>Ngày khởi hành:</b> <?= $schedule['start_datetime'] ?></p>

<form action="index.php?action=saveService" method="POST">
    <input type="hidden" name="schedule_id" value="<?= $schedule['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Chọn nhà cung cấp:</label>
        <select name="partner_id" class="form-select" required>
            <?php foreach($partners as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['name'] ?> 
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Số lượng dịch vụ:</label>
        <input type="number" name="qty" min="1" class="form-control" required>

    </div>

    <button type="submit" class="btn btn-primary">Lưu phân bổ</button>
</form>
