<?php
// Xử lý session cho phần kiểm tra quyền
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$currentUser = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "Quản lý tour du lịch" ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f6f8fc; }
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #1d2a57;
            color: #fff;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #d7d7d7;
            padding: 12px 20px;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: #102046;
            color: #fff;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .table thead { background: #eef1f7; }
    </style>
</head>

<body>

<div class="sidebar">
    <h5 class="text-center mb-4">QUẢN LÝ TOUR DU LỊCH</h5>
    <nav class="nav flex-column">

        <!-- QUẢN LÝ TOUR -->
        <a class="nav-link <?= ($active ?? '') == 'tour' ? 'active' : '' ?>" 
           href="index.php?action=listTours">Danh mục tour</a>

        <!-- NHÀ CUNG CẤP -->
        <a class="nav-link <?= ($active ?? '') == 'ncc' ? 'active' : '' ?>" 
           href="index.php?action=supplierIndex">Nhà cung cấp</a>

        <!-- HDV / NHÂN VIÊN -->
        <a class="nav-link <?= ($active ?? '') == 'hdv' ? 'active' : '' ?>" 
           href="index.php?action=hdvIndex">Nhân viên</a>

        <!-- CHỈ ADMIN (role_id = 1) MỚI ĐƯỢC QUẢN LÝ TÀI KHOẢN -->
        <?php if ($currentUser && $currentUser['role_id'] == 1): ?>
            <a class="nav-link <?= ($active ?? '') == 'user' ? 'active' : '' ?>" 
               href="index.php?action=userIndex">Tài khoản</a>
        <?php endif; ?>

        <!-- ĐĂNG XUẤT -->
        <a class="nav-link text-danger" href="index.php?action=logout">Đăng xuất</a>

    </nav>
</div>

<div class="content">
    <?php 
        if (isset($content)) {

            // Nếu $content là file path → require file
            if (is_string($content) && file_exists($content)) {
                require $content;
            }
            // Nếu là HTML đã render → echo
            else {
                echo $content;
            }

        } else {
            echo "<p>Không có nội dung để hiển thị</p>";
        }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
