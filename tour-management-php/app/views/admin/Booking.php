<h2>Danh sách Booking</h2>
<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tour</th>
        <th>Người đặt</th>
        <th>Số ghế</th>
        <th>Tổng</th>
        <th>Trạng thái</th>
    </tr>
    <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?php echo $b['id']; ?></td>
            <td><?php echo htmlspecialchars($b['title']); ?></td>
            <td><?php echo htmlspecialchars($b['name']); ?></td>
            <td><?php echo $b['seats_booked']; ?></td>
            <td><?php echo number_format($b['total_price'], 0, ',', '.'); ?></td>
            <td><?php echo $b['status']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>