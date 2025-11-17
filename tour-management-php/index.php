<?php
require_once __DIR__ . '/app/config/database.php';

require_once __DIR__ . '/app/controllers/TourController.php';
$action = $_GET['action'] ?? 'home';
$controller = null;

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
    require_once __DIR__ . '/app/controllers/HdvController.php';
    $controller = new HdvController();

    switch($action) {
        case 'hdvIndex':      
            $controller->index();
            break;
        case 'hdvCreate':     
            $controller->create();
            break;
        case 'hdvStore':     
            $controller->store();
            break;
        case 'hdvEdit':        
            $controller->edit();
            break;
        case 'hdvUpdate':     
            $controller->update();
            break;
        case 'hdvDelete':     
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
