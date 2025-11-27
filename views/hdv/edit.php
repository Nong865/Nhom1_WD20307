<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .card { background: #fff; border-radius: 10px; padding: 20px; max-width: 900px; margin: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    h1 { text-align: center; margin-bottom: 20px; }
    form { display: flex; flex-wrap: wrap; gap: 20px; }
    .left, .right { flex: 1; min-width: 280px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { font-weight: bold; display: block; margin-bottom: 5px; }
    .form-group input, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
    textarea { min-height: 80px; }
    .checkbox-group { display: flex; flex-wrap: wrap; gap: 10px; max-height: 150px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; border-radius: 5px; }
    .checkbox-group label { font-weight: normal; }
    .avatar { width: 180px; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 10px; border: 1px solid #ccc; }
    button { background: #4CAF50; color: #fff; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; font-size: 16px; }
    button:hover { background: #45a049; }
    a { display: inline-block; margin-top: 15px; color: #555; text-decoration: none; }
</style>

<div class="card">
    <h1>Sửa Hướng dẫn viên</h1>
    <form method="POST" action="index.php?action=hdvUpdate" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <div class="left">
            <!-- Ảnh và Upload -->
            <?php if(!empty($row['anh'])): ?>
                <img src="assets/uploads/<?= $row['anh'] ?>" alt="" class="avatar">
            <?php else: ?>
                <img src="assets/uploads/default.png" alt="" class="avatar">
            <?php endif; ?>
            <div class="form-group">
                <label>Thay ảnh:</label>
                <input type="file" name="anh" accept="image/*">
            </div>

            <!-- Nhóm HDV -->
            <div class="form-group">
                <label>Nhóm HDV:</label>
                <div class="checkbox-group">
                    <?php foreach($groups as $group): ?>
                        <label>
                            <input type="checkbox" name="groups[]" value="<?= $group['id'] ?>" 
                            <?= in_array($group['id'], $myGroups) ? 'checked' : '' ?>>
                            <?= htmlspecialchars($group['ten_nhom']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="right">
            <!-- Thông tin cơ bản -->
            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="ho_ten" value="<?= htmlspecialchars($row['ho_ten']) ?>" required>
            </div>
            <div class="form-group">
                <label>Ngày sinh:</label>
                <input type="date" name="ngay_sinh" value="<?= $row['ngay_sinh'] ?>" required>
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" name="so_dien_thoai" value="<?= htmlspecialchars($row['so_dien_thoai']) ?>">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>">
            </div>
            <div class="form-group">
                <label>Chứng chỉ:</label>
                <input type="text" name="chung_chi" value="<?= htmlspecialchars($row['chung_chi']) ?>">
            </div>
            <div class="form-group">
                <label>Ngôn ngữ:</label>
                <input type="text" name="ngon_ngu" value="<?= htmlspecialchars($row['ngon_ngu']) ?>">
            </div>
            <div class="form-group">
                <label>Năm kinh nghiệm:</label>
                <input type="number" name="nam_kinh_nghiem" value="<?= $row['nam_kinh_nghiem'] ?>" min="0">
            </div>
            <div class="form-group">
                <label>Đánh giá:</label>
                <textarea name="danh_gia"><?= htmlspecialchars($row['danh_gia']) ?></textarea>
            </div>
            <div class="form-group">
                <label>Sức khỏe:</label>
                <input type="text" name="suc_khoe" value="<?= htmlspecialchars($row['suc_khoe']) ?>">
            </div>
            <div class="form-group">
                <label>Ghi chú:</label>
                <textarea name="ghi_chu"><?= htmlspecialchars($row['ghi_chu']) ?></textarea>
            </div>
            <button type="submit">Cập nhật HDV</button>
            <br>
            <a href="index.php?action=hdvIndex">Quay lại danh sách</a>
        </div>
    </form>
</div>
