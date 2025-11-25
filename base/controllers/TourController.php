<?php

require_once dirname(__DIR__) . '/configs/helper.php';
require_once dirname(__DIR__) . '/models/TourModel.php';

class TourController {

    private $tourModel;

    public function __construct() {
        $this->tourModel = new TourModel();
    }

    // =======================================================
    // HIỂN THỊ DANH SÁCH TOUR + TÍNH LỊCH TRÌNH (SỐ NGÀY)
    // =======================================================
    public function index() {
        $tours = $this->tourModel->getAll();
        $active = 'tour';

        // Tính số ngày tour
        foreach ($tours as $key => $tour) {
            if (!empty($tour['start_date']) && !empty($tour['end_date'])) {
                try {
                    $start = new DateTime($tour['start_date']);
                    $end = new DateTime($tour['end_date']);
                    $interval = $start->diff($end);
                    $so_ngay = $interval->days + 1;

                    $tours[$key]['lich_trinh'] = $so_ngay . ' ngày';
                } catch (Exception $e) {
                    $tours[$key]['lich_trinh'] = 'Lỗi ngày tháng';
                }
            } else {
                $tours[$key]['lich_trinh'] = 'Chưa xác định';
            }
        }

        $content = render("tours/list", [
            'tours' => $tours,
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    // =======================================================
    // FORM THÊM TOUR
    // =======================================================
    public function add() {
        requireRole([1, 4]);

        $active = 'tour';
        $content = render("tours/add");

        include dirname(__DIR__) . "/views/main.php";
    }

    // =======================================================
    // FORM SỬA TOUR
    // =======================================================
    public function edit() {
        requireRole([1, 4]);

        $id = $_GET['id'];
        $tour = $this->tourModel->find($id);

        $content = render("tours/edit", [
            'tour' => $tour,
            'active' => 'tour'
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    // =======================================================
    // LƯU TOUR MỚI
    // =======================================================
    public function save() {
        requireRole([1, 4]);

        $img = null;

        if (!empty($_FILES['main_image']['name'])) {
            $name = "tour_img_" . uniqid() . ".jpg";
            $path = "assets/uploads/" . $name;
            move_uploaded_file($_FILES['main_image']['tmp_name'], $path);
            $img = $path;
        }

        $data = [
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            "start_date" => $_POST['start_date'],
            "end_date" => $_POST['end_date'],
            "main_image" => $img
        ];

        $this->tourModel->insert($data);

        header("Location: index.php?action=listTours");
    }

    // =======================================================
    // CẬP NHẬT TOUR
    // =======================================================
    public function update() {
        requireRole([1, 4]);

        $id = $_POST['id'];
        $img = $_POST['old_image'];

        if (!empty($_FILES['main_image']['name'])) {
            $name = "tour_img_" . uniqid() . ".jpg";
            $path = "assets/uploads/" . $name;
            move_uploaded_file($_FILES['main_image']['tmp_name'], $path);
            $img = $path;
        }

        $data = [
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            "start_date" => $_POST['start_date'],
            "end_date" => $_POST['end_date'],
            "main_image" => $img
        ];

        $this->tourModel->updateTour($id, $data);

        header("Location: index.php?action=listTours");
    }

    // =======================================================
    // XÓA TOUR
    // =======================================================
    public function delete() {
        requireRole([1, 4]);

        $id = $_GET['id'];
        $this->tourModel->delete($id);

        header("Location: index.php?action=listTours");
    }

    // =======================================================
    // LỊCH TRÌNH TOUR (ITINERARY)
    // =======================================================

    public function viewItinerary() {
        $tour_id = $_GET['id'];
        $tour = $this->tourModel->find($tour_id);
        $itineraries = $this->tourModel->getItineraryByTourId($tour_id);

        $content = render("tours/itineraries/itinerary_detail", [
            'tour' => $tour,
            'itineraries' => $itineraries
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function addItinerary() {
        $tour_id = $_GET['tour_id'];
        $tour = $this->tourModel->find($tour_id);

        $content = render("tours/itineraries/add", [
            'tour' => $tour,
            'active' => 'tour'
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function saveItinerary() {
        $tour_id = $_POST['tour_id'];

        $data = [
            "tour_id" => $tour_id,
            "day_number" => $_POST['day_number'],
            "title" => $_POST['title'],
            "details" => $_POST['details']
        ];

        $this->tourModel->insertItinerary($data);

        header("Location: index.php?action=viewItinerary&id=" . $tour_id);
    }

    public function editItinerary() {
        $id = $_GET['id'];
        $item = $this->tourModel->findItinerary($id);
        $tour = $this->tourModel->find($item['tour_id']);

        $content = render("tours/itineraries/edit", [
            'item' => $item,
            'tour' => $tour,
            'active' => 'tour'
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function updateItinerary() {
        $id = $_POST['id'];
        $tour_id = $_POST['tour_id'];

        $data = [
            "day_number" => $_POST['day_number'],
            "title" => $_POST['title'],
            "details" => $_POST['details']
        ];

        $this->tourModel->updateItinerary($id, $data);

        header("Location: index.php?action=viewItinerary&id=" . $tour_id);
    }

    public function deleteItinerary() {
        $id = $_GET['id'];
        $tour_id = $_GET['tour_id'];

        $this->tourModel->deleteItinerary($id);

        header("Location: index.php?action=viewItinerary&id=" . $tour_id);
    }
}
