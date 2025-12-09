<h3>Thêm nhật ký tour</h3>

<form method="POST" action="?action=journalStore" enctype="multipart/form-data">
    <input type="hidden" name="tour_id" value="<?= $_GET['tour_id'] ?>">

    <label>Ngày:</label>
    <input type="date" name="journal_date" required>

    <label>Tiêu đề:</label>
    <input type="text" name="title" class="form-control">

    <label>Hoạt động nổi bật:</label>
    <textarea name="activities" rows="3" class="form-control"></textarea>

    <label>Sự cố & cách xử lý:</label>
    <textarea name="issues" rows="3" class="form-control"></textarea>

    <label>Phản hồi khách hàng:</label>
    <textarea name="feedback" rows="3" class="form-control"></textarea>

    <label>Ảnh minh chứng:</label>
    <input type="file" name="image" class="form-control">

    <button class="btn btn-primary mt-3">Lưu</button>
</form>
