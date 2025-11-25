<?php

require_once "controllers/HomeController.php";

$action = $_GET['action'] ?? '/';

switch ($action) {

    /* ---------- TRANG CHỦ ---------- */
    case '/':
        (new HomeController())->index();
        break;

    /* ---------- HDV (HƯỚNG DẪN VIÊN) ---------- */
    case "hdvIndex":
        require_once "controllers/HdvController.php";
        (new HdvController)->index();
        break;

    case "hdvAdd":
        require_once "controllers/HdvController.php";
        (new HdvController)->create();
        break;

    case "hdvStore":
        require_once "controllers/HdvController.php";
        (new HdvController)->store();
        break;

    case "hdvEdit":
        require_once "controllers/HdvController.php";
        (new HdvController)->edit();
        break;

    case "hdvUpdate":
        require_once "controllers/HdvController.php";
        (new HdvController)->update();
        break;

    case "hdvDelete":
        require_once "controllers/HdvController.php";
        (new HdvController)->delete();
        break;

    case "filler":
        require_once "controllers/HdvController.php";
        (new HdvController)->filler();
        break;

    /* ---------- TOUR ---------- */
    case 'listTours':
        require_once "controllers/TourController.php";
        (new TourController)->index();
        break;

    case 'addTour':
        require_once "controllers/TourController.php";
        (new TourController)->add();
        break;

    case 'saveTour':
        require_once "controllers/TourController.php";
        (new TourController)->save();
        break;

    case 'editTour':
        require_once "controllers/TourController.php";
        (new TourController)->edit();
        break;

    case 'updateTour':
        require_once "controllers/TourController.php";
        (new TourController)->update();
        break;

    case 'deleteTour':
        require_once "controllers/TourController.php";
        (new TourController)->delete();
        break;

    // --------------------------------------------------------
    // ** ROUTE QUẢN LÝ LỊCH TRÌNH CHI TIẾT ** (MỚI)
    // --------------------------------------------------------
    
    case 'viewItinerary':
        require_once "controllers/TourController.php";
        (new TourController)->viewItinerary();
        break;
        
    case 'addItinerary':
        require_once "controllers/TourController.php";
        (new TourController)->addItinerary();
        break;
        
    case 'saveItinerary':
        require_once "controllers/TourController.php";
        (new TourController)->saveItinerary();
        break;
        
    case 'editItinerary':
        require_once "controllers/TourController.php";
        (new TourController)->editItinerary();
        break;
        
    case 'updateItinerary':
        require_once "controllers/TourController.php";
        (new TourController)->updateItinerary();
        break;
        
    case 'deleteItinerary':
        require_once "controllers/TourController.php";
        (new TourController)->deleteItinerary();
        break;

    /* ---------- SUPPLIERS ---------- */
    case "supplierIndex":
        require_once "controllers/SupplierController.php";
        (new SupplierController())->index();
        break;

    case "supplierAdd":
        require_once "controllers/SupplierController.php";
        (new SupplierController())->add();
        break;

    case "supplierStore":
        require_once "controllers/SupplierController.php";
        (new SupplierController())->store();
        break;

    case "supplierEdit":
        require_once "controllers/SupplierController.php";
        (new SupplierController())->edit();
        break;

    case "supplierUpdate":
        require_once "controllers/SupplierController.php";
        (new SupplierController())->update();
        break;

    case "supplierDelete":
        require_once "controllers/SupplierController.php";
        (new SupplierController())->delete();
        break;


    /* ---------- ALBUM TOUR ---------- */
    case 'viewAlbum': // Hiển thị tất cả ảnh của tour
        require_once "controllers/TourController.php";
        (new TourController)->viewAlbum();
        break;
        
    case 'addPhoto': // Form thêm ảnh mới
        require_once "controllers/TourController.php";
        (new TourController)->addPhoto();
        break;
        
    case 'savePhoto': // Xử lý lưu ảnh mới (POST)
        require_once "controllers/TourController.php";
        (new TourController)->savePhoto();
        break;
        
    case 'deletePhoto': // Xóa ảnh
        require_once "controllers/TourController.php";
        (new TourController)->deletePhoto();
        break;

    /* ---------- ROUTE MẶC ĐỊNH ---------- */
    default:
        echo "Không tìm thấy route!";
        break;
}