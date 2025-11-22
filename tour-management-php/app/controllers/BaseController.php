<?php

namespace App\Controllers;

class BaseController
{
    protected function views($path, $data = [])
    {
        // biến $data thành biến truy cập trong view
        extract($data);

        // chuyển "bookings/index" -> "app/views/bookings/index.php"
        $viewPath = __DIR__ . "/../views/" . $path . ".php";

        if (!file_exists($viewPath)) {
            die("View file not found: " . $viewPath);
        }

        // nạp view
        require $viewPath;
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    // nếu cần dùng thêm helpers chung
    protected function dd($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;
    }
}
