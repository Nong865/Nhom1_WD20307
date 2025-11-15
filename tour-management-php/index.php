<?php
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
    
    case 'viewAlbum':
        $controller->viewAlbum(); 
    case 'editTour': 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->editTour();
        } else {
            $controller->showEditForm(); 
        }
        break;
        
    case 'deleteTour':
        $controller->deleteTour();
        break;
        
    default:
        echo "<p><a href='index.php?action=listTours'>Xem danh sách tour</a></p>";
        break;
}
?>