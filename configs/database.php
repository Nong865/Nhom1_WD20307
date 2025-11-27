<?php
require_once __DIR__ . '/env.php'; 

try {
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USERNAME,
        DB_PASSWORD,
        DB_OPTIONS
    );
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
