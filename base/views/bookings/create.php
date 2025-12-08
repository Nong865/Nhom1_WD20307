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
            border-radius: 18px; 
            overflow: hidden; 
            box-shadow: 0 10px 35px rgba(0,0,0,0.12); 
            background: white;
        }
        .form-label { font-weight: 600; color: #2c3e50; }
        .form-control, .form-select { 
            border-radius: 12px; 
            padding: 12px 16px; 
            border: 1.8px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus { 
            border-color: #3498db; 
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.2);
        }
        .form-check-input:checked { background-color: #2c3e50; border-color: #2c3e50; }
        .btn-success { background-color: #27ae60; border: none; border-radius: 12px; padding: 14px 32px; font-weight: 600; font-size: 1.1rem; }
        .btn-outline-secondary { border-radius: 12px; padding: 14px 28px; font-weight: 600; }
        .text-price { font-weight: 700; color: #e74c3c; }
        #groupMembersSection { 
            transition: all 0.4s ease; 
            background: linear-gradient(135deg, #f8f9fa, #e9ecef); 
            border: 1px solid #dee2e6; 
            border-radius: 12px;
        }
        .member-item { border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .input-group-text { background: #3498db; color: white; font-weight: bold; width: 50px; }
        .badge-count { background: #e74c3c; color: white; font-size: 1rem; padding: 0.4em 0.8em; border-radius: 50px; }
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
                        Tạo Booking Mới
                    </h2>

                    <!-- Thông báo từ Controller (nếu có) -->
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-<?= ($_GET['type'] ?? 'danger') === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show mb-4" role="alert">
                            <?= htmlspecialchars($_GET['message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form method="post" action="index.php?action=bookingStore" id="bookingForm" novalidate>

                        <!-- Tên khách hàng & SĐT -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tên khách hàng (người liên hệ)</label>
                                <input type="text" class="form-control" name="customer_name" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" name="customer_phone" placeholder="0901234567" pattern="[0-9]{10,11}" required>
                                <small class="text-muted">10-11 chữ số</small>
                            </div>
                        </div>

                        <!-- Loại khách -->
                        <div class="mb-4 p-4 bg-light rounded">
                            <label class="form-label fw-bold text-primary">Loại khách</label>
                            <div class="d-flex gap-5 mt-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="individual" value="individual" checked>
                                    <label class="form-check-label fw-semibold fs-5" for="individual">Khách lẻ</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="group" value="group">
                                    <label class="form-check-label fw-semibold fs-5" for="group">Khách đoàn</label>
                                </div>
                            </div>
                        </div>

                        <!-- Số lượng người -->
                        <div class="mb-4">
                            <label class="form-label">Số lượng người</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">Người</span>
                                <input type="number" class="form-control form-control-lg text-center fw-bold" 
                                       name="quantity" id="quantity" min="1" value="1" readonly required>
                                <span class="input-group-text bg-primary text-white">người</span>
                            </div>
                        </div>

                        <!-- Danh sách thành viên đoàn -->
                        <div id="groupMembersSection" style="display: none;" class="mb-4 p-4 rounded">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-bold text-primary m-0">
                                    Danh sách thành viên đoàn 
                                    <span class="badge badge-count ms-2" id="memberCount">0</span>
                                </label>
                            </div>
                            <div id="membersList" class="mt-3"></div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-3" onclick="addMember()">
                                + Thêm thành viên
                            </button>
                        </div>

                        <!-- Tour & Ngày khởi hành -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label">Tên tour</label>
                                <select class="form-select form-select-lg" name="tour_name" id="tour" required>
                                    <option value="">-- Chọn Tour --</option>
                                    <?php foreach ($tours as $tour): ?>
                                        <option value="<?= htmlspecialchars($tour['name']) ?>" 
                                                data-price="<?= $tour['price'] ?>">
                                            <?= htmlspecialchars($tour['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ngày khởi hành</label>
                                <input type="date" class="form-control form-control-lg" name="tour_date" 
                                       min="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>

                        <!-- HDV & Đối tác -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Hướng dẫn viên phụ trách</label>
                                <select class="form-select" name="huong_dan_vien_id">
                                    <option value="">-- Chưa phân công --</option>
                                    <?php foreach ($huongDanViens as $hdv): ?>
                                        <option value="<?= $hdv['id'] ?>">
                                            <?= htmlspecialchars($hdv['ho_ten']) ?> (<?= htmlspecialchars($hdv['chung_chi'] ?? 'N/A') ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nhà cung cấp / Đối tác</label>
                                <select class="form-select" name="partner_ids[]" multiple size="5">
                                    <?php foreach ($partners as $p): ?>
                                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Giữ Ctrl để chọn nhiều</small>
                            </div>
                        </div>

                        <!-- Yêu cầu đặc biệt -->
                        <div class="mb-4">
                            <label class="form-label">Yêu cầu đặc biệt</label>
                            <textarea class="form-control" name="special_request" rows="4" 
                                      placeholder="VD: Ăn chay, xe lăn, trẻ em dưới 5 tuổi..."></textarea>
                        </div>

                        <!-- Giá & Tổng tiền -->
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="form-label">Giá tour / người</label>
                                <input type="text" class="form-control form-control-lg text-price text-end fw-bold" id="price" readonly value="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tổng tiền (VNĐ)</label>
                                <input type="text" class="form-control form-control-lg text-price fs-3 fw-bold text-end" id="total" readonly value="0">
                                <input type="hidden" name="total_price" id="total_price_hidden" value="0">
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="index.php?action=bookingIndex" class="btn btn-outline-secondary btn-lg">
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-success btn-lg shadow">
                                Tạo Booking
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

    let memberIndex = 1;

    function updatePrice() {
        const selected = tourSelect.selectedOptions[0];
        const price = selected ? parseFloat(selected.dataset.price || 0) : 0;
        const qty   = parseInt(quantityInput.value) || 1;

        priceInput.value = price.toLocaleString('vi-VN') + ' ₫';
        const total = price * qty;
        totalInput.value = total.toLocaleString('vi-VN') + ' ₫';
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
        div.className = 'input-group mb-3 member-item';
        div.innerHTML = `
            <span class="input-group-text">${memberIndex}.</span>
            <input type="text" class="form-control" name="group_members[]" placeholder="Họ và tên" value="${name}" required>
            <button type="button" class="btn btn-outline-danger" 
                    onclick="this.parentElement.remove(); updateMemberCount(); renumberMembers();">
                Xóa
            </button>
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
    updatePrice();
</script>
</body>
</html>