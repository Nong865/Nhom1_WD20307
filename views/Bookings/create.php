<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Booking Mới - Quản Lý Tour</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
        .form-card { 
            border: none; 
            border-radius: 15px; 
            overflow: hidden; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
            background: white;
        }
        .form-label { font-weight: 500; color: #34495e; }
        .form-control, .form-select { 
            border-radius: 8px; 
            padding: 10px 15px; 
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
        }
        .form-check-input:checked { background-color: #2c3e50; border-color: #2c3e50; }
        .btn-success { background-color: #27ae60; border: none; border-radius: 8px; padding: 10px 20px; }
        .btn-outline-secondary { border-radius: 8px; padding: 10px 20px; }
        .text-price { font-weight: 600; color: #e74c3c; }
        small.text-muted { font-size: 13px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <!-- Card bao quanh form -->
            <div class="form-card">
                <div class="card-body p-4 p-md-5">

                    <!-- Tiêu đề -->
                    <h2 class="mb-4 text-primary fw-bold text-center">
                        <i class="bi bi-bookmark-plus-fill me-2"></i> Tạo Booking Mới
                    </h2>

                    <!-- Thông báo lỗi -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form method="post" action="index.php?action=bookingStore" id="bookingForm">

                        <!-- Tên khách hàng -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-person-fill me-2"></i> Tên khách hàng</label>
                            <input type="text" class="form-control" name="customer_name" placeholder="Ví dụ: Nguyễn Văn A" required>
                        </div>

                        <!-- Số điện thoại -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-telephone-fill me-2"></i> Số điện thoại</label>
                            <input type="tel" class="form-control" name="customer_phone" placeholder="Ví dụ: 0123456789" pattern="[0-9]{10,11}" required>
                            <small class="text-muted">Chỉ nhập số, 10-11 chữ số</small>
                        </div>

                        <!-- Hướng dẫn viên -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-person-badge-fill me-2"></i> Hướng dẫn viên phụ trách</label>
                            <select class="form-select" name="huong_dan_vien_id" required>
                                <option value="">-- Chọn Hướng dẫn viên --</option>
                                <?php foreach ($huongDanViens as $hdv): ?>
                                    <option value="<?= htmlspecialchars($hdv['id']) ?>">
                                        <?= htmlspecialchars($hdv['ho_ten']) ?> (CC: <?= htmlspecialchars($hdv['chung_chi']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Nhà cung cấp -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-building me-2"></i> Nhà cung cấp / Đối tác liên quan</label>
                            <select class="form-select" name="partner_ids[]" multiple size="5">
                                <?php foreach ($partners as $p): ?>
                                    <option value="<?= htmlspecialchars($p['id']) ?>"><?= htmlspecialchars($p['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Giữ Ctrl (hoặc Cmd) để chọn nhiều. Để trống nếu không cần.</small>
                        </div>

                        <!-- Loại khách -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-people-fill me-2"></i> Loại khách</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="individual" value="individual" checked>
                                    <label class="form-check-label" for="individual">Khách lẻ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="group" value="group">
                                    <label class="form-check-label" for="group">Khách đoàn</label>
                                </div>
                            </div>
                        </div>

                        <!-- Số lượng người -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-person-lines-fill me-2"></i> Số lượng người</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="1" readonly required>
                        </div>

                        <!-- Tên tour -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-map-fill me-2"></i> Tên tour</label>
                            <select class="form-select" name="tour_name" id="tour" required>
                                <option value="">-- Chọn Tour --</option>
                                <?php foreach ($tours as $tour): ?>
                                    <option value="<?= htmlspecialchars($tour['name']) ?>" data-price="<?= $tour['price'] ?>">
                                        <?= htmlspecialchars($tour['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Ngày khởi hành -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-calendar-event-fill me-2"></i> Ngày khởi hành</label>
                            <input type="date" class="form-control" name="tour_date" min="<?= date('Y-m-d') ?>" required>
                            <small class="text-muted">Chọn ngày từ hôm nay trở đi</small>
                        </div>

                        <!-- Yêu cầu đặc biệt -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-chat-dots-fill me-2"></i> Yêu cầu đặc biệt</label>
                            <textarea class="form-control" name="special_request" rows="3" placeholder="Ví dụ: Khách ăn chay, cần xe lăn..."></textarea>
                        </div>

                        <!-- Giá tour -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-cash-stack me-2"></i> Giá tour (VNĐ)</label>
                            <input type="text" class="form-control text-price" id="price" readonly>
                        </div>

                        <!-- Tổng tiền -->
                        <div class="mb-5">
                            <label class="form-label"><i class="bi bi-wallet-fill me-2"></i> Tổng tiền (VNĐ)</label>
                            <input type="text" class="form-control text-price fs-5 fw-bold" id="total" readonly>
                            <input type="hidden" name="total_price" id="total_price_hidden">
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="index.php?action=bookingIndex" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-1"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg me-1"></i> Tạo Booking
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const individualRadio = document.getElementById('individual');
    const groupRadio = document.getElementById('group');
    const quantityInput = document.getElementById('quantity');
    const tourSelect = document.getElementById('tour');
    const priceInput = document.getElementById('price');
    const totalInput = document.getElementById('total');
    const totalHidden = document.getElementById('total_price_hidden');

    function setForIndividual() {
        quantityInput.value = 1;
        quantityInput.readOnly = true;
    }

    function setForGroup() {
        quantityInput.value = '';
        quantityInput.readOnly = false;
        quantityInput.focus();
    }

    function updatePrice() {
        const selectedOption = tourSelect.options[tourSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price || 0);
        const quantity = parseInt(quantityInput.value) || 1;

        priceInput.value = price.toLocaleString('vi-VN');
        const totalPrice = price * quantity;
        totalInput.value = totalPrice.toLocaleString('vi-VN');
        totalHidden.value = totalPrice;
    }

    individualRadio.addEventListener('change', () => { if (individualRadio.checked) { setForIndividual(); updatePrice(); } });
    groupRadio.addEventListener('change', () => { if (groupRadio.checked) { setForGroup(); updatePrice(); } });
    quantityInput.addEventListener('input', updatePrice);
    tourSelect.addEventListener('change', updatePrice);

    // Khởi tạo
    if (individualRadio.checked) setForIndividual();
    updatePrice();
</script>

</body>
</html>