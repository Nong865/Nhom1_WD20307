<div class="container mt-4">
    
    <h3 class="mb-3"> Chỉnh sửa Lịch trình Chi tiết cho Tour: <b><?= $tour['name'] ?? 'Tour không xác định' ?></b></h3>
    
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <a href="index.php?action=viewItinerary&id=<?= $item['tour_id'] ?? $tour['id'] ?>" class="btn btn-secondary mb-4">
        Quay lại Chi tiết Lịch trình
    </a>

    <form action="index.php?action=updateItinerary" method="POST" class="bg-white p-4 shadow rounded">
        
        <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">

        <input type="hidden" name="tour_id" value="<?= $item['tour_id'] ?? '' ?>">

        <div class="form-group mb-3">
            <label for="day_number">Ngày thứ mấy trong Tour:</label>
            <input type="number" name="day_number" id="day_number" class="form-control" 
                   required min="1" 
                   value="<?= htmlspecialchars($item['day_number'] ?? '') ?>"
                   placeholder="Ví dụ: 1, 2, 3...">
        </div>

        <div class="form-group mb-3">
            <label for="title">Tiêu đề (Địa điểm/Hoạt động chính):</label>
            <input type="text" name="title" id="title" class="form-control" 
                   required 
                   value="<?= htmlspecialchars($item['title'] ?? '') ?>"
                   placeholder="Ví dụ: Tham quan Vịnh Hạ Long, Chèo thuyền Kayak">
        </div>

        <div class="form-group mb-4">
            <label for="details">Mô tả Chi tiết Lịch trình:</label>
            <textarea name="details" id="details" rows="6" class="form-control" 
                      placeholder="Mô tả chi tiết các hoạt động, thời gian và bữa ăn trong ngày..."><?= htmlspecialchars($item['details'] ?? '') ?></textarea>
            </div>

        <button type="submit" class="btn btn-primary">Lưu Thay Đổi Lịch trình</button>
    </form>
</div>