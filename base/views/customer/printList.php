<h2>Danh sách đoàn – Tour <?= $tour['name'] ?></h2>

<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <tr>
        <th>#</th>
        <th>Họ tên</th>
        <th>Giới tính</th>
        <th>Năm sinh</th>
        <th>SĐT</th>
        <th>Ghi chú đặc biệt</th>
    </tr>

    <?php $i=1; foreach($customers as $c): ?>
    <tr>
        <td><?= $i++ ?></td>
        <td><?= $c['name'] ?></td>
        <td><?= $c['gender'] ?></td>
        <td><?= $c['birth_year'] ?></td>
        <td><?= $c['phone'] ?></td>
        <td><?= $c['special_note'] ?></td>
        

    </tr>
    <?php endforeach; ?>
</table>

<script>window.print();</script>
