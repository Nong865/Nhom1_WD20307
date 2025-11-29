<?php 

// Bật lỗi (debug) – nếu không muốn thì xóa 3 dòng dưới
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

spl_autoload_register(function ($class) {    
    $fileName = "$class.php";

    $fileModel      = PATH_MODEL . $fileName;
    $fileController = PATH_CONTROLLER . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } 
    else if (is_readable($fileController)) {
        require_once $fileController;
    }
});

require_once './configs/env.php';
require_once './configs/helper.php';

// Điều hướng toàn hệ thống
require_once './routes/index.php';
