<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../config/database.php';

class TourController {
    private $db;
    private $tourModel;

    public function __construct() {
        global $conn;
        $this->db = $conn;
        $this->tourModel = new Tour($this->db);
    }

    public function listTours() {
        $tours = $this->tourModel->getAll();
        include __DIR__ . '/../views/admin/tours.php';
    }

    public function showAddForm() {
        include __DIR__ . '/../views/admin/addTour.php';
    }

    public function addTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tourModel->name = $_POST['name'] ?? '';
            $this->tourModel->price = $_POST['price'] ?? 0;
            $this->tourModel->description = $_POST['description'] ?? '';
            $this->tourModel->start_date = $_POST['start_date'] ?? null;
            $this->tourModel->end_date = $_POST['end_date'] ?? null;
            $ok = $this->tourModel->create();
            if ($ok) {
                header('Location: index.php?action=listTours');
                exit;
            } else {
                echo "<p>Không thể thêm tour. Vui lòng thử lại.</p>";
            }
        }
    }
}
?>