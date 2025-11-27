<h3>Sửa tour</h3>

<form method="post" action="index.php?action=updateTour" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $tour['id'] ?>">
    <input type="hidden" name="old_image" value="<?= $tour['main_image'] ?>">

    <label>Tên tour:</label>
    <input name="name" class="form-control" value="<?= $tour['name'] ?>">

    <label>Giá:</label>
    <input name="price" type="number" class="form-control" value="<?= $tour['price'] ?>">

    <label>Mô tả:</label>
    <textarea name="description" class="form-control"><?= $tour['description'] ?></textarea>

    <label>Ngày bắt đầu:</label>
    <input name="start_date" type="date" class="form-control" value="<?= $tour['start_date'] ?>">

    <label>Ngày kết thúc:</label>
    <input name="end_date" type="date" class="form-control" value="<?= $tour['end_date'] ?>">

    <label>Ảnh hiện tại:</label><br>
    <?php if($tour['main_image']): ?>
        <img src="<?= $tour['main_image'] ?>" width="120">
    <?php endif; ?>

    <label>Upload ảnh mới:</label>
    <input type="file" name="main_image" class="form-control">

    <button class="btn btn-primary mt-3">Cập nhật</button>
</form>
