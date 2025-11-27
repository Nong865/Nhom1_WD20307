<?php

require_once "controllers/HomeController.php";
require_once "controllers/BookingController.php";

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
/* ---------- BOOKING ---------- */
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
    

    /* ---------- ROUTE MẶC ĐỊNH ---------- */
    default:
        echo "Không tìm thấy route!";
        break;
}
