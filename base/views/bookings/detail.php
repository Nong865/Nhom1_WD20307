<?php
// File: views/bookings/detail.php
// Biến $booking đã được truyền từ BookingController->detail()

// Lấy thông báo (nếu có)
$message = $_GET['message'] ?? '';
$type = $_GET['type'] ?? '';

// ... (Hiển thị các thông báo nếu có)

?>

<div class="container-fluid">
    <h3 class="mb-4">Chi tiết Booking #<?= $booking['id'] ?? '—' ?></h3>
    <a href="index.php?action=bookingIndex" class="btn btn-secondary mb-3">
        ← Quay lại Danh sách Booking
    </a>

    <div class="card shadow">
        <div class="card-body">
            <h4>Thông tin Khách hàng</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tên khách hàng:</strong> <?= htmlspecialchars($booking['customer_name'] ?? '—') ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($booking['customer_phone'] ?? '—') ?></p>
                    <p><strong>Loại khách:</strong> <?= ($booking['type'] == 'group' ? 'Đoàn (Nhóm)' : 'Khách lẻ') ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Trạng thái:</strong> <?= htmlspecialchars($booking['status'] ?? 'Chưa xác định') ?></p>
                    <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($booking['booking_date'] ?? 'now')) ?></p>
                    <p><strong>Yêu cầu đặc biệt:</strong> <?= nl2br(htmlspecialchars($booking['special_request'] ?? 'Không')) ?></p>
                </div>
            </div>

            <h4>Thông tin Tour và Hướng dẫn viên</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tên Tour:</strong> <?= htmlspecialchars($booking['tour_name'] ?? '—') ?></p>
                    <p><strong>Ngày Tour:</strong> <?= date('d/m/Y', strtotime($booking['tour_date'] ?? 'now')) ?></p>
                    <p><strong>Số lượng:</strong> <?= $booking['quantity'] ?? 0 ?> người</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tổng tiền:</strong> <?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?> VNĐ</p>
                    <p><strong>HDV:</strong> <?= htmlspecialchars($booking['hdv_ho_ten'] ?? 'Chưa phân công') ?></p>
                </div>
            </div>
            
            </div>
    </div>
</div>