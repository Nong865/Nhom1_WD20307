<?php
// Lấy Booking ID từ URL, sử dụng N/A nếu không tồn tại
$bookingId = htmlspecialchars($_GET['id'] ?? 'N/A');

// Đảm bảo $history tồn tại và là mảng, nếu không sẽ là mảng rỗng
$history = $history ?? [];


function getStatusBadgeClass($status) {
    if ($status === null || $status === '') {
        // Trường hợp trạng thái cũ là NULL (bản ghi lịch sử đầu tiên)
        return 'bg-secondary';
    }
    
    // Sử dụng match cho các trạng thái cụ thể
    return match ($status) {
        'Hoàn thành' => 'bg-success', 
        'Đã xác nhận'  => 'bg-primary', 
        'Đã cọc' => 'bg-info text-dark',
        'Chờ xác nhận' => 'bg-warning text-dark',
        'Đã hủy' => 'bg-danger', 
        default  => 'bg-secondary' 
    };
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử trạng thái Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<div class="container mt-5">
    
    <h1 class="mb-4 text-primary">📑 Lịch sử trạng thái Booking #<?= $bookingId ?></h1>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Thời gian</th>
                    <th class="text-center">Trạng thái cũ</th>
                    <th class="text-center">Trạng thái mới</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($history)): ?>
                    <?php foreach($history as $h): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($h['changed_at']) ?></td>
                            
                            <td class="text-center">
                                <?php 
                                    $oldStatus = htmlspecialchars($h['old_status']);
                                    $oldStatusDisplay = $h['old_status'] ?? '--- Khởi tạo ---'; 
                                ?>
                                <span class="badge <?= getStatusBadgeClass($h['old_status']) ?>">
                                    <?= $oldStatusDisplay ?>
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge <?= getStatusBadgeClass($h['new_status']) ?>">
                                    <?= htmlspecialchars($h['new_status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Chưa có lịch sử thay đổi trạng thái nào.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="index.php?action=bookingIndex" class="btn btn-primary">
            ← Quay lại danh sách Booking
        </a>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>