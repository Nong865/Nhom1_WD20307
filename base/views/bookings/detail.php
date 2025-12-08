<?php
// File: views/bookings/detail.php
$message = $_GET['message'] ?? '';
$type    = $_GET['type'] ?? '';

// Dữ liệu an toàn
$booking = $booking ?? [];
$groupMembers = $booking['group_members'] ?? [];
$isGroup = ($booking['type'] ?? 'individual') === 'group';

// Hàm trả về class badge cho trạng thái (tiếng Việt - khớp DB)
function getStatusBadge($status) {
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

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Booking #<?= $booking['id'] ?? '—' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; }
        .card-header { background: linear-gradient(135deg, #2c3e50, #3498db); color: white; }
        .badge { font-size: 0.9rem; padding: 0.5em 1em; border-radius: 50px; }
        .text-price { color: #e74c3c; font-weight: 700; }
        .list-group-item { padding: 0.75rem 1.25rem; }
        .list-group-item:hover { background-color: #f8f9fa; }
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>

<div class="container-fluid py-5">

    <!-- Thông báo -->
    <?php if ($message): ?>
        <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show mb-4" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Tiêu đề + Quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-primary fw-bold">
            Chi tiết Booking #<span class="text-dark"><?= $booking['id'] ?? '—' ?></span>
        </h3>
        <a href="index.php?action=bookingIndex" class="btn btn-outline-secondary no-print">
            Quay lại danh sách
        </a>
    </div>

    <div class="row g-4">

        <!-- Card Thông tin chính -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Booking</h5>
                </div>
                <div class="card-body p-4">

                    <!-- Thông tin khách hàng -->
                    <h6 class="border-bottom pb-2 mb-3 text-primary fw-bold">Thông tin khách hàng</h6>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><td width="160"><strong>Tên khách hàng</strong></td>
                                    <td>: <?= htmlspecialchars($booking['customer_name'] ?? '—') ?></td></tr>
                                <tr><td><strong>Số điện thoại</strong></td>
                                    <td>: <a href="tel:<?= htmlspecialchars($booking['customer_phone'] ?? '') ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($booking['customer_phone'] ?? '—') ?>
                                        </a></td></tr>
                                <tr><td><strong>Loại khách</strong></td>
                                    <td>: <span class="badge <?= $isGroup ? 'bg-info' : 'bg-success' ?>">
                                            <?= $isGroup ? 'Khách đoàn (Nhóm)' : 'Khách lẻ' ?>
                                        </span></td></tr>
                                <tr><td><strong>Ngày đặt</strong></td>
                                    <td>: <?= date('d/m/Y H:i', strtotime($booking['booking_date'] ?? 'now')) ?></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><td width="140"><strong>Trạng thái</strong></td>
                                    <td>: <span class="badge <?= getStatusBadge($booking['status'] ?? '') ?> px-3 py-2">
                                            <?= htmlspecialchars($booking['status'] ?? 'Chưa xác định') ?>
                                        </span></td></tr>
                                <tr><td><strong>Yêu cầu đặc biệt</strong></td>
                                    <td>: <?= $booking['special_request'] 
                                            ? nl2br(htmlspecialchars($booking['special_request'])) 
                                            : '<em class="text-muted">Không có</em>' ?></td></tr>
                            </table>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Thông tin Tour -->
                    <h6 class="border-bottom pb-2 mb-3 text-primary fw-bold">Thông tin Tour</h6>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><td width="160"><strong>Tên Tour</strong></td>
                                    <td>: <strong><?= htmlspecialchars($booking['tour_name'] ?? '—') ?></strong></td></tr>
                                <tr><td><strong>Ngày khởi hành</strong></td>
                                    <td>: <strong class="text-primary">
                                            <?= date('d/m/Y', strtotime($booking['tour_date'] ?? 'now')) ?>
                                        </strong>
                                        <small class="text-muted">(Thứ <?= date('N', strtotime($booking['tour_date'] ?? 'now')) === '7' ? 'CN' : date('N', strtotime($booking['tour_date'] ?? 'now')) ?>)</small>
                                    </td></tr>
                                <tr><td><strong>Số lượng</strong></td>
                                    <td>: <strong class="text-primary fs-5"><?= (int)($booking['quantity'] ?? 0) ?></strong> người</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><td width="160"><strong>Hướng dẫn viên</strong></td>
                                    <td>: <?= htmlspecialchars($booking['hdv_ho_ten'] ?? '<em class="text-muted">Chưa phân công</em>') ?></td></tr>
                                <?php if (!empty($booking['hdv_chung_chi'])): ?>
                                <tr><td></td><td><small class="text-muted">(<?= htmlspecialchars($booking['hdv_chung_chi']) ?>)</small></td></tr>
                                <?php endif; ?>
                                <tr><td><strong>Tổng tiền</strong></td>
                                    <td>: <span class="fs-4 fw-bold text-price">
                                            <?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?> ₫
                                        </span></td></tr>
                            </table>
                        </div>
                    </div>

                    <!-- Nhà cung cấp -->
                    <?php if (!empty($booking['partners'])): ?>
                    <hr class="my-4">
                    <h6 class="border-bottom pb-2 mb-3 text-primary fw-bold">Nhà cung cấp / Đối tác</h6>
                    <div class="row">
                        <div class="col-12">
                            <?php 
                            $partnerNames = array_map(fn($p) => htmlspecialchars($p['name'] ?? ''), $booking['partners']);
                            echo implode(' • ', $partnerNames);
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Card Danh sách đoàn (chỉ hiện nếu là khách đoàn) -->
        <?php if ($isGroup && !empty($groupMembers)): ?>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        Danh sách thành viên đoàn (<?= count($groupMembers) ?> người)
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($groupMembers as $i => $member): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= $i + 1 ?>.</strong> 
                                    <?= htmlspecialchars(is_array($member) ? ($member['name'] ?? '—') : $member) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer text-center bg-light">
                    <strong>Tổng <?= count($groupMembers) ?> thành viên</strong>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <!-- Nút hành động -->
    <div class="mt-5 text-end no-print">
        <button class="btn btn-outline-primary btn-lg me-3" onclick="window.print()">
            In trang
        </button>
        <a href="index.php?action=bookingEdit&id=<?= $booking['id'] ?? '' ?>" class="btn btn-warning btn-lg text-white">
            Chỉnh sửa Booking
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>