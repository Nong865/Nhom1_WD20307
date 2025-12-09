<?php 
// File này nhận biến $tour từ TourController->detail()

// Kiểm tra xem dữ liệu tour có tồn tại không
if (!isset($tour) || empty($tour)) {
    echo '<div class="container my-5"><div class="alert alert-warning" role="alert">Không tìm thấy thông tin tour này.</div></div>';
    return;
}

// Định nghĩa BASE_URL nếu chưa được định nghĩa (chỉ dành cho môi trường dev, nên tránh dùng trong production)
if (!defined('BASE_URL')) {
    // RẤT QUAN TRỌNG: Đảm bảo BASE_URL có giá trị đúng, ví dụ: /DA_Nhom1/base
    // Tùy theo cấu hình dự án của bạn, nếu BASE_URL chưa được định nghĩa từ ngoài, bạn có thể định nghĩa tạm ở đây:
    // define('BASE_URL', '/DA_Nhom1/base'); 
}

// Định dạng giá trị trước khi sử dụng
$tour_name = htmlspecialchars($tour['name'] ?? 'Tour không tên');
$tour_price = number_format($tour['price'] ?? 0, 0, ',', '.');
$tour_description = htmlspecialchars($tour['description'] ?? 'Không có mô tả chi tiết.');
$tour_image = htmlspecialchars($tour['main_image'] ?? '');
$tour_lich_trinh = htmlspecialchars($tour['lich_trinh'] ?? 'Chưa xác định'); 

// 💡 CẬP NHẬT CHÍNH: Chuẩn hóa đường dẫn ảnh
// Loại bỏ dấu '/' ở đầu $tour_image (ví dụ: biến 'assets/uploads/...')
$clean_image_path = ltrim($tour_image, '/'); 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Tour: <?php echo $tour_name; ?></title>
    </head>
<body>

    <div class="container my-5">
        
        <a href="index.php?action=listTours" class="btn btn-secondary mb-4">← Quay lại danh sách Tour</a>
        
        <h1 class="mb-4 text-primary">Chi Tiết Tour: <?php echo $tour_name; ?></h1>
        
        <div class="row">
            
           <div class="col-md-6">
                <?php if ($tour_image): ?>
                    <img 
                        src="/DA_Nhom1/base/<?php echo $clean_image_path; ?>" 
                        class="img-fluid rounded shadow-sm" 
                        alt="<?php echo $tour_name; ?>"
                        style="max-height: 450px; width: 100%; object-fit: cover;"
                    >
                <?php else: ?>
                    <div class="alert alert-light text-center border">Không có hình ảnh hiển thị.</div>
                <?php endif; ?>
            </div>
            
            <div class="col-md-6">
                <div class="card p-4 border-0 shadow-sm">
                    <h3 class="card-title text-danger mb-3">Giá: <?php echo $tour_price; ?> VNĐ</h3>
                    
                    <ul class="list-unstyled detail-list">
                        <li><strong>Mã Tour:</strong> <?php echo htmlspecialchars($tour['id'] ?? 'N/A'); ?></li>
                        <li><strong>Lịch trình:</strong> <?php echo $tour_lich_trinh; ?></li>
                        <li><strong>Ngày khởi hành:</strong> <?php echo htmlspecialchars($tour['start_date'] ?? 'Liên hệ'); ?></li>
                                                
                        <li><strong>Loại hình:</strong> <?php echo htmlspecialchars($tour['category_name'] ?? 'N/A'); ?></li>
                        
                        <li><strong>Nhà cung cấp:</strong> <?php echo htmlspecialchars($tour['ncc'] ?? 'N/A'); ?></li>
                        
                        <li><strong>Hướng dẫn viên:</strong> <?php echo htmlspecialchars($tour['hdv'] ?? 'Chưa phân công'); ?></li>
                    </ul>

                    <a 
                            href="index.php?action=bookingCreate&tour_id=<?php echo htmlspecialchars($tour['id'] ?? ''); ?>" 
                            class="btn btn-success btn-lg mt-3 w-100" 
                            style="text-decoration: none;"
                        > ĐẶT TOUR NGAY
                    </a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h2>Mô Tả Tour</h2>
                <hr>
                <p style="white-space: pre-line;"><?php echo $tour_description; ?></p>
            </div>
        </div>

       <div class="row mt-5">
            <div class="col-12">
                <h3>Lịch Trình Chi Tiết</h3>
                <hr>
                
                <?php 
                // Lấy biến $itineraries đã được truyền từ Controller
                if (isset($itineraries) && !empty($itineraries)): 
                ?>
                    <div class="itinerary-list">
                        <?php 
                        // Lặp qua từng ngày trong lịch trình
                        foreach ($itineraries as $item): 
                            $day_number = htmlspecialchars($item['day_number'] ?? '');
                            $title = htmlspecialchars($item['title'] ?? 'Tiêu đề không có');
                            $details = htmlspecialchars($item['details'] ?? 'Nội dung đang được cập nhật.');
                        ?>
                            <div class="itinerary-item mb-4 p-3 border rounded shadow-sm">
                                <h4><span class="text-primary">Ngày <?php echo $day_number; ?>:</span> <?php echo $title; ?></h4>
                                
                                <p style="white-space: pre-line; margin-top: 10px;"><?php echo $details; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                <?php else: ?>
                    <div class="alert alert-info">Lịch trình chi tiết cho tour này đang được cập nhật.</div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>

</body>
</html>