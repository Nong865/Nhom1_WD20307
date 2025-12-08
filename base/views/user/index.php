<h3>Danh sách tài khoản</h3>

<a href="index.php?action=userCreate" class="btn btn-primary mb-3">Thêm tài khoản</a>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Quyền</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= $u['username'] ?></td>
            <td><?= $u['full_name'] ?></td>
            <td><?= $u['email'] ?></td>
            <td><?= $u['role_name'] ?></td>
            <td>
                <a href="index.php?action=userEdit&id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="index.php?action=userDelete&id=<?= $u['id'] ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Xóa tài khoản này?');">
                   Xóa
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>