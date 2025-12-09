<h3>Nhật ký tour: <?= $tour['name'] ?></h3>

<a href="?action=journalCreate&tour_id=<?= $tour['id'] ?>" class="btn btn-success mb-3">
    + Thêm nhật ký
</a>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Ngày</th>
            <th>Tiêu đề</th>
            <th>Hoạt động</th>
            <th>Phản hồi</th>
            <th>Ảnh</th>
            <th width="150">Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($journals as $j): ?>
        <tr>
            <td><?= $j['journal_date'] ?></td>
            <td><?= $j['title'] ?></td>
            <td><?= nl2br($j['activities']) ?></td>
            <td><?= nl2br($j['feedback']) ?></td>
            <td>
                <?php if ($j['image']): ?>
                    <img src="<?= $j['image'] ?>" width="80">
                <?php endif; ?>
            </td>
            <td>
                <a href="?action=journalEdit&id=<?= $j['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a onclick="return confirm('Xóa nhật ký này?')"
                   href="?action=journalDelete&id=<?= $j['id'] ?>&tour_id=<?= $tour['id'] ?>"
                   class="btn btn-danger btn-sm">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
