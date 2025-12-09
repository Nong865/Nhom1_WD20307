<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Booking</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f5f7fa; }
        .card { border: none; border-radius: 12px; overflow: hidden; }
        .table thead { background-color: #2c3e50; }
        .badge { font-size: 12.5px; padding: 6px 10px; }
        .text-price { font-weight: 600; color: #e74c3c; }
        .btn-group .btn { padding: 5px 10px; }
        tr:hover { background-color: #f8f9fa !important; }
    </style>
</head>
<body>

<div class="container-fluid py-4">

    <!-- Tiêu đề + nút tạo mới -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary fw-bold">
            <i class="bi bi-bookmark-check-fill me-2"></i> Danh sách Booking
        </h2>
        <a href="index.php?action=bookingCreate" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tạo booking mới
        </a>
    </div>

    <!-- Thống kê nhanh -->
    <div class="row mb-3 g-3">
        <div class="col-auto">
            <span class="text-muted small">Tổng: <strong class="text-dark"><?= count($bookings) ?></strong> booking</span>
        </div>
        <div class="col-auto">
            <span class="text-muted small">Hôm nay: <strong class="text-primary"><?= date('d/m/Y') ?></strong></span>
        </div>
    </div>

    <!-- Bảng chính -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 14.5px;">
                    <thead class="text-white">
                        <tr>
                            <th class="text-center" width="4%">#</th>
                            <th width="13%">Khách hàng</th>
                            <th width="9%">SĐT</th>
                            <th width="6%">Loại</th>
                            <th width="5%" class="text-center">SL</th>
                            <th width="15%">Tour</th>
                            <th width="9%" class="text-end">Giá 1 người</th>
                            <th width="10%" class="text-end text-price">Tổng tiền</th>
                            <th width="12%">HDV</th>
                            <th width="12%">Nhà cung cấp</th>
                            <th width="8%" class="text-center">Ngày tour</th>
                            <th width="6%" class="text-center">Trạng thái</th>
                            <th width="10%" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="13" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-5 d-block mb-3"></i>
                                <h5>Chưa có booking nào</h5>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
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

                        <?php foreach ($bookings as $index => $b): ?>
                        <tr>
                            <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>

                            <td class="fw-semibold"><?= htmlspecialchars($b['customer_name']) ?></td>
                            <td><?= htmlspecialchars($b['customer_phone']) ?></td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <?= $b['type'] == 'group' ? 'Nhóm' : 'Lẻ' ?>
                                </span>
                            </td>
                            <td class="text-center fw-bold"><?= $b['quantity'] ?></td>

                            <td class="small">
                                <div class="fw-semibold"><?= htmlspecialchars($b['tour_name']) ?></div>
                            </td>

                            <td class="text-end text-price">
                                <?= number_format(($b['total_price'] ?? 0) / max(1, $b['quantity']), 0, ',', '.') ?>đ
                            </td>
                            <td class="text-end text-price fw-bold">
                                <?= number_format($b['total_price'] ?? 0, 0, ',', '.') ?>đ
                            </td>

                            <td class="small">
                                <div class="fw-semibold"><?= htmlspecialchars($b['hdv_ho_ten'] ?? 'Chưa có') ?></div>
                                <?php if (!empty($b['hdv_chung_chi'])): ?>
                                    <small class="text-muted">(<?= htmlspecialchars($b['hdv_chung_chi']) ?>)</small>
                                <?php endif; ?>
                            </td>

                           <td class="small text-muted" style="max-width: 180px;">
    <?php
    if (!empty($b['partners']) && is_array($b['partners'])) {
        $names = array_map(fn($p) => $p['name'], $b['partners']);
        echo implode(', ', $names);
    } else {
        echo '<em>—</em>'; // Hiển thị '—' khi mảng rỗng
    }
    ?>
</td>

                            <td class="text-center">
                                <div class="small fw-bold text-primary">
                                    <?= date('d/m', strtotime($b['tour_date'])) ?>
                                </div>
                                <small class="text-muted"><?= date('Y', strtotime($b['tour_date'])) ?></small>
                            </td>

                            <td class="text-center">
                                <span class="badge <?= getStatusBadge($b['status']) ?> rounded-pill px-3">
                                    <?= $b['status'] ?>
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">

                                    <!-- Cập nhật trạng thái nhanh -->
                                    <form method="post" action="index.php?action=bookingUpdateStatus" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                        <select name="status" onchange="this.form.submit()" 
                                                class="form-select form-select-sm d-inline-block" style="width: auto;">
                                            <?php 
                                            $options = ['Chờ xác nhận', 'Đã xác nhận', 'Đã cọc', 'Hoàn thành', 'Đã hủy'];
                                            foreach ($options as $opt): ?>
                                                <option value="<?= $opt ?>" <?= $b['status'] === $opt ? 'selected' : '' ?>>
                                                    <?= $opt ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>

                                    <!-- Xem lịch sử -->
                                    <a href="index.php?action=bookingHistory&id=<?= $b['id'] ?>" 
                                       class="btn btn-outline-secondary btn-sm" title="Lịch sử">
                                        <i class="bi bi-clock-history"></i>
                                    </a>
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
    <div class="btn-group btn-group-sm" role="group">
        
        <a href="index.php?action=bookingDetail&id=<?= $b['id'] ?>" 
           class="btn btn-outline-info btn-sm" title="Chi tiết">
            <i class="bi bi-eye"></i>
        </a>
        
        <a href="index.php?action=bookingEdit&id=<?= $b['id'] ?>" 
           class="btn btn-outline-warning btn-sm" title="Sửa">
            <i class="bi bi-pencil"></i>
        </a>

        <a href="index.php?action=bookingDelete&id=<?= $b['id'] ?>" 
           class="btn btn-outline-danger btn-sm" 
           onclick="return confirm('Bạn có chắc chắn muốn xóa Booking #<?= $b['id'] ?>?')" 
           title="Xóa">
            <i class="bi bi-trash"></i>
        </a>
        
        <form method="post" action="index.php?action=bookingUpdateStatus" class="d-inline">
            </form>

       
    </div>
</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>