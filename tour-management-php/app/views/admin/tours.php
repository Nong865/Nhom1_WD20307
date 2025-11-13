<?php include __DIR__ . '/../../../../public/html/header.php'; ?>
<div class="container">
    <h2>Danh sách Tour</h2>
    <p><a href="index.php?action=addTourForm">Thêm tour mới</a></p>
    <?php if (empty($tours)): ?>
        <p>Chưa có tour nào.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" style="border-collapse:collapse;">
            <thead><tr><th>ID</th><th>Tên tour</th><th>Giá</th><th>Thời gian</th><th>Mô tả</th></tr></thead>
            <tbody>
            <?php foreach($tours as $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($t['id']); ?></td>
                    <td><?php echo htmlspecialchars($t['name']); ?></td>
                    <td><?php echo number_format($t['price'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo htmlspecialchars($t['start_date']) . ' → ' . htmlspecialchars($t['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($t['description']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../../../../public/html/footer.php'; ?>