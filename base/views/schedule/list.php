<h3 class="mb-3">Lịch khởi hành</h3>

<a href="index.php?action=scheduleAdd" class="btn btn-primary mb-3">+ Tạo lịch mới</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tour</th>
            <th>Thời gian</th>
            <th>Điểm tập trung</th>
            <th>Nhân sự</th>
            <th>Dịch vụ</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($schedules as $s): ?>
        <tr>
            <!-- TÊN TOUR -->
            <td><?= $s['tour_name'] ?></td>

            <!-- THỜI GIAN -->
            <td><?= $s['start_datetime'] ?> → <?= $s['end_datetime'] ?></td>

            <!-- ĐIỂM TẬP TRUNG -->
            <td><?= $s['meeting_point'] ?></td>

            <!-- NHÂN SỰ -->
            <td style="width: 220px;">
                <?php if (!empty($s['staff'])): ?>
                    <?php foreach ($s['staff'] as $st): ?>
                        <div>
                            • <strong><?= $st['name'] ?></strong> 
                              <span class="text-muted">(<?= $st['role'] ?>)</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted">Chưa phân công</span>
                <?php endif; ?>
            </td>

            <!-- DỊCH VỤ -->
            <td style="width: 220px;">
                <?php if (!empty($s['services'])): ?>
                    <?php foreach ($s['services'] as $sv): ?>
                        <div>
                            •• <strong><?= $sv['partner_name'] ?></strong> 
                                <span>(<?= $sv['service_type'] ?>)</span>
                                – SL: <?= $sv['quantity'] ?>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted">Chưa phân bổ</span>
                <?php endif; ?>
            </td>

            <!-- HÀNH ĐỘNG -->
            <td style="width: 120px;">
                <a href="index.php?action=assignStaff&id=<?= $s['id'] ?>" 
                   class="btn btn-warning btn-sm mb-1">
                    Nhân sự
                </a>
                <a href="index.php?action=assignService&id=<?= $s['id'] ?>" 
                   class="btn btn-info btn-sm">
                    Dịch vụ
                </a>
            </td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
