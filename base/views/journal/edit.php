<h3>Cập nhật nhật ký</h3>

<form method="POST" action="?action=journalUpdate" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="hidden" name="tour_id" value="<?= $row['tour_id'] ?>">
    <input type="hidden" name="old_image" value="<?= $row['image'] ?>">

    <label>Ngày:</label>
    <input type="date" name="journal_date" class="form-control" value="<?= $row['journal_date'] ?>">

    <label>Tiêu đề:</label>
    <input type="text" name="title" class="form-control" value="<?= $row['title'] ?>">

    <label>Hoạt động:</label>
    <textarea name="activities" rows="3" class="form-control"><?= $row['activities'] ?></textarea>

    <label>Sự cố:</label>
    <textarea name="issues" rows="3" class="form-control"><?= $row['issues'] ?></textarea>

    <label>Phản hồi khách:</label>
    <textarea name="feedback" rows="3" class="form-control"><?= $row['feedback'] ?></textarea>

    <label>Ảnh hiện tại:</label><br>
    <?php if ($row['image']): ?>
        <img src="<?= $row['image'] ?>" width="120"><br>
    <?php endif; ?>

    <label>Đổi ảnh:</label>
    <input type="file" name="image" class="form-control">

    <button class="btn btn-primary mt-3">Cập nhật</button>
</form>
