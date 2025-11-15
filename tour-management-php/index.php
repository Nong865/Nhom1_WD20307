<?php
// Simple router for PHP MVC demo
require_once __DIR__ . '/app/config/database.php';

// Tour controller
require_once __DIR__ . '/app/controllers/TourController.php';
$action = $_GET['action'] ?? 'home';
$controller = null;

// Nếu URL là tour
$tourActions = ['listTours','addTourForm','addTour'];
if (in_array($action, $tourActions)) {
    $controller = new TourController();
    switch($action) {
        case 'listTours':
            $controller->listTours();
            break;
        case 'addTourForm':
            $controller->showAddForm();
            break;
        case 'addTour':
            $controller->addTour();
            break;
    }
} else {
    // HDV (nhân viên) controller
    require_once __DIR__ . '/app/controllers/HdvController.php';
    $controller = new HdvController();

    switch($action) {
        case 'hdvIndex':       // danh sách HDV
            $controller->index();
            break;
        case 'hdvCreate':      // form thêm HDV
            $controller->create();
            break;
        case 'hdvStore':       // xử lý thêm
            $controller->store();
            break;
        case 'hdvEdit':        // form sửa
            $controller->edit();
            break;
        case 'hdvUpdate':      // xử lý sửa
            $controller->update();
            break;
        case 'hdvDelete':      // xóa HDV
            $controller->delete();
            break;
        default:
            echo "<h2>Welcome to Tour & HDV Management</h2>";
            echo "<p><a href='index.php?action=listTours'>Xem danh sách tour</a></p>";
            echo "<p><a href='index.php?action=hdvIndex'>Xem danh sách HDV</a></p>";
            break;
    }

}
?>
