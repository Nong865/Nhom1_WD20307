<?php
function connectDB() {
    $DB_HOST = '127.0.0.1';
    $DB_NAME = 'duan1';
    $DB_USER = 'root';
    $DB_PASS = '';

    try {
        $conn = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("<h3>Database connection failed:</h3>" . $e->getMessage());
    }
}
?>
