<h3>Thêm tài khoản</h3>

<form method="POST" action="index.php?action=userStore" style="max-width:500px">

    <label>Username</label>
    <input class="form-control mb-2" name="username" required>

    <label>Họ tên</label>
    <input class="form-control mb-2" name="full_name" required>

    <label>Email</label>
    <input class="form-control mb-2" name="email" required>

    <label>Mật khẩu</label>
    <input class="form-control mb-2" name="password" type="password" required>

    <label>Quyền</label>
    <select name="role_id" class="form-control mb-3">
        <option value="1">Admin</option>
        <option value="2">Hướng dẫn viên</option>
    </select>

    <button class="btn btn-primary">Lưu</button>
</form>
