<div class="container mt-4">
    <a href="index.php?action=listTours" class="btn btn-secondary mb-4">← Quay lại Danh sách Tour</a>
    
    <h3 class="mb-3">📅 Lịch trình Chi tiết Tour: **<?= $tour['name'] ?? 'Không tìm thấy Tour' ?>**</h3>
    
    <a href="index.php?action=addItinerary&tour_id=<?= $tour['id'] ?>" class="btn btn-success mb-3">
        + Thêm Lịch trình cho Tour này
    </a>

    <?php if (empty($itineraries)): ?>
        <div class="alert alert-warning" role="alert">
            Tour này hiện chưa có lịch trình chi tiết nào được thiết lập. Vui lòng thêm mục đầu tiên.
        </div>
    <?php else: ?>
        
        <div class="itinerary-list">
            <?php 
            // Vòng lặp qua danh sách lịch trình chi tiết đã được sắp xếp theo day_number
            foreach ($itineraries as $item): 
            ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5>Ngày <?= $item['day_number'] ?>: **<?= htmlspecialchars($item['title']) ?>**</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= nl2br(htmlspecialchars($item['details'])) ?></p>
                    
                    <hr>
                    <div class="actions">
                        <a href="index.php?action=editItinerary&id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a onclick="return confirm('Xóa lịch trình ngày này?')" 
                           href="index.php?action=deleteItinerary&id=<?= $item['id'] ?>&tour_id=<?= $tour['id'] ?>" 
                           class="btn btn-sm btn-danger">Xóa</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>