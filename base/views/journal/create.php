<?php require_once "views/layout/header.php"; ?>

<div class="container mt-4">
    <h2>✏️ Thêm nhật ký tour</h2>

    <form method="POST" action="?action=journalStore">
        <input type="hidden" name="tour_id" value="<?= $tour_id ?>">

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="6" required></textarea>
        </div>

        <button class="btn btn-success">Lưu</button>
        <a href="?action=journalIndex&tour_id=<?= $tour_id ?>" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php require_once "views/layout/footer.php"; ?>
