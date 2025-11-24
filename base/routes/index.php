<?php

require_once "./configs/auth.php";

require_once "controllers/HomeController.php";
require_once "controllers/AuthController.php";
require_once "controllers/UserController.php";
require_once "controllers/HdvController.php";
require_once "controllers/TourController.php";
require_once "controllers/SupplierController.php";

$action = $_GET['action'] ?? 'login';

// 🔥 Nếu không phải login → bắt buộc đã đăng nhập
if (!in_array($action, ['login', 'doLogin'])) {
    requireLogin();
}

switch ($action) {

    case "login": 
        (new AuthController())->showLogin(); 
        break;

    case "doLogin": 
        (new AuthController())->login(); 
        break;

    case "logout": 
        (new AuthController())->logout(); 
        break;

    case '/':
        (new HomeController())->index();
        break;

    case "hdvIndex": (new HdvController())->index(); break;
    case "hdvAdd": (new HdvController())->create(); break;
    case "hdvStore": (new HdvController())->store(); break;
    case "hdvEdit": (new HdvController())->edit(); break;
    case "hdvUpdate": (new HdvController())->update(); break;
    case "hdvDelete": (new HdvController())->delete(); break;

    case "listTours": (new TourController())->index(); break;
    case "addTour": (new TourController())->add(); break;
    case "saveTour": (new TourController())->save(); break;
    case "editTour": (new TourController())->edit(); break;
    case "updateTour": (new TourController())->update(); break;
    case "deleteTour": (new TourController())->delete(); break;

    case "supplierIndex": (new SupplierController())->index(); break;
    case "supplierAdd": (new SupplierController())->add(); break;
    case "supplierStore": (new SupplierController())->store(); break;
    case "supplierEdit": (new SupplierController())->edit(); break;
    case "supplierUpdate": (new SupplierController())->update(); break;
    case "supplierDelete": (new SupplierController())->delete(); break;

    case "userIndex": (new UserController())->index(); break;
    case "userCreate": (new UserController())->create(); break;
    case "userStore": (new UserController())->store(); break;
    case "userEdit": (new UserController())->edit(); break;
    case "userUpdate": (new UserController())->update(); break;
    case "userDelete": (new UserController())->delete(); break;

    default:
        echo "Không tìm thấy route!";
        break;
}
