<?php
// Giả định $bookings là mảng dữ liệu booking được Controller truyền sang
// require_once __DIR__ . '/../../models/Booking.php';
// $bookingModel = new Booking();
// $bookings = $bookingModel->all();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH572Xy+p1N2Vp6sT28pE4j+qR9L2V3N9f6N0yK2JjP0L0Vp0V0V3I6yW8z2wL5/y/N/ZzEw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    <div class="container-fluid mt-4">
        
        <h1 class="mb-4 text-primary"><i class="fas fa-list-alt me-2"></i> Danh sách Booking</h1>
        
        <div class="mb-3">
            <a href="index.php?action=bookingCreate" class="btn btn-success">
                <i class="fas fa-plus me-1"></i> Tạo booking mới
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 5%;">ID</th>
                        <th scope="col" style="width: 20%;">Khách hàng</th>
                        <th scope="col" style="width: 15%;">Tour</th>
                        <th scope="col" style="width: 10%;">Ngày đặt</th>
                        <th scope="col" style="width: 15%;">Trạng thái</th>
                        <th scope="col" style="width: 35%;" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php foreach($bookings as $b): ?>
                            <tr>
                                <td><?= htmlspecialchars($b['id']) ?></td>
                                <td><?= htmlspecialchars($b['customer_name']) ?></td>
                                <td><?= htmlspecialchars($b['tour_name']) ?></td>
                                <td><?= htmlspecialchars($b['booking_date']) ?></td>
                                <td>
                                    <span class="badge 
                                        <?php 
                                            // Hàm gán màu (Nên đặt trong file helper/utility)
                                            function getStatusBadgeClass($status) {
                                                switch ($status) {
                                                    case 'Hoàn tất': return 'bg-success';
                                                    case 'Đã cọc': return 'bg-info text-dark';
                                                    case 'Chờ xác nhận': return 'bg-warning text-dark';
                                                    case 'Hủy': return 'bg-danger';
                                                    default: return 'bg-primary';
                                                }
                                            }
                                            echo getStatusBadgeClass($b['status']);
                                        ?>
                                    ">
                                        <?= htmlspecialchars($b['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <form method="post" action="index.php?action=bookingUpdateStatus" class="d-flex gap-2">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($b['id']) ?>">
                                            
                                            <select name="status" class="form-select form-select-sm" style="width: auto;">
                                                <?php 
                                                $statuses = ['Chờ xác nhận', 'Đã cọc', 'Hoàn tất', 'Hủy'];
                                                foreach ($statuses as $status): 
                                                ?>
                                                    <option value="<?= $status ?>" 
                                                        <?= ($b['status'] == $status) ? 'selected' : '' ?>>
                                                        <?= $status ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-sync-alt"></i> Cập nhật
                                            </button>
                                        </form>
                                        
                                        <a href="index.php?action=bookingHistory&id=<?= htmlspecialchars($b['id']) ?>" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-history"></i> Lịch sử
                                        </a>
                                        </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Không tìm thấy Booking nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>