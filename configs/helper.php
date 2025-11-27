<?php

if (!function_exists('debug')) {
    function debug($data) {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file) {
        $targetFile = $folder . '/' . time() . '-' . $file["name"];

        if (move_uploaded_file($file["tmp_name"], PATH_ASSETS_UPLOADS . $targetFile)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công!');
    }
}
if (!function_exists('render')) {
    function render($viewPath, $data = [])
    {
        extract($data);
        ob_start();
        $file = dirname(__DIR__) . "/views/$viewPath.php";
        if(file_exists($file)) {
            include $file;
        } else {
            throw new Exception("View file $file not found!");
        }
        return ob_get_clean();
    }
}

