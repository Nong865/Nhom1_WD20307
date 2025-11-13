<?php include __DIR__ . '/../../../../public/html/header.php'; ?>
<div class="container">
    <h2>Thêm Tour Mới</h2>
    <form method="post" action="index.php?action=addTour">
        <div><label>Tên tour: <input type="text" name="name" required></label></div>
        <div><label>Giá (VND): <input type="number" name="price" required></label></div>
        <div><label>Start date: <input type="date" name="start_date"></label></div>
        <div><label>End date: <input type="date" name="end_date"></label></div>
        <div><label>Mô tả:<br><textarea name="description" rows="4" cols="50"></textarea></label></div>
        <div><button type="submit">Thêm</button></div>
    </form>
    <p><a href="index.php?action=listTours">Quay lại danh sách</a></p>
</div>
<?php include __DIR__ . '/../../../../public/html/footer.php'; ?>