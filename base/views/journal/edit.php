<?php require_once "views/layout/header.php"; ?>

<div class="container mt-4">
    <h2>✏️ Sửa nhật ký</h2>

    <form method="POST" action="?action=journalUpdate">

        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="hidden" name="tour_id" value="<?= $row['tour_id'] ?>">

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="<?= $row['title'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="6" required><?= $row['content'] ?></textarea>
        </div>

        <button class="btn btn-success">Cập nhật</button>
        <a href="?action=journalIndex&tour_id=<?= $row['tour_id'] ?>" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php require_once "views/layout/footer.php"; ?>
