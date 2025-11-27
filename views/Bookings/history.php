<?php

$bookingId = htmlspecialchars($_GET['id'] ?? 'N/A');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử trạng thái Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <div class="container mt-5">
        
        <h1 class="mb-4 text-primary">Lịch sử trạng thái Booking #<?= $bookingId ?></h1>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center">Thời gian</th>
                        <th scope="col" class="text-center">Trạng thái cũ</th>
                        <th scope="col" class="text-center">Trạng thái mới</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($history)): ?>
                        <?php foreach($history as $h): ?>
                            <tr>
                                <td><?= htmlspecialchars($h['changed_at']) ?></td>
                                
                                <td>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($h['old_status']) ?></span>
                                </td>
                                <td>
                                    <span class="badge 
                                        <?php 
                                            // Gán màu sắc cho trạng thái mới
                                            $status = $h['new_status'];
                                            if ($status == 'Hoàn tất') echo 'bg-success';
                                            else if ($status == 'Đã cọc') echo 'bg-info text-dark';
                                            else if ($status == 'Chờ xác nhận') echo 'bg-warning text-dark';
                                            else if ($status == 'Hủy') echo 'bg-danger';
                                            else echo 'bg-primary';
                                        ?>
                                    "><?= htmlspecialchars($h['new_status']) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">Chưa có lịch sử thay đổi trạng thái nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="index.php?action=bookingIndex" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách Booking
            </a>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script> 
</body>
</html>