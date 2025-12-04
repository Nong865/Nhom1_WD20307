<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=login");
        exit;
    }
}

function requireRole($roles = []) {
    requireLogin();

    $role = $_SESSION['user']['role_id'];

    if (!in_array($role, $roles)) {
        die("<h3 style='color:red'>Bạn không có quyền truy cập chức năng này!</h3>");
    }
}