<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Booking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<div class="container-fluid mt-4">

    <h1 class="mb-4 text-primary"><i class="fas fa-list-alt me-2"></i> Danh sách Booking</h1>

    <div class="mb-3">
        <a href="index.php?action=bookingCreate" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Tạo booking mới
        </a>
    </div>

    <?php
        // Hàm xác định class badge theo trạng thái
        function getStatusBadgeClass($status) {
            return match($status) {
                'Hoàn thành' => 'bg-success',
                'Đã xác nhận' => 'bg-primary', 
                'Đã cọc'=> 'bg-info text-dark',
                'Chờ xác nhận' => 'bg-warning text-dark',
                'Đã hủy' => 'bg-danger',
                default => 'bg-secondary',
            };
        }
    ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Loại</th>
                    <th>Số lượng</th>
                    <th>Tour</th>
                    <th>Nhân viên</th>
                    <th>Nhà cung cấp</th> 
                    <th>Ngày tour</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>

            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><?= htmlspecialchars($b['id']) ?></td>
                        <td><?= htmlspecialchars($b['customer_name']) ?></td>
                        <td><?= htmlspecialchars($b['customer_phone']) ?></td>
                        <td><?= htmlspecialchars($b['type'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($b['quantity']) ?></td>
                        <td><?= htmlspecialchars($b['tour_name']) ?></td>
                        <td><?= htmlspecialchars($b['staff_name'] ?? 'Chưa chỉ định') ?></td> 
                        <td>
                            <?php
                                if (!empty($b['partners']) && is_array($b['partners'])) {
                                    $partnerNames = array_map(fn($p) => $p['name'], $b['partners']);
                                    echo htmlspecialchars(implode(', ', $partnerNames));
                                } else {
                                    echo 'N/A';
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($b['tour_date']) ?></td>
                        <td><?= htmlspecialchars($b['booking_date']) ?></td>
                        <td>
                            <span class="badge <?= getStatusBadgeClass($b['status']) ?>">
                                <?= htmlspecialchars($b['status']) ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <form method="post" action="index.php?action=bookingUpdateStatus" class="d-inline-flex gap-2 align-items-center">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($b['id']) ?>">
                                <select name="status" class="form-select form-select-sm">
                                    <?php 
                                    $statuses = ['Chờ xác nhận', 'Đã xác nhận', 'Đã hủy', 'Hoàn thành', 'Đã cọc'];
                                    foreach ($statuses as $status): ?>
                                        <option value="<?= $status ?>" <?= ($b['status'] == $status) ? 'selected' : '' ?>>
                                            <?= $status ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>

                            <a href="index.php?action=bookingHistory&id=<?= htmlspecialchars($b['id']) ?>" 
                               class="btn btn-secondary btn-sm ms-1">
                                <i class="fas fa-history"></i> Lịch sử
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" class="text-center text-muted py-3">
                        Không có booking nào.
                    </td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
