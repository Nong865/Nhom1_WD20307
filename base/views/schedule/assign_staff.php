<div class="container mt-4">
    <h3>Phân bổ nhân sự cho lịch khởi động</h3>

    <p><b>Tour:</b> <?= $schedule['tour_name'] ?></p>
    <p><b>Ngày khởi hành:</b> <?= $schedule['start_datetime'] ?></p>

    <form action="index.php?action=saveStaff" method="POST">

        <input type="hidden" name="schedule_id" value="<?= $schedule['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Chọn nhân sự:</label>
            <select name="staff_id" class="form-select" required>
                <?php foreach ($staff as $s): ?>
                    <option value="<?= $s['id'] ?>">
                        <?= $s['name'] ?> 
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Vai trò:</label>
            <select name="role" class="form-select" required>
                <option value="HDV">Hướng dẫn viên</option>
                <option value="Lái xe">Lái xe</option>
                <option value="Hậu cần">Nhân viên hậu cần</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lưu phân bổ</button>
    </form>
</div>
