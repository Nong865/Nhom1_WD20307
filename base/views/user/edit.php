<h3>Sửa tài khoản</h3>

<form method="POST" action="index.php?action=userUpdate" style="max-width:500px">

    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <label>Username</label>
    <input class="form-control mb-2" name="username" value="<?= $user['username'] ?>" required>

    <label>Họ tên</label>
    <input class="form-control mb-2" name="full_name" value="<?= $user['full_name'] ?>" required>

    <label>Email</label>
    <input class="form-control mb-2" name="email" value="<?= $user['email'] ?>" required>

    <label>Quyền</label>
    <select name="role_id" class="form-control mb-3">
        <option value="1" <?= $user['role_id']==1?'selected':'' ?>>Admin</option>
        <option value="2" <?= $user['role_id']==2?'selected':'' ?>>Hướng dẫn viên</option>
    </select>

    <button class="btn btn-primary">Cập nhật</button>
</form>
