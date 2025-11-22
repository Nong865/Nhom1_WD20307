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
        <a class="nav-link <?= ($active ?? '') == 'tour' ? 'active' : '' ?>" 
           href="index.php?action=listTours">Danh Mục tour</a>

        <a class="nav-link <?= ($active ?? '') == 'ncc' ? 'active' : '' ?>" 
           href="index.php?action=supplierIndex">Nhà cung cấp</a>

        <a class="nav-link <?= ($active ?? '') == 'hdv' ? 'active' : '' ?>" 
           href="index.php?action=hdvIndex">Nhân Viên</a>
    </nav>
</div>

<div class="content">
    <?= $content ?? "" ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
