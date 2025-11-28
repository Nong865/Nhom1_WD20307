<?php
$bookingId = htmlspecialchars($_GET['id'] ?? 'N/A');

// Đảm bảo $history tồn tại và là mảng
$history = isset($history) && is_array($history) ? $history : [];

// Hàm xác định class badge cho trạng thái mới (và cũ)
function getStatusBadgeClass($status) {
    return match ($status) {
        'Hoàn tất'      => 'bg-success',
        'Đã cọc'        => 'bg-info text-dark',
        'Chờ xác nhận'  => 'bg-warning text-dark',
        'Hủy'           => 'bg-danger',
        default         => 'bg-primary' // Dùng bg-primary hoặc bg-secondary cho trạng thái mặc định
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
    
    <h1 class="mb-4 text-primary">Lịch sử trạng thái Booking #<?= $bookingId ?></h1>
    
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
                                <span class="badge <?= getStatusBadgeClass($h['old_status']) ?>">
                                    <?= htmlspecialchars($h['old_status']) ?>
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