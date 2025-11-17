<h2>Thêm Hướng Dẫn Viên</h2>

<form action="index.php?action=hdvStore" method="post" enctype="multipart/form-data">

    
    Họ tên: <input type="text" name="ho_ten"><br><br>
    Ngày sinh: <input type="date" name="ngay_sinh"><br><br>

    Ảnh: <input type="file" name="anh"><br><br>

    Số điện thoại: <input type="text" name="so_dien_thoai"><br><br>
    Email: <input type="email" name="email"><br><br>

    Chứng chỉ: <textarea name="chung_chi"></textarea><br><br>
    Ngôn ngữ: <input type="text" name="ngon_ngu"><br><br>

    Năm kinh nghiệm: <input type="number" name="nam_kinh_nghiem"><br><br>

    Lịch sử tour (JSON):  
    <textarea name="lich_su_tour">{}</textarea><br><br>

    Đánh giá: <input type="number" step="0.1" name="danh_gia"><br><br>
    Sức khỏe: <input type="text" name="suc_khoe"><br><br>

    Ghi chú: <textarea name="ghi_chu"></textarea><br><br>

    <button type="submit">Lưu</button>
</form>
