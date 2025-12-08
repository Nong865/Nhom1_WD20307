<?php
// File: views/bookings/edit.php
// Biến $booking, $huongDanViens, $tours, $partners đã được truyền từ Controller

$message = $_GET['message'] ?? '';
$type    = $_GET['type'] ?? 'danger';

// Dữ liệu an toàn
$booking      = $booking ?? [];
$groupMembers = $booking['group_members'] ?? [];
$isGroup      = ($booking['type'] ?? 'individual') === 'group';

// Danh sách trạng thái đúng theo enum trong DB
$statusOptions = ['Chờ xác nhận', 'Đã xác nhận', 'Đã cọc', 'Hoàn thành', 'Đã hủy'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Booking #<?= $booking['id'] ?? '—' ?></title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
        .form-card { 
            border: none; 
            border-radius: 15px; 
            overflow: hidden; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); 
            background: white;
        }
        .form-label { font-weight: 600; color: #2c3e50; }
        .form-control, .form-select { 
            border-radius: 10px; 
            padding: 11px 15px; 
            border: 1.5px solid #ddd;
        }
        .form-control:focus, .form-select:focus { 
            border-color: #3498db; 
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .form-check-input:checked { background-color: #2c3e50; border-color: #2c3e50; }
        .btn-success { background-color: #27ae60; border: none; border-radius: 10px; padding: 12px 30px; font-weight: 600; }
        .btn-outline-secondary { border-radius: 10px; padding: 12px 25px; }
        .text-price { font-weight: 700; color: #e74c3c; }
        #groupMembersSection { transition: all 0.4s ease; background: #f8f9fa; border: 1px solid #e9ecef; }
        .member-item { border-radius: 8px; overflow: hidden; }
        .input-group-text { background: #3498db; color: white; font-weight: bold; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">

            <!-- Card chính -->
            <div class="form-card">
                <div class="card-body p-5">

                    <!-- Tiêu đề -->
                    <h2 class="text-center text-primary fw-bold mb-4">
                        Chỉnh sửa Booking #<?= $booking['id'] ?? '—' ?>
                    </h2>

                    <!-- Thông báo -->
                    <?php if ($message): ?>
                        <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show mb-4" role="alert">
                            <?= htmlspecialchars($message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form method="post" action="index.php?action=bookingUpdate" id="bookingForm" novalidate>

                        <input type="hidden" name="id" value="<?= $booking['id'] ?? '' ?>">

                        <!-- Tên khách hàng & SĐT -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tên khách hàng (người liên hệ)</label>
                                <input type="text" class="form-control" name="customer_name" 
                                       value="<?= htmlspecialchars($booking['customer_name'] ?? '') ?>" 
                                       placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" name="customer_phone" 
                                       value="<?= htmlspecialchars($booking['customer_phone'] ?? '') ?>" 
                                       pattern="[0-9]{10,11}" required>
                                <small class="text-muted">10-11 chữ số</small>
                            </div>
                        </div>

                        <!-- Loại khách -->
                        <div class="mb-4">
                            <label class="form-label">Loại khách</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="individual" value="individual" 
                                           <?= !$isGroup ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-semibold" for="individual">Khách lẻ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="group" value="group" 
                                           <?= $isGroup ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-semibold" for="group">Khách đoàn</label>
                                </div>
                            </div>
                        </div>

                        <!-- Số lượng người -->
                        <div class="mb-4">
                            <label class="form-label">Số lượng người</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" min="1" 
                                   value="<?= (int)($booking['quantity'] ?? 1) ?>" readonly required>
                        </div>

                        <!-- Danh sách thành viên đoàn -->
                        <div id="groupMembersSection" style="display: <?= $isGroup ? 'block' : 'none' ?>;" class="mb-4 p-4 rounded">
                            <label class="form-label fw-bold text-primary">
                                Danh sách thành viên đoàn (<span id="memberCount"><?= count($groupMembers) ?></span> người)
                            </label>
                            <div id="membersList" class="mt-3">
                                <?php foreach ($groupMembers as $index => $member): ?>
                                    <div class="input-group mb-2 member-item">
                                        <span class="input-group-text"><?= $index + 1 ?>.</span>
                                        <input type="text" class="form-control" name="group_members[]" 
                                               value="<?= htmlspecialchars(is_array($member) ? ($member['name'] ?? '') : $member) ?>" 
                                               placeholder="Họ và tên" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeMember(this)">Xóa</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success mt-3" onclick="addMember()">
                                + Thêm thành viên
                            </button>
                        </div>

                        <!-- Tour & Ngày khởi hành -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label">Tên tour</label>
                                <select class="form-select" name="tour_name" id="tour" required>
                                    <option value="">-- Chọn Tour --</option>
                                    <?php foreach ($tours as $tour): ?>
                                        <option value="<?= htmlspecialchars($tour['name']) ?>" 
                                                data-price="<?= $tour['price'] ?>"
                                                <?= ($booking['tour_name'] ?? '') === $tour['name'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($tour['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ngày khởi hành</label>
                                <input type="date" class="form-control" name="tour_date" 
                                       value="<?= $booking['tour_date'] ?? '' ?>" min="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>

                        <!-- HDV & Đối tác -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Hướng dẫn viên phụ trách</label>
                                <select class="form-select" name="huong_dan_vien_id">
                                    <option value="">-- Chưa phân công --</option>
                                    <?php foreach ($huongDanViens as $hdv): ?>
                                        <option value="<?= $hdv['id'] ?>" 
                                                <?= ($booking['huong_dan_vien_id'] ?? '') == $hdv['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($hdv['ho_ten']) ?> (<?= htmlspecialchars($hdv['chung_chi'] ?? '') ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nhà cung cấp / Đối tác</label>
                                <select class="form-select" name="partner_ids[]" multiple size="5">
                                    <?php 
                                    $currentIds = array_column($booking['partners'] ?? [], 'id');
                                    foreach ($partners as $p): ?>
                                        <option value="<?= $p['id'] ?>" <?= in_array($p['id'], $currentIds) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Giữ Ctrl để chọn nhiều</small>
                            </div>
                        </div>

                        <!-- Yêu cầu đặc biệt -->
                        <div class="mb-4">
                            <label class="form-label">Yêu cầu đặc biệt</label>
                            <textarea class="form-control" name="special_request" rows="3" 
                                      placeholder="VD: Ăn chay, xe lăn, trẻ em..."><?= htmlspecialchars($booking['special_request'] ?? '') ?></textarea>
                        </div>

                        <!-- Trạng thái -->
                        <div class="mb-4">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="status" required>
                                <?php foreach ($statusOptions as $opt): ?>
                                    <option value="<?= $opt ?>" <?= ($booking['status'] ?? '') === $opt ? 'selected' : '' ?>>
                                        <?= $opt ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Giá & Tổng tiền -->
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="form-label">Giá tour / người</label>
                                <input type="text" class="form-control text-price" id="price" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tổng tiền (VNĐ)</label>
                                <input type="text" class="form-control text-price fs-4 fw-bold" id="total" readonly>
                                <input type="hidden" name="total_price" id="total_price_hidden" value="<?= $booking['total_price'] ?? 0 ?>">
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="index.php?action=bookingIndex" class="btn btn-outline-secondary btn-lg">
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                Cập nhật Booking
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
    const groupRadio      = document.getElementById('group');
    const quantityInput   = document.getElementById('quantity');
    const tourSelect      = document.getElementById('tour');
    const priceInput      = document.getElementById('price');
    const totalInput      = document.getElementById('total');
    const totalHidden     = document.getElementById('total_price_hidden');
    const groupSection    = document.getElementById('groupMembersSection');
    const membersList     = document.getElementById('membersList');
    const memberCount     = document.getElementById('memberCount');

    let memberIndex = <?= count($groupMembers) + 1 ?>;

    function updatePrice() {
        const selected = tourSelect.selectedOptions[0];
        const price = selected ? parseFloat(selected.dataset.price || 0) : 0;
        const qty   = parseInt(quantityInput.value) || 1;

        priceInput.value = price.toLocaleString('vi-VN');
        const total = price * qty;
        totalInput.value = total.toLocaleString('vi-VN');
        totalHidden.value = total;
    }

    function updateMemberCount() {
        const count = membersList.children.length;
        memberCount.textContent = count;
        quantityInput.value = count;
        updatePrice();
    }

    function renumberMembers() {
        const items = membersList.querySelectorAll('.member-item');
        let idx = 1;
        items.forEach(item => {
            item.querySelector('.input-group-text').textContent = idx + '.';
            idx++;
        });
        memberIndex = idx;
    }

    function addMember(name = '') {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 member-item';
        div.innerHTML = `
            <span class="input-group-text">${memberIndex}.</span>
            <input type="text" class="form-control" name="group_members[]" placeholder="Họ và tên" value="${name}" required>
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove(); updateMemberCount(); renumberMembers();">Xóa</button>
        `;
        membersList.appendChild(div);
        memberIndex++;
        updateMemberCount();
    }

    // Radio: Loại khách
    individualRadio.addEventListener('change', () => {
        if (individualRadio.checked) {
            groupSection.style.display = 'none';
            quantityInput.value = 1;
            quantityInput.readOnly = true;
            membersList.innerHTML = '';
            memberIndex = 1;
            updatePrice();
        }
    });

    groupRadio.addEventListener('change', () => {
        if (groupRadio.checked) {
            groupSection.style.display = 'block';
            quantityInput.readOnly = false;
            if (membersList.children.length === 0) addMember();
            updateMemberCount();
        }
    });

    // Khi thay đổi số lượng (đoàn)
    quantityInput.addEventListener('input', () => {
        if (!groupRadio.checked) return;
        const desired = parseInt(quantityInput.value) || 0;
        const current = membersList.children.length;

        if (desired > current) {
            for (let i = current; i < desired; i++) addMember();
        } else if (desired < current) {
            quantityInput.value = current;
            alert(`Không thể giảm dưới số thành viên đã nhập (${current} người)`);
        }
    });

    tourSelect.addEventListener('change', updatePrice);

    // Khởi tạo
    if (!groupRadio.checked) {
        quantityInput.readOnly = true;
    }
    updatePrice();
</script>
</body>
</html>