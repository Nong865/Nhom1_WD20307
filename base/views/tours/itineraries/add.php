<div class="container mt-4">
    <h3 class="mb-3">➕ Thêm Lịch trình Chi tiết cho Tour: <b><?= $tour['name'] ?? 'ID Tour không hợp lệ' ?></b></h3>
    
    <?php if (isset($total_days) && $total_days > 0): ?>
        <div class="alert alert-info">
            Tour này kéo dài **<?= $total_days ?> ngày**. Hãy bắt đầu thêm mục lịch trình (Ngày 1, 2, ...).
        </div>
    <?php endif; ?>

    <a href="index.php?action=viewItinerary&id=<?= $tour['id'] ?>" class="btn btn-secondary mb-4">
        ← Quay lại Chi tiết Lịch trình
    </a>

    <form action="index.php?action=saveItinerary" method="POST" class="bg-white p-4 shadow rounded">
        
        <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">

        <div class="form-group mb-3">
            <label for="day_number">Ngày thứ mấy trong Tour (*):</label>
            <input type="number" name="day_number" id="day_number" class="form-control" required min="1" 
                   placeholder="Ví dụ: 1, 2, 3...">
        </div>

        <div class="form-group mb-3">
            <label for="title">Tiêu đề (Địa điểm/Hoạt động chính) (*):</label>
            <input type="text" name="title" id="title" class="form-control" required 
                   placeholder="Ví dụ: Tham quan Vịnh Hạ Long, Chèo thuyền Kayak">
        </div>

        <div class="form-group mb-4">
            <label for="details">Mô tả Chi tiết Lịch trình:</label>
            <textarea name="details" id="details" rows="6" class="form-control" 
                      placeholder="Mô tả chi tiết các hoạt động, thời gian và bữa ăn trong ngày..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Lưu Mục Lịch trình</button>
    </form>
</div>