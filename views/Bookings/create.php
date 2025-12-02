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
                    <label class="form-label">Nhân viên phụ trách</label>
                    <select class="form-select" name="staff_id" required>
                        <option value="">-- Chọn Nhân viên --</option>
                        <?php foreach ($staffs as $staff): ?>
                            <option value="<?= htmlspecialchars($staff['id']) ?>">
                                <?= htmlspecialchars($staff['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Nhà cung cấp liên quan</label>
                    <select class="form-select" name="supplier_id">
                        <option value="">-- Không có/Chọn Nhà cung cấp --</option>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?= htmlspecialchars($supplier['id']) ?>">
                                <?= htmlspecialchars($supplier['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
                    <select class="form-select" name="tour_name" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= htmlspecialchars($tour['name']) ?>">
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

    individualRadio.addEventListener('change', () => {
        quantityInput.value = 1;
        quantityInput.readOnly = true;
    });

    groupRadio.addEventListener('change', () => {
        quantityInput.value = '';
        quantityInput.readOnly = false;
    });
</script>

</body>
</html>
