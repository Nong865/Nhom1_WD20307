<h3>Thêm tour</h3>

<form method="post" action="index.php?action=saveTour" enctype="multipart/form-data">

    <label>Tên tour:</label>
    <input name="name" class="form-control" required>

    <label>Giá:</label>
    <input name="price" type="number" class="form-control" required>

    <label>Mô tả:</label>
    <textarea name="description" class="form-control"></textarea>

    <label>Ngày bắt đầu:</label>
    <input name="start_date" type="date" class="form-control">

    <label>Ngày kết thúc:</label>
    <input name="end_date" type="date" class="form-control">

    <label>Ảnh chính:</label>
    <input type="file" name="main_image" class="form-control">

    <button class="btn btn-success mt-3">Lưu tour</button>
</form>
