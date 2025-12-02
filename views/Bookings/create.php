<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Booking mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <h1 class="mb-4 text-primary">Tạo Booking mới</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?action=bookingStore">

                <div class="mb-3">
                    <label class="form-label">Tên khách hàng</label>
                    <input type="text" class="form-control" name="customer_name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" name="customer_phone" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hướng dẫn viên (HĐV) phụ trách</label>
                    <select class="form-select" name="huong_dan_vien_id" required>
                        <option value="">-- Chọn Hướng dẫn viên --</option>
                        <?php foreach ($huongDanViens as $hdv): ?>
                            <option value="<?= htmlspecialchars($hdv['id']) ?>">
                                <?= htmlspecialchars($hdv['ho_ten']) ?> (CC: <?= htmlspecialchars($hdv['chung_chi']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nhà cung cấp / Đối tác liên quan</label>
                    <select class="form-select" name="partner_ids[]" multiple size="5">
                        <?php foreach ($partners as $p): ?>
                            <option value="<?= htmlspecialchars($p['id']) ?>"><?= htmlspecialchars($p['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Giữ Ctrl (hoặc Cmd) để chọn nhiều nhà cung cấp</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại khách</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="individual" value="individual" checked>
                        <label class="form-check-label" for="individual">Khách lẻ</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="group" value="group">
                        <label class="form-check-label" for="group">Khách đoàn</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số lượng người</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="1" readonly required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tên tour</label>
                    <select class="form-select" name="tour_name" id="tour" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= htmlspecialchars($tour['name']) ?>" data-price="<?= $tour['price'] ?>">
                                <?= htmlspecialchars($tour['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày khởi hành</label>
                    <input type="date" class="form-control" name="tour_date" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Yêu cầu đặc biệt</label>
                    <textarea class="form-control" name="special_request" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá tour (VNĐ)</label>
                    <input type="text" class="form-control" id="price" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tổng tiền (VNĐ)</label>
                    <input type="text" class="form-control" id="total" readonly>
                    <input type="hidden" name="total_price" id="total_price_hidden">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Tạo Booking</button>
                    <a href="index.php?action=bookingIndex" class="btn btn-outline-secondary">Hủy</a>
                </div>

            </form>

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
    }

    function updatePrice() {
        const selectedOption = tourSelect.options[tourSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price || 0);
        const quantity = parseInt(quantityInput.value) || 1;

        priceInput.value = price.toLocaleString();
        totalInput.value = (price * quantity).toLocaleString();
        totalHidden.value = price * quantity;
    }

    individualRadio.addEventListener('change', () => {
        if (individualRadio.checked) {
            setForIndividual();
            updatePrice();
        }
    });

    groupRadio.addEventListener('change', () => {
        if (groupRadio.checked) {
            setForGroup();
            updatePrice();
        }
    });

    quantityInput.addEventListener('input', updatePrice);
    tourSelect.addEventListener('change', updatePrice);

    // Init
    if (individualRadio.checked) setForIndividual();
    updatePrice();
</script>

</body>
</html>