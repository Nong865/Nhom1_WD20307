<?php
// File: views/bookings/edit.php
// Biến $booking, $huongDanViens, $tours đã được truyền từ Controller

// Lấy thông báo lỗi (nếu có)
$message = $_GET['message'] ?? '';
$type = $_GET['type'] ?? '';
?>

<div class="container-fluid">
    <h3 class="mb-4">Chỉnh sửa Booking #<?= $booking['id'] ?? '—' ?></h3>
    <a href="index.php?action=bookingIndex" class="btn btn-secondary mb-3">← Quay lại Danh sách Booking</a>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="index.php?action=bookingUpdate">
                
                <input type="hidden" name="id" value="<?= $booking['id'] ?? '' ?>">
                
                <h5 class="card-title mb-3 text-primary">Thông tin Khách hàng & Tour</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên khách hàng:</label>
                        <input name="customer_name" class="form-control" value="<?= htmlspecialchars($booking['customer_name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại:</label>
                        <input name="customer_phone" class="form-control" value="<?= htmlspecialchars($booking['customer_phone'] ?? '') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên Tour:</label>
                        <select name="tour_name" class="form-select" required>
                            <option value="">-- Chọn Tour --</option>
                            <?php foreach ($tours as $tour): ?>
                                <option 
                                    value="<?= htmlspecialchars($tour['name']) ?>"
                                    <?= ($booking['tour_name'] == $tour['name']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tour['name']) ?> (<?= number_format($tour['price']) ?> VNĐ)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Ngày Tour:</label>
                        <input name="tour_date" type="date" class="form-control" value="<?= date('Y-m-d', strtotime($booking['tour_date'] ?? 'now')) ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Số lượng:</label>
                        <input name="quantity" type="number" class="form-control" value="<?= $booking['quantity'] ?? 1 ?>" required min="1">
                    </div>
                </div>

                <h5 class="card-title mb-3 text-primary mt-4">Thông tin Quản lý</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hướng dẫn viên:</label>
                        <select name="huong_dan_vien_id" class="form-select">
                            <option value="">-- Chưa phân công --</option>
                            <?php foreach ($huongDanViens as $hdv): ?>
                                <option 
                                    value="<?= $hdv['id'] ?>"
                                    <?= ($booking['huong_dan_vien_id'] == $hdv['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($hdv['ho_ten']) ?> (CC: <?= htmlspecialchars($hdv['chung_chi']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
    <label class="form-label">Nhà cung cấp liên kết:</label>
    <select name="partner_ids[]" class="form-select" multiple size="5">
        <option value="">-- Chọn Nhà cung cấp (Chọn nhiều) --</option>
        <?php 
        // Lấy danh sách ID Partner hiện tại (chuyển đổi mảng object sang mảng ID để dễ so sánh)
        $currentPartnerIds = array_map(fn($p) => $p['id'], $booking['partners'] ?? []); 

        foreach ($partners as $partner): 
        ?>
            <option 
                value="<?= $partner['id'] ?>"
                <?php 
                // Kiểm tra xem ID của Partner có nằm trong mảng ID hiện tại không
                if (in_array($partner['id'], $currentPartnerIds)) {
                    echo 'selected';
                }
                ?>>
                <?= htmlspecialchars($partner['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <small class="form-text text-muted">Giữ phím Ctrl/Cmd để chọn nhiều.</small>
</div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng thái hiện tại:</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($booking['status'] ?? 'Chờ xác nhận') ?>" disabled>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Yêu cầu đặc biệt:</label>
                    <textarea name="special_request" class="form-control" rows="3"><?= htmlspecialchars($booking['special_request'] ?? '') ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-success mt-3 me-2">Cập nhật Booking</button>
                <a href="index.php?action=bookingIndex" class="btn btn-secondary mt-3">Hủy</a>
            </form>
        </div>
    </div>
</div>