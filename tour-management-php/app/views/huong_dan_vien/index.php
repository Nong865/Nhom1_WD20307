<h2>Danh Sách Hướng Dẫn Viên</h2>
<a href="index.php?action=hdvCreate">+ Thêm HDV</a>

<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="hdv">
    <input type="hidden" name="action" value="hdvIndex">

<select name="nhom" onchange="this.form.submit()">
    <option value="">-- Tất cả nhóm --</option>
    <option value="1" <?= isset($_GET['nhom']) && $_GET['nhom']==1 ? 'selected' : '' ?>>Nội địa</option>
    <option value="2" <?= isset($_GET['nhom']) && $_GET['nhom']==2 ? 'selected' : '' ?>>Quốc tế</option>
    <option value="3" <?= isset($_GET['nhom']) && $_GET['nhom']==3 ? 'selected' : '' ?>>Chuyên tuyến Bắc</option>
    <option value="4" <?= isset($_GET['nhom']) && $_GET['nhom']==4 ? 'selected' : '' ?>>Chuyên tuyến Nam</option>
    <option value="5" <?= isset($_GET['nhom']) && $_GET['nhom']==5 ? 'selected' : '' ?>>Khách đoàn</option>
</select>


    </select>
</form>




<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Họ tên</th>
        <th>SĐT</th>
        <th>Email</th>
        <th>Kinh nghiệm</th>
        <th>Đánh giá</th>
        <th>Chứng Chỉ</th>
        <th>Ngôn Ngữ</th>
        <th>Sức Khỏe</th>
        <th>Hành động</th>
    </tr>

    <?php foreach($hdvs as $hdv): ?>
    <tr>
        <td><?= $hdv['id'] ?></td>
        <td><img src="uploads/<?= $hdv['anh'] ?>" width="60"></td>
        <td><?= $hdv['ho_ten'] ?></td>
        <td><?= $hdv['so_dien_thoai'] ?></td>
        <td><?= $hdv['email'] ?></td>
        <td><?= $hdv['nam_kinh_nghiem'] ?> năm</td>
        <td><?= $hdv['danh_gia'] ?></td>
        <td><?= $hdv['chung_chi'] ?></td>
        <td><?= $hdv['ngon_ngu'] ?></td>
        <td><?= $hdv['suc_khoe'] ?></td>
        
        <td>
<a href="index.php?action=hdvEdit&id=<?= $hdv['id'] ?>">Sửa</a> | 
<a href="index.php?action=hdvDelete&id=<?= $hdv['id'] ?>" onclick="return confirm('Xóa?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
