<?php
require_once dirname(__DIR__) . '/configs/helper.php'; 
require_once dirname(__DIR__) . '/models/TourModel.php';

class TourController {

    private $tourModel;

    public function __construct() {
        $this->tourModel = new TourModel();
    }

    // ----------------------------------------------------------------------
    // PHƯƠNG THỨC QUẢN LÝ TOUR (Tour CRUD)
    // ----------------------------------------------------------------------

    /**
     * Phương thức hiển thị danh sách tours (Đã cập nhật logic tính Số ngày)
     */
    public function index() {
        $tours = $this->tourModel->getAll();
        $active = 'tour';

        // LOGIC TÍNH TOÁN SỐ NGÀY TOUR (Lịch trình)
        foreach ($tours as $key => $tour) {
            // Sử dụng cú pháp MẢNG ($tour['...'])
            if (!empty($tour['start_date']) && !empty($tour['end_date'])) {
                try {
                    $start = new DateTime($tour['start_date']);
                    $end = new DateTime($tour['end_date']);
                    
                    $interval = $start->diff($end);
                    $so_ngay = $interval->days + 1; 
                    
                    // GÁN TRƯỜNG 'lich_trinh' VÀO MẢNG GỐC
                    $tours[$key]['lich_trinh'] = $so_ngay . ' ngày'; 

                } catch (Exception $e) {
                    $tours[$key]['lich_trinh'] = 'Lỗi ngày tháng';
                }
            } else {
                $tours[$key]['lich_trinh'] = 'Chưa xác định';
            }
        }
        // KẾT THÚC LOGIC TÍNH TOÁN

        $content = render("tours/list", [
            'tours' => $tours,
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Phương thức hiển thị form thêm mới tour
     */
    public function add() {
        $active = 'tour';

        $content = render("tours/add", []);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Phương thức hiển thị form chỉnh sửa tour
     */
    public function edit() {
        $id = $_GET['id'];
        $tour = $this->tourModel->find($id);

        $content = render("tours/edit", [
            'tour' => $tour,
            'active' => 'tour'
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Phương thức lưu tour mới
     */
    public function save() {
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

    /**
     * Phương thức cập nhật tour
     */
    public function update() {
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

    /**
     * Phương thức xóa tour
     */
    public function delete() {
        $id = $_GET['id'];
        $this->tourModel->delete($id);
        header("Location: index.php?action=listTours");
    }
    
    // ----------------------------------------------------------------------
    // PHƯƠNG THỨC QUẢN LÝ LỊCH TRÌNH CHI TIẾT (Itinerary CRUD)
    // ----------------------------------------------------------------------

    /**
     * Hiển thị chi tiết Lịch trình của một Tour
     */
    public function viewItinerary() {
        $tour_id = $_GET['id'];
        $tour = $this->tourModel->find($tour_id);
        $itineraries = $this->tourModel->getItineraryByTourId($tour_id);

        $content = render("tours/itineraries/itinerary_detail", [ // ĐƯỜNG DẪN MỚI
            'tour' => $tour,
            'itineraries' => $itineraries
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Hiển thị form thêm mới một mục Lịch trình
     */
    public function addItinerary() {
        $tour_id = $_GET['tour_id'];
        $tour = $this->tourModel->find($tour_id);
        
        $content = render("tours/itineraries/add", [ // ĐƯỜNG DẪN MỚI
            'tour' => $tour,
            'active' => 'tour'
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Xử lý lưu mục Lịch trình mới
     */
    public function saveItinerary() {
        $tour_id = $_POST['tour_id'];

        $data = [
            "tour_id"    => $tour_id,
            "day_number" => $_POST['day_number'],
            "title"      => $_POST['title'],
            "details"    => $_POST['details']
        ];

        $this->tourModel->insertItinerary($data);
        // Quay về trang chi tiết lịch trình của tour đó
        header("Location: index.php?action=viewItinerary&id=" . $tour_id);
    }

    /**
     * Hiển thị form chỉnh sửa một mục Lịch trình
     */
    public function editItinerary() {
        $id = $_GET['id']; // ID của mục lịch trình
        $item = $this->tourModel->findItinerary($id);
        $tour = $this->tourModel->find($item['tour_id']);

        $content = render("tours/itineraries/edit", [ // ĐƯỜNG DẪN MỚI
            'item' => $item,
            'tour' => $tour,
            'active' => 'tour'
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Xử lý cập nhật mục Lịch trình
     */
    public function updateItinerary() {
        $id = $_POST['id']; // ID của mục lịch trình
        $tour_id = $_POST['tour_id'];

        $data = [
            "day_number" => $_POST['day_number'],
            "title"      => $_POST['title'],
            "details"    => $_POST['details']
        ];

        $this->tourModel->updateItinerary($id, $data);
        // Quay về trang chi tiết lịch trình của tour đó
        header("Location: index.php?action=viewItinerary&id=" . $tour_id);
    }

    /**
     * Xử lý xóa mục Lịch trình
     */
    public function deleteItinerary() {
        $id = $_GET['id']; // ID của mục lịch trình
        $tour_id = $_GET['tour_id']; // ID của tour (để tiện redirect)

        $this->tourModel->deleteItinerary($id);
        // Quay về trang chi tiết lịch trình của tour đó
        header("Location: index.php?action=viewItinerary&id=" . $tour_id);
    }
}