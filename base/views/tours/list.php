<h3 class="mb-3">Danh sách Tour</h3>

<?php if (!empty($message)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow mb-4 p-3">
    <form action="index.php" method="GET" class="row align-items-center g-3">
        <input type="hidden" name="action" value="filterTours"> 
        
        <div class="col-auto">
            <label for="category_id_filter" class="col-form-label">Lọc theo Danh mục:</label>
        </div>
        <div class="col-auto">
            <select name="category_id" id="category_id_filter" class="form-select">
                <option value="">-- Tất cả Tour --</option>
                <?php 
                // Biến $categories và $category_id_filter được truyền từ Controller
                foreach ($categories as $cat): 
                ?>
                    <option value="<?= $cat['id'] ?>"
                        <?php 
                        // Dùng biến $category_id_filter để đánh dấu mục đang được chọn
                        if (($category_id_filter ?? '') == $cat['id']) echo 'selected'; 
                        ?>
                    >
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Lọc Tour</button>
        </div>
        <div class="col-auto">
            <a href="index.php?action=listTours" class="btn btn-secondary">Đặt lại</a>
        </div>
    </form>
</div>
<a href="index.php?action=addTour" class="btn btn-primary mb-3">+ Thêm tour</a>

<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên tour</th>
            <th>Danh mục</th> <th>Ảnh chính</th>
            <th>Album ảnh</th>
            <th>Nhân sự</th>
            <th>Nhà cung cấp</th>
            <th>Giá</th>
            <th>Lịch trình</th> 
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tours as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= $t['name'] ?></td>
            
            <td><?= $t['category_name'] ?? 'Chưa gán' ?></td>
            
            <td>
                <?php if($t['main_image']): ?>
                    <img src="<?= $t['main_image'] ?>" width="70px">
                <?php endif; ?>
            </td>
            <td>
                <a class="btn btn-success btn-sm" href="index.php?action=viewAlbum&id=<?= $t['id'] ?>">Xem Album</a>
            </td>
            <td><?= $t['hdv'] ?? 'Chưa gán' ?></td>
            <td><?= $t['ncc'] ?? 'Chưa gán' ?></td>
            <td><?= number_format($t['price']) ?> VNĐ</td>
            
            <td>
                <a href="index.php?action=viewItinerary&id=<?= $t['id'] ?>" class="btn btn-info btn-sm">
                    <?= $t['lich_trinh'] ?> (Xem)
                </a>
            </td>
            
            <td><?= $t['description'] ?></td>
            <td>
                <a class="btn btn-warning btn-sm" href="index.php?action=editTour&id=<?= $t['id'] ?>">Sửa</a>
                <a class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')" href="index.php?action=deleteTour&id=<?= $t['id'] ?>">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>