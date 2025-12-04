<?php require_once "views/layout/header.php"; ?>

<div class="container mt-4">
    <h2>📘 Nhật ký tour: <?= $tour['tour_name'] ?></h2>

    <a href="?action=journalCreate&tour_id=<?= $tour['id'] ?>" class="btn btn-primary mb-3">
        + Thêm nhật ký
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Nội dung</th>
                <th>Ngày tạo</th>
                <th width="160">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($journals as $j): ?>
                <tr>
                    <td><?= $j['title'] ?></td>
                    <td><?= nl2br($j['content']) ?></td>
                    <td><?= $j['created_at'] ?></td>
                    <td>
                        <a class="btn btn-warning btn-sm"
                           href="?action=journalEdit&id=<?= $j['id'] ?>">
                            Sửa
                        </a>
                        <a class="btn btn-danger btn-sm"
                           onclick="return confirm('Xóa nhật ký?')"
                           href="?action=journalDelete&id=<?= $j['id'] ?>&tour_id=<?= $tour['id'] ?>">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once "views/layout/footer.php"; ?>
