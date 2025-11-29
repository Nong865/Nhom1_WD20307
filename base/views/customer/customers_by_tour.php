<div class="d-flex justify-content-between mb-3">
    <h3>Danh sách đoàn</h3>

    <div>
        <a href="index.php?action=customerAddForm&tour_id=<?= $_GET['tour_id'] ?>" 
           class="btn btn-primary">
           + Thêm khách
        </a>

        <a href="index.php?action=printCustomerList&tour_id=<?= $_GET['tour_id'] ?>" 
           class="btn btn-success">
           In danh sách
        </a>
    </div>
</div>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Năm sinh</th>
            <th>Điện thoại</th>
            <th>Giấy tờ</th>
            <th>Thanh toán</th>
            <th>Check-in</th>
            <th>Phòng</th>
            <th>Yêu cầu đặc biệt</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($customers as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['name'] ?></td>
            <td><?= $c['gender'] ?></td>
            <td><?= $c['birth_year'] ?></td>
            <td><?= $c['phone'] ?></td>
            <td><?= $c['passport'] ?></td>

            <td>
                <?= $c['payment_status']=='paid'
                    ? '<span class="text-success fw-bold">Đã thanh toán</span>'
                    : '<span class="text-danger fw-bold">Chưa</span>' ?>
            </td>

            <!-- Check-in -->
            <td>
                <form method="POST" action="index.php?action=checkin">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <input type="hidden" name="tour_id" value="<?= $_GET['tour_id'] ?>">

                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="not_arrived" <?= $c['checkin_status']=='not_arrived'?'selected':'' ?>>Chưa đến</option>
                        <option value="arrived" <?= $c['checkin_status']=='arrived'?'selected':'' ?>>Đã đến</option>
                        <option value="absent" <?= $c['checkin_status']=='absent'?'selected':'' ?>>Vắng</option>
                    </select>
                </form>
            </td>

            <!-- Phòng -->
            <td>
                <form method="POST" action="index.php?action=assignRoom">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <input type="hidden" name="tour_id" value="<?= $_GET['tour_id'] ?>">

                    <input type="number" 
                           name="room_id" 
                           value="<?= $c['room_id'] ?>" 
                           class="form-control form-control-sm"
                           style="width:80px;">
                </form>
            </td>

            <td><?= $c['special_note'] ?></td>

            <td>
    <a href="index.php?action=customerEditForm&id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>

    <a onclick="return confirm('Xóa khách này?')" 
       href="index.php?action=customerDelete&id=<?= $c['id'] ?>&tour_id=<?= $tour_id ?>"
       class="btn btn-sm btn-danger">Xóa</a>
</td>   
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
