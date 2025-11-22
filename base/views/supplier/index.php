<h3 class="mb-3">Danh sách Nhà Cung Cấp</h3>

<a href="index.php?action=supplierAdd" class="btn btn-primary mb-3">+ Thêm nhà cung cấp</a>

<table class="table table-bordered bg-white table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên đơn vị</th>
            <th>Loại</th>
            <th>Địa chỉ</th>
            <th>Liên hệ</th>
            <th>Mô tả</th>
            <th>lịch sử cung ứng</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($suppliers as $s): ?>
        <tr>
            <td><?= $s['id'] ?></td>
            <td><?= $s['name'] ?></td>
            <td><?= $s['type_name'] ?></td>
            <td><?= $s['address'] ?></td>
            <td>
                📞 <?= $s['phone'] ?><br>
                ✉️ <?= $s['email'] ?>
            </td>
            <td><?= $s['description'] ?></td>
            <td><?= $s['service_history'] ?></td>

            <td>
                <a href="index.php?action=supplierEdit&id=<?= $s['id'] ?>" class="btn btn-warning btn-sm">
                    Sửa
                </a>
                <a onclick="return confirm('Xóa nhà cung cấp này?')"
                   href="index.php?action=supplierDelete&id=<?= $s['id'] ?>"
                   class="btn btn-danger btn-sm">
                   Xóa
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
