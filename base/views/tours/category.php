<?php 


// Kiểm tra xem dữ liệu đã được truyền vào chưa
if (!isset($tours) || !isset($category_name)) {
    // Nếu chưa có dữ liệu, hiển thị thông báo lỗi hoặc chuyển hướng
    echo '<div class="alert alert-danger" role="alert">Lỗi: Không tìm thấy dữ liệu tours hoặc tên danh mục.</div>';
    return; 
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh mục Tour: <?php echo htmlspecialchars($category_name); ?></title>
    
    <link rel="stylesheet" href="<?php echo (defined('BASE_URL') ? BASE_URL : '/DA_Nhom1/base'); ?>/assets/css/style.css">
</head>
<body>

    <div class="container">

        <h1 style="color: red;" class="my-4">Danh Mục Tour: <?php echo htmlspecialchars($category_name); ?></h1>
        <hr>

        <?php if (count($tours) > 0): ?>
            <div class="row">
                <?php 
                // Lặp qua mảng $tours để hiển thị từng tour
                foreach ($tours as $tour): 
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card tour-card">
                            
                            <img 
                                src="/DA_Nhom1/base/<?php echo htmlspecialchars($tour['main_image'] ?? ''); ?>" 
                                class="card-img-top" 
                                alt="<?php echo htmlspecialchars($tour['name'] ?? 'Tour không tên'); ?>"
                                
                                style="height: 200px; object-fit: cover;" 
                            >
                            
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($tour['name'] ?? 'Tour không tên'); ?></h5>
                                
                                <?php $price = $tour['price'] ?? 0; ?>
                                <p class="card-text">Giá: <?php echo number_format($price, 0, ',', '.'); ?> VNĐ</p>
                                
                               <a 
    href="index.php?action=detailTour&id=<?php echo htmlspecialchars($tour['id'] ?? ''); ?>" 
    class="btn btn-primary"
>
    Xem chi tiết
</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Hiện tại, không có tour nào trong danh mục <?php echo htmlspecialchars($category_name); ?>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>