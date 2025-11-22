<h3 class="mb-3">Danh sách Tour</h3>

<a href="index.php?action=addTour" class="btn btn-primary mb-3">+ Thêm tour</a>

<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên tour</th>
            <th>Ảnh chính</th>
            <th>Album ảnh</th>
            <th>Nhân sự</th>
            <th>Nhà cung cấp</th>
            <th>Giá</th>
            <th>Thời gian</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tours as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= $t['name'] ?></td>
            <td>
                <?php if($t['main_image']): ?>
                    <img src="<?= $t['main_image'] ?>" width="70">
                <?php endif; ?>
            </td>
<td>
  <a class="btn btn-success btn-sm" href="index.php?action=viewAlbum&id=<?= $t['id'] ?>">Xem Album</a>
</td>
            <td><?= $t['hdv'] ?></td>
            <td><?= $t['ncc'] ?></td>
            <td><?= number_format($t['price']) ?> VNĐ</td>
            <td><?= $t['start_date'] ?> - <?= $t['end_date'] ?></td>
            <td><?= $t['description'] ?></td>
            <td>
                <a class="btn btn-warning btn-sm" href="index.php?action=editTour&id=<?= $t['id'] ?>">Sửa</a>
                <a class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')" href="index.php?action=deleteTour&id=<?= $t['id'] ?>">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
