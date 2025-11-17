<h2>Sửa Hướng Dẫn Viên</h2>

<form action="index.php?action=hdvUpdate" method="post" enctype="multipart/form-data">


    <input type="hidden" name="id" value="<?= $hdv['id'] ?>">

    Họ tên: <input type="text" name="ho_ten" value="<?= $hdv['ho_ten'] ?>"><br><br>

    Ngày sinh: <input type="date" name="ngay_sinh" value="<?= $hdv['ngay_sinh'] ?>"><br><br>

    Ảnh hiện tại: <img src="uploads/<?= $hdv['anh'] ?>" width="80"><br>
    Ảnh mới: <input type="file" name="anh"><br><br>

    Số điện thoại: <input type="text" name="so_dien_thoai" value="<?= $hdv['so_dien_thoai'] ?>"><br><br>
    Email: <input type="text" name="email" value="<?= $hdv['email'] ?>"><br><br>

    Chứng chỉ:
    <textarea name="chung_chi"><?= $hdv['chung_chi'] ?></textarea><br><br>

    Ngôn ngữ: <input type="text" name="ngon_ngu" value="<?= $hdv['ngon_ngu'] ?>"><br><br>

    Năm kinh nghiệm: <input type="number" name="nam_kinh_nghiem" value="<?= $hdv['nam_kinh_nghiem'] ?>"><br><br>

    Lịch sử tour:
    <textarea name="lich_su_tour"><?= $hdv['lich_su_tour'] ?></textarea><br><br>

    Đánh giá: <input type="number" step="0.1" name="danh_gia" value="<?= $hdv['danh_gia'] ?>"><br><br>

    Sức khỏe: <input type="text" name="suc_khoe" value="<?= $hdv['suc_khoe'] ?>"><br><br>

    Ghi chú:
    <textarea name="ghi_chu"><?= $hdv['ghi_chu'] ?></textarea><br><br>

    <button type="submit">Cập nhật</button>
</form>
