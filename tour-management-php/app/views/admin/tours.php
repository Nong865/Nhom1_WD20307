<?php 
// Đảm bảo file header.php chỉ được nhúng một lần
include_once __DIR__ . '/../../../public/html/header.php'; 
// Giả định biến $tours đã được controller truyền vào
// Nếu không có dữ liệu thật, bạn có thể tạo mảng mẫu ở đây để test
?>

<div class="container">
    <h2 class="mb-3">Danh sách Tour</h2>
    <p><a href="index.php?action=addTourForm" class="btn btn-primary btn-sm mb-3">Thêm tour mới</a></p>
    
    <?php if (empty($tours)): ?>
        <p>Chưa có tour nào.</p>
    <?php else: ?>
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên tour</th>
                    <th>Ảnh Chính</th>
                    <th>Album Ảnh</th>
                    <th>Nhân sự</th>
                    <th>Nhà Cung cấp</th>
                    
                    <th>Giá</th>
                    <th>Thời gian</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($tours as $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($t['id']); ?></td>
                    <td><?php echo htmlspecialchars($t['name']); ?></td>
                   <td>
                         <?php if (!empty($t['main_image'])): 

                                $full_image_path = $t['main_image']; 
                        ?>
                                    <img src="<?php echo $base_path . htmlspecialchars($full_image_path); ?>" alt="Ảnh Tour" style="width: 80px; height: auto;">
                        <?php else: ?>
                                 N/A
                        <?php endif; ?>
                        </td>
                    
                    <td>
                        <a href="index.php?action=viewAlbum&tour_id=<?php echo $t['id']; ?>" class="btn btn-info btn-sm">
                            Xem Album
                        </a>
                    </td>
                    
                    <td><?php echo htmlspecialchars($t['staff_name'] ?? 'Chưa gán'); ?></td> 
                    
                    <td><?php echo htmlspecialchars($t['supplier_name'] ?? 'Chưa gán'); ?></td>
                    
                    <td><?php echo number_format($t['price'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo htmlspecialchars($t['start_date']) . ' → ' . htmlspecialchars($t['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($t['description']); ?></td>
                    
                    <td>
                        <a href="index.php?action=editTour&id=<?php echo $t['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="index.php?action=deleteTour&id=<?php echo $t['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa tour này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="mt-3">
            <small>Nhóm 1_WD20307</small>
        </div>
    <?php endif; ?>
</div>

<?php 
// Đảm bảo file footer.php chỉ được nhúng một lần
include_once __DIR__ . '/../../../public/html/footer.php'; 
?>