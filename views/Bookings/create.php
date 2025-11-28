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

                <!-- TÊN KHÁCH -->
                <div class="mb-3">
                    <label class="form-label">Tên khách hàng</label>
                    <input type="text" class="form-control" name="customer_name" required>
                </div>

                <!-- SỐ ĐIỆN THOẠI -->
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" name="customer_phone" required>
                </div>

                <!-- LOẠI KHÁCH -->
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

                <!-- SỐ LƯỢNG -->
                <div class="mb-3">
                    <label class="form-label">Số lượng người</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="1" readonly required>
                </div>

                <!-- TÊN TOUR -->
                <div class="mb-3">
                    <label class="form-label">Tên tour</label>
                    <input type="text" class="form-control" name="tour_name" required>
                </div>

                <!-- NGÀY TOUR -->
                <div class="mb-3">
                    <label class="form-label">Ngày khởi hành</label>
                    <input type="date" class="form-control" name="tour_date" required>
                </div>

                <!-- YÊU CẦU ĐẶC BIỆT -->
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
        if (individualRadio.checked) {
            quantityInput.value = 1;
            quantityInput.readOnly = true;
        }
    });

    groupRadio.addEventListener('change', () => {
        if (groupRadio.checked) {
            quantityInput.value = '';
            quantityInput.readOnly = false;
        }
    });
</script>

</body>
</html>
