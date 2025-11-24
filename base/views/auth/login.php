<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #1d2a57, #4e73df);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-box {
            width: 360px;
            background: rgba(255, 255, 255, 0.95);
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
            animation: fadeIn .4s ease-in-out;
        }

        .login-box h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
            color: #1d2a57;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
        }

        .btn-login {
            height: 45px;
            background: #1d2a57;
            border: none;
            color: #fff;
            font-size: 17px;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-login:hover {
            background: #152040;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

</head>
<body>

<div class="login-box">
    <h3>Đăng nhập hệ thống</h3>

    <form method="POST" action="index.php?action=doLogin">
        <input class="form-control mb-3" name="username" placeholder="Tên đăng nhập" required>
        <input class="form-control mb-3" name="password" placeholder="Mật khẩu" type="password" required>

        <button class="btn-login w-100">Đăng nhập</button>
    </form>
</div>

</body>
</html>
