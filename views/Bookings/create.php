<?php
// Lấy danh sách khách hàng từ database
// Code PHP này vẫn giữ nguyên, chỉ đảm bảo nó được include trước khi hiển thị HTML
require_once __DIR__ . '/../../models/BaseModel.php';
require_once __DIR__ . '/../../models/Customer.php';

$customerModel = new Customer();
$customers = $customerModel->all();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Booking mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <h1 class="mb-4 text-primary">Tạo Booking mới</h1>
                
                <form method="post" action="index.php?action=bookingStore">
                    
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Khách hàng:</label>
                        <select class="form-select" id="customer_id" name="customer_id" required>
                            <option value="">-- Chọn khách hàng --</option>
                            <?php foreach($customers as $c): ?>
                                <option value="<?= htmlspecialchars($c['id']) ?>">
                                    <?= htmlspecialchars($c['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tour_name" class="form-label">Tên tour:</label>
                        <input type="text" class="form-control" id="tour_name" name="tour_name" required>
                    </div>

                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Tạo Booking
                        </button>
                        <a href="index.php?action=bookingIndex" class="btn btn-outline-secondary">
                            Hủy
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script> 
</body>
</html>