<?php
// Simple router for PHP MVC demo
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/controllers/TourController.php';

$action = $_GET['action'] ?? 'home';
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
    default:
        // echo "<h2>Welcome to Tour Management (PHP MVC demo)</h2>";
        echo "<p><a href='index.php?action=listTours'>Xem danh sách tour</a></p>";
        break;
}
?>