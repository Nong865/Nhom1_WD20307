<?php
$bookingId = htmlspecialchars($_GET['id'] ?? 'N/A');
$history = $history ?? [];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử trạng thái Booking #<?= $bookingId ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
        .badge { font-size: 0.9rem; padding: 0.5em 1em; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                Lịch sử trạng thái Booking #<?= $bookingId ?>
            </h4>
            <a href="index.php?action=bookingIndex" class="btn btn-light btn-sm">
                ← Quay lại
            </a>
        </div>
        <div class="card-body">
            <?php
            function getStatusBadge($status) {
                if ($status === null || $status === '') return 'bg-secondary';
                return match($status) {
                    'Hoàn thành'     => 'bg-success',
                    'Đã xác nhận'    => 'bg-primary',
                    'Đã cọc'         => 'bg-info text-dark',
                    'Chờ xác nhận'   => 'bg-warning text-dark',
                    'Đã hủy'         => 'bg-danger',
                    default          => 'bg-secondary',
                };
            }
            ?>

            <?php if (empty($history)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-clock-history display-4 d-block mb-3"></i>
                    <p>Chưa có thay đổi trạng thái nào.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Thời gian</th>
                                <th class="text-center">Từ trạng thái</th>
                                <th class="text-center">Đến trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $h): ?>
                            <tr>
                                <td class="text-center small text-muted">
                                    <?= date('d/m/Y H:i', strtotime($h['changed_at'] ?? 'now')) ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= getStatusBadge($h['old_status']) ?>">
                                        <?= $h['old_status'] ? htmlspecialchars($h['old_status']) : '<em>Khởi tạo</em>' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= getStatusBadge($h['new_status']) ?>">
                                        <?= htmlspecialchars($h['new_status'] ?? '') ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>