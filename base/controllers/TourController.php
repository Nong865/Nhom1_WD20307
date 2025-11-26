<?php

require_once dirname(__DIR__) . '/configs/helper.php';
require_once dirname(__DIR__) . '/models/TourModel.php';

class TourController {

    private $tour;

    public function __construct() {
        $this->tour = new TourModel();
    }

    /* ==========================================================
        Format danh sách tour: tính số ngày, kiểm tra dữ liệu
    ========================================================== */
    private function formatTours(array $tours): array {
        foreach ($tours as $key => $t) {
            if (!empty($t['start_date']) && !empty($t['end_date'])) {
                try {
                    $start = new DateTime($t['start_date']);
                    $end   = new DateTime($t['end_date']);
                    $days  = $start->diff($end)->days + 1;
                    $tours[$key]['lich_trinh'] = $days . " ngày";
                } catch (Exception $e) {
                    $tours[$key]['lich_trinh'] = "Lỗi ngày tháng";
                }
            } else {
                $tours[$key]['lich_trinh'] = "Chưa xác định";
            }
        }
        return $tours;
    }

    /* ==========================================================
        DANH SÁCH TOUR
    ========================================================== */
    public function index() {
        $tours = $this->tour->getAll() ?? [];
        $active = 'tour';

        $tours = $this->formatTours($tours);

        $content = render("tours/list", [
            'tours'  => $tours,
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /* ==========================================================
        TOUR CATEGORY (DOMESTIC / INTERNATIONAL)
    ========================================================== */
    public function category() {
    $category = $_GET['type'] ?? null; // null → tất cả tour

    if ($category) {
        $tours = $this->tour->getByCategory($category) ?? [];
    } else {
        $tours = $this->tour->getAll() ?? [];
    }

    $tours = $this->formatTours($tours);

    $active = 'category';

    // Render view
    $content = render("tours/category", [
        'tours'  => $tours,
        'active' => $active
    ]);

    include dirname(__DIR__) . "/views/main.php";


    }

    /* ==========================================================
        FORM THÊM TOUR
    ========================================================== */
    public function add() {
        requireRole([1,4]);
        $active = 'tour';
        $content = render("tours/add", ['active'=>$active]);
        include dirname(__DIR__) . "/views/main.php";
    }

    /* ==========================================================
        FORM SỬA TOUR
    ========================================================== */
    public function edit() {
        requireRole([1,4]);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?action=listTours");
            exit;
        }

        $tour = $this->tour->find($id);
        $active = 'tour';

        $content = render("tours/edit", [
            'tour' => $tour,
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /* ==========================================================
        LƯU TOUR MỚI
    ========================================================== */
    public function save() {
        requireRole([1,4]);
        $img = null;
        if (!empty($_FILES['main_image']['name'])) {
            $newName = "tour_" . uniqid() . ".jpg";
            $path = "assets/uploads/" . $newName;
            move_uploaded_file($_FILES['main_image']['tmp_name'], $path);
            $img = $path;
        }

        $data = [
            "category_id" => $_POST['category_id'],
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            "start_date" => $_POST['start_date'],
            "end_date" => $_POST['end_date'],
            "supplier_id" => $_POST['supplier_id'],
            "staff_id" => $_POST['staff_id'],
            "main_image" => $img
        ];

        $this->tour->insert($data);
        header("Location: index.php?action=listTours");
    }

    /* ==========================================================
        CẬP NHẬT TOUR
    ========================================================== */
    public function update() {
        requireRole([1,4]);
        $id = $_POST['id'];
        $img = $_POST['old_image'] ?? null;

        if (!empty($_FILES['main_image']['name'])) {
            $newName = "tour_" . uniqid() . ".jpg";
            $path = "assets/uploads/" . $newName;
            move_uploaded_file($_FILES['main_image']['tmp_name'], $path);
            $img = $path;
        }

        $data = [
            "category_id" => $_POST['category_id'],
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            "start_date" => $_POST['start_date'],
            "end_date" => $_POST['end_date'],
            "supplier_id" => $_POST['supplier_id'],
            "staff_id" => $_POST['staff_id'],
            "main_image" => $img
        ];

        $this->tour->updateTour($id, $data);
        header("Location: index.php?action=listTours");
    }

    /* ==========================================================
        XÓA TOUR
    ========================================================== */
    public function delete() {
        requireRole([1,4]);
        $id = $_GET['id'] ?? null;
        if ($id) $this->tour->delete($id);

        header("Location: index.php?action=listTours");
    }

    /* ==========================================================
        CHI TIẾT TOUR
    ========================================================== */
    public function detail() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?action=listTours");
            exit;
        }

        $tour = $this->tour->find($id);
        $active = 'tour';

        $content = render("tours/detail", [
            'tour' => $tour,
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /* ==========================================================
        ITINERARY
    ========================================================== */
    public function viewItinerary() {
        $tour_id = $_GET['id'] ?? null;
        if (!$tour_id) return;

        $tour = $this->tour->find($tour_id);
        $itineraries = $this->tour->getItineraryByTourId($tour_id);

        $content = render("tours/itineraries/itinerary_detail", [
            'tour' => $tour,
            'itineraries' => $itineraries
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function addItinerary() {
        $tour_id = $_GET['tour_id'] ?? null;
        if (!$tour_id) return;

        $tour = $this->tour->find($tour_id);
        $active = 'tour';

        $content = render("tours/itineraries/add", [
            'tour' => $tour,
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function saveItinerary() {
        $data = [
            "tour_id" => $_POST['tour_id'],
            "day_number" => $_POST['day_number'],
            "title" => $_POST['title'],
            "details" => $_POST['details'],
        ];

        $this->tour->insertItinerary($data);
        header("Location: index.php?action=viewItinerary&id=" . $_POST['tour_id']);
    }

    public function editItinerary() {
        $id = $_GET['id'] ?? null;
        if (!$id) return;

        $item = $this->tour->findItinerary($id);
        $tour = $this->tour->find($item['tour_id']);
        $active = 'tour';

        $content = render("tours/itineraries/edit", [
            'item' => $item,
            'tour' => $tour,
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function updateItinerary() {
        $id = $_POST['id'] ?? null;
        $tour_id = $_POST['tour_id'] ?? null;
        if (!$id || !$tour_id) return;

        $data = [
            "day_number" => $_POST['day_number'],
            "title" => $_POST['title'],
            "details" => $_POST['details'],
        ];

        $this->tour->updateItinerary($id, $data);
        header("Location: index.php?action=viewItinerary&id=" . $tour_id);
    }

    public function deleteItinerary() {
        $id = $_GET['id'] ?? null;
        $tour_id = $_GET['tour_id'] ?? null;
        if ($id) $this->tour->deleteItinerary($id);

        header("Location: index.php?action=viewItinerary&id=" . $tour_id);
        
    }

}
