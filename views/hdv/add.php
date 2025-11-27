<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    h1 { color: #333; }
    .card { background: white; padding: 20px; border-radius: 8px; max-width: 700px; margin: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
    .form-group input[type="file"] { padding: 3px; }
    .checkbox-group { display: flex; flex-wrap: wrap; gap: 10px; }
    .checkbox-group label { font-weight: normal; }
    button { background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background: #45a049; }
    a { text-decoration: none; color: #555; margin-top: 10px; display: inline-block; }
</style>

<div class="card">
    <h1>Thêm Hướng dẫn viên</h1>
    <form method="POST" action="index.php?action=hdvStore" enctype="multipart/form-data">

        <div class="form-group">
            <label>Họ tên:</label>
            <input type="text" name="ho_ten" required>
        </div>

        <div class="form-group">
            <label>Ngày sinh:</label>
            <input type="date" name="ngay_sinh" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại:</label>
            <input type="text" name="so_dien_thoai">
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email">
        </div>

        <div class="form-group">
            <label>Chứng chỉ:</label>
            <input type="text" name="chung_chi">
        </div>

        <div class="form-group">
            <label>Ngôn ngữ:</label>
            <input type="text" name="ngon_ngu">
        </div>

        <div class="form-group">
            <label>Năm kinh nghiệm:</label>
            <input type="number" name="nam_kinh_nghiem" min="0">
        </div>

        <div class="form-group">
            <label>Đánh giá:</label>
            <input type="number" name="danh_gia" step="0.1" min="0" max="10">
        </div>

        <div class="form-group">
            <label>Sức khỏe:</label>
            <input type="text" name="suc_khoe">
        </div>

        <div class="form-group">
            <label>Ghi chú:</label>
            <textarea name="ghi_chu"></textarea>
        </div>

        <div class="form-group">
            <label>Ảnh:</label>
            <input type="file" name="anh" accept="image/*">
        </div>

        <div class="form-group">
            <label>Nhóm HDV:</label>
            <div class="checkbox-group">
                <?php foreach($groups as $group): ?>
                    <label><input type="checkbox" name="groups[]" value="<?= $group['id'] ?>"> <?= htmlspecialchars($group['ten_nhom']) ?></label>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit">Thêm HDV</button>
    </form>
    <a href="index.php?action=hdvIndex">Quay lại danh sách</a>
</div>
