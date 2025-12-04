<?php

require_once "./configs/auth.php";

/* Controllers */
require_once "controllers/HomeController.php";
require_once "controllers/AuthController.php";
require_once "controllers/UserController.php";
require_once "controllers/HdvController.php";
require_once "controllers/TourController.php";
require_once "controllers/SupplierController.php";
require_once "controllers/CategoryController.php";
// require_once "controllers/TourOperationController.php";

/* Instance controller cho phần Operation */
// $operation = new TourOperationController();

/* Action hiện tại */
$action = $_GET['action'] ?? 'login';

/* Nếu không phải login → bắt buộc đăng nhập */
if (!in_array($action, ['login', 'doLogin'])) {
    requireLogin();
}

/* ===========================
    ROUTER CHÍNH
=========================== */

switch ($action) {

    /* ====== AUTH ====== */
    case "login": 
        (new AuthController())->showLogin(); 
        break;

    case "doLogin": 
        (new AuthController())->login(); 
        break;

    case "logout": 
        (new AuthController())->logout(); 
        break;

    /* ====== HOME ====== */
    case "/": 
        (new HomeController())->index(); 
        break;

    /* ====== HDV ====== */
    case "hdvIndex": (new HdvController())->index(); break;
    case "hdvAdd": (new HdvController())->create(); break;
    case "hdvStore": (new HdvController())->store(); break;
    case "hdvEdit": (new HdvController())->edit(); break;
    case "hdvUpdate": (new HdvController())->update(); break;
    case "hdvDelete": (new HdvController())->delete(); break;
    case "filler": (new HdvController())->filler(); break;

    /* ====== TOUR CRUD ====== */
    case "listTours": (new TourController())->index(); break;
    case "addTour": (new TourController())->add(); break;
    case "saveTour": (new TourController())->save(); break;
    case "editTour": (new TourController())->edit(); break;
    case "updateTour": (new TourController())->update(); break;
    case "deleteTour": (new TourController())->delete(); break;

    /* ====== CATEGORY CRUD ====== */

    case "tourCategory": // index.php?action=tourCategory (Hiển thị danh sách và form thêm mới)
        (new CategoryController())->index();
        break;

    case "CategoryStore": // index.php?action=CategoryStore (Xử lý POST Thêm mới)
        (new CategoryController())->store();
        break;
        
    case "editCategory": // index.php?action=CategoryEdit&id=X (Hiển thị Form Sửa)
        (new CategoryController())->edit();
        break;
        
    case "CategoryUpdate": // index.php?action=CategoryUpdate (Xử lý POST Sửa)
        (new CategoryController())->update();
        break;
        
    case "deleteCategory": // index.php?action=CategoryDelete&id=X (Xóa)
        (new CategoryController())->delete();
        break;
    case "filterTours": // index.php?action=filterTours&category_id=X
    (new TourController())->filterTours();
    break;
    
 


    /* ====== TOUR – ITINERARY ====== */
    case "viewItinerary": (new TourController())->viewItinerary(); break;
    case "addItinerary": (new TourController())->addItinerary(); break;
    case "saveItinerary": (new TourController())->saveItinerary(); break;
    case "editItinerary": (new TourController())->editItinerary(); break;
    case "updateItinerary": (new TourController())->updateItinerary(); break;
    case "deleteItinerary": (new TourController())->deleteItinerary(); break;

    /* ====== SUPPLIER ====== */
    case "supplierIndex": (new SupplierController())->index(); break;
    case "supplierAdd": (new SupplierController())->add(); break;
    case "supplierStore": (new SupplierController())->store(); break;
    case "supplierEdit": (new SupplierController())->edit(); break;
    case "supplierUpdate": (new SupplierController())->update(); break;
    case "supplierDelete": (new SupplierController())->delete(); break;

    /* ====== USER ====== */
    case "userIndex": (new UserController())->index(); break;
    case "userCreate": (new UserController())->create(); break;
    case "userStore": (new UserController())->store(); break;
    case "userEdit": (new UserController())->edit(); break;
    case "userUpdate": (new UserController())->update(); break;
    case "userDelete": (new UserController())->delete(); break;

    /* ======================================
        TOUR OPERATION – LỊCH KHỞI HÀNH
    ======================================= */
    case "listSchedules":
        $operation->listSchedules();
        break;

    case "createFullSchedule":
        $operation->createFullScheduleForm();
        break;

    case "storeFullSchedule":
        $operation->storeFullSchedule();
        break;

    case "deleteSchedule":
        $operation->deleteSchedule();
        break;



        //booking
case "bookingIndex":
    require_once "controllers/BookingController.php";
    (new BookingController())->index();
    break;

case "bookingCreate":
    require_once "controllers/BookingController.php";
    (new BookingController())->create();
    break;

case "bookingHistory":
    require_once "controllers/BookingController.php";
    (new BookingController())->history();
    break;
case "bookingUpdateStatus":
    require_once "controllers/BookingController.php";
    (new BookingController())->updateStatus();
    break;
case "bookingStore":
    require_once "controllers/BookingController.php";
    (new BookingController())->store();
    break;

     /* ---------- ALBUM TOUR ---------- */
    case 'viewAlbum': // Hiển thị tất cả ảnh của tour
        require_once "controllers/TourController.php";
        (new TourController)->viewAlbum();
        break;
    
        
    case 'addPhoto':
    case 'addPhotoForm': // Form thêm ảnh mới
        require_once "controllers/TourController.php";
        (new TourController)->addPhotoForm();
        break;
   
        
    case 'savePhoto': // Xử lý lưu ảnh mới (POST)
        require_once "controllers/TourController.php";
        (new TourController)->savePhoto();
        break;
        
    case 'deletePhoto': // Xóa ảnh
        require_once "controllers/TourController.php";
        (new TourController)->deletePhoto();
        break;  
    /* ====== ROUTE DEFAULT ====== */

    default:
        echo " Không tìm thấy route!";
        break;
}