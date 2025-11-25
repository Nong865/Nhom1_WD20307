<h3 class="mb-3">Danh sách hướng dẫn viên</h3>

<a href="index.php?action=hdvAdd" class="btn btn-primary mb-3">+ Thêm nhân viên</a>
<form method="GET" action="index.php" style="margin-bottom:20px;">
    <input type="hidden" name="action" value="hdvIndex">
    <label>Lọc theo nhóm:</label>
    <select name="group" onchange="this.form.submit()">
        <option value="">-- Tất cả nhóm --</option>
        <?php foreach($groups as $group): ?>
            <option value="<?= $group['id'] ?>" <?= (isset($_GET['group']) && $_GET['group'] == $group['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($group['ten_nhom']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ảnh</th>
            <th>Họ tên</th>
            <th>Nhóm</th>
            <th>Ngôn ngữ</th>
            <th>Kinh nghiệm</th>
            <th>Đánh giá</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><img src="assets/uploads/<?= $row['anh'] ?>" width="60"></td>
            <td><?= $row['ho_ten'] ?></td>
            <td><?= $row['nhom'] ?></td>
            <td><?= $row['ngon_ngu'] ?></td>
            <td><?= $row['nam_kinh_nghiem'] ?> năm</td>
            <td><?= $row['danh_gia'] ?>/5</td>
            <td>
                <a href="index.php?action=hdvEdit&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                <a onclick="return confirm('Xóa nhân viên này?')" 
                   href="index.php?action=hdvDelete&id=<?= $row['id'] ?>" 
                   class="btn btn-sm btn-danger">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
