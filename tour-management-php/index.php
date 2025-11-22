<?php
// Dòng 2: Tải file cấu hình database. File này chứa các biến $DB_HOST, $DB_USER, v.v.
require_once __DIR__ . '/app/config/database.php';

// ===========================================
// Code tạo kết nối PDO (ĐÃ SỬA LỖI)
// ===========================================
try {
    // Dòng 7: Sử dụng biến (chú ý $), các biến này đã được định nghĩa trong database.php
    $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";
    
    // Dòng 8: SỬA LỖI: Dùng $DB_USER và $DB_PASS (biến) thay vì hằng số
    $db = new PDO($dsn, $DB_USER, $DB_PASS);
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}
// ===========================================


require_once __DIR__ . '/app/controllers/TourController.php';

$action = $_GET['action'] ?? 'home';
$controller = null;

$tourActions = ['listTours','addTourForm','addTour','viewAlbum', 'addPhotoForm', 'addPhoto'];

if (in_array($action, $tourActions)) {
    // Nếu TourController cần kết nối, bạn cũng nên truyền $db vào đây:
    // $controller = new TourController($db); 
    $controller = new TourController($db); 
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
        case 'viewAlbum' :
            $controller->viewAlbum();
            break;
        case 'addPhotoForm': 
            $controller->addPhotoForm();
            break;
        case 'addPhoto': 
            $controller->addPhoto();
            break;
    }
} else {
    require_once __DIR__ . '/app/controllers/HdvController.php';
    
    // Đã sửa lỗi: Biến $db đã được định nghĩa và truyền vào Controller
    $controller = new HdvController($db); 


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
            echo "<p><a href='/tour-managenment-php/public/html/index.php/'>Xem danh sách HDV</a></p>";
            break;
    }}
?>
