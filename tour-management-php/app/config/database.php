<?php

// Định nghĩa các biến kết nối
$DB_HOST = '127.0.0.1';
$DB_NAME = 'duan1'; // Đảm bảo tên database này đúng
$DB_USER = 'root'; // Tên người dùng database của bạn
$DB_PASS = ''; // Mật khẩu của bạn (thường là rỗng trên Laragon/XAMPP)

// Khởi tạo biến kết nối $conn. Bắt đầu bằng null để phòng vệ.
$conn = null; 

try {
    // 1. Tạo đối tượng PDO và gán vào biến $conn
    $conn = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS);
    
    // 2. Thiết lập chế độ báo lỗi để PDO ném ra exception khi có lỗi SQL
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // 3. Nếu kết nối thất bại, in ra lỗi và dừng chương trình
    die("<h3>Database connection failed:</h3>" . $e->getMessage());
}