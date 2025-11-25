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

  
    public function add() {
    $active = 'tour';

    // 1. Lấy danh sách Nhân sự (Staff)
    // Cần cho select box "Hướng dẫn viên"
    $staffs = $this->tourModel->getAllStaff();
    
    // 2. Lấy danh sách Nhà cung cấp (Suppliers)
    // Cần cho select box "Nhà cung cấp"
    $suppliers = $this->tourModel->getAllSuppliers();

    // 3. Truyền dữ liệu sang View
    $content = render("tours/add", [
        'staffs' => $staffs,     // <--- Bổ sung
        'suppliers' => $suppliers, // <--- Bổ sung
        'active' => $active
    ]);

    include dirname(__DIR__) . "/views/main.php";
}

    /**
     * Phương thức hiển thị form chỉnh sửa tour
     */
    public function edit() {
        $id = $_GET['id'];
        $active = 'tour';
         // Lấy tổng số ngày của tour để pre-fill vào form
        $tour = $this->tourModel->find($id);

        $staffs = $this->tourModel->getAllStaff();
        $suppliers = $this->tourModel->getAllSuppliers();

        $total_days = $this->tourModel->getTotalDays($id);

        

       $content = render("tours/edit", [
        'tour' => $tour,
        'staffs' => $staffs,     
        'suppliers' => $suppliers, 
        'total_days' => $total_days, 
        'active' => $active
    ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Phương thức lưu tour mới
     */
// Trong TourController.php

public function save() {
    $img = null;

    // --- 1. Xử lý tải lên ảnh (Giữ nguyên) ---
    if (!empty($_FILES['main_image']['name'])) {
        $name = "tour_img_" . uniqid() . ".jpg";
        $path = "assets/uploads/" . $name;
        move_uploaded_file($_FILES['main_image']['tmp_name'], $path);
        $img = $path;
    }

    // Lấy dữ liệu thô từ POST
    $start_date_post = $_POST['start_date'] ?? '';
    $total_days = (int)($_POST['total_days'] ?? 0);

    $end_date = null;
    $start_date = null;

    // --- 2. LOGIC TÍNH TOÁN NGÀY KẾT THÚC ---
    if (!empty($start_date_post) && $total_days > 0) {
        try {
            $start_date = $start_date_post; // Ngày bắt đầu hợp lệ
            $end_date_obj = new DateTime($start_date);
            $end_date_obj->modify('+' . ($total_days - 1) . ' days');
            $end_date = $end_date_obj->format('Y-m-d');
        } catch (Exception $e) {
            $start_date = null; 
            $end_date = null;
        }
    } else {
        // KHẮC PHỤC LỖI DATE: Nếu ngày bắt đầu rỗng (''), gán thành null
        $start_date = empty($start_date_post) ? null : $start_date_post;
    }
    
    // --- 3. KHẮC PHỤC LỖI 1366 (Cột INT) ---
    // Chuyển chuỗi rỗng ('') thành NULL cho staff_id và supplier_id
    $staff_id = empty($_POST['staff_id']) ? null : $_POST['staff_id'];
    $supplier_id = empty($_POST['supplier_id']) ? null : $_POST['supplier_id'];

    // --- 4. GÁN DỮ LIỆU ĐỂ LƯU ---
    $data = [
        "name" => $_POST['name'],
        "price" => $_POST['price'],
        "description" => $_POST['description'],
        
        // Dữ liệu ngày tháng đã tính toán/chuẩn hóa
        "start_date" => $start_date,
        "end_date" => $end_date, 
        
        // Khóa ngoại đã chuẩn hóa
        "staff_id" => $staff_id,
        "supplier_id" => $supplier_id,
        
        "main_image" => $img
    ];

    // --- 5. GỌI MODEL VÀ CHUYỂN HƯỚNG ---
    $this->tourModel->insert($data); 
    
    header("Location: index.php?action=listTours");
}
  


public function update() {
    $id = $_POST['id'];
    $img = $_POST['old_image'];

    // --- 1. Xử lý tải lên ảnh (Giữ nguyên) ---
    if (!empty($_FILES['main_image']['name'])) {
        $name = "tour_img_" . uniqid() . ".jpg";
        $path = "assets/uploads/" . $name;
        move_uploaded_file($_FILES['main_image']['tmp_name'], $path);
        $img = $path;
    }

    // Lấy dữ liệu ngày tháng/lịch trình từ POST
    $start_date_post = $_POST['start_date'] ?? '';
    // Lấy số ngày lịch trình từ form (Giả sử form edit đã có trường total_days)
    $total_days = (int)($_POST['total_days'] ?? 0); 

    $end_date = null;
    $start_date = null;

    // --- 2. LOGIC TÍNH TOÁN VÀ XỬ LÝ LỖI NGÀY THÁNG ---
    if ($total_days > 0 && !empty($start_date_post)) {
        try {
            $start_date = $start_date_post;
            $end_date_obj = new DateTime($start_date);
            // Tính Ngày kết thúc: Ngày bắt đầu + (Số ngày - 1)
            $end_date_obj->modify('+' . ($total_days - 1) . ' days');
            $end_date = $end_date_obj->format('Y-m-d');
        } catch (Exception $e) {
            // Nếu có lỗi parse ngày, gán về NULL để tránh lỗi SQL
            $start_date = null;
            $end_date = null;
        }
    } else {
        // Nếu không có total_days hoặc start_date, KHẮC PHỤC LỖI Fatal error: Invalid datetime format
        $start_date = empty($start_date_post) ? null : $start_date_post;
        $end_date = null; 
    }
    
    // --- 3. Lấy các khóa ngoại ---
    $staff_id_post = $_POST['staff_id'] ?? '';
    $supplier_id_post = $_POST['supplier_id'] ?? '';

    $staff_id = empty($staff_id_post) ? null : $staff_id_post;
    $supplier_id = empty($supplier_id_post) ? null : $supplier_id_post;


    $data = [
        "name" => $_POST['name'],
        "price" => $_POST['price'],
        "description" => $_POST['description'],
        
        // SỬ DỤNG GIÁ TRỊ ĐÃ CHUẨN HÓA (NULL hoặc DATE)
        "start_date" => $start_date, 
        "end_date" => $end_date, 
        
        // SỬ DỤNG CÁC TRƯỜNG MỚI
        "staff_id" => $staff_id,
        "supplier_id" => $supplier_id,
        "main_image" => $img
    ];

    // --- 4. Gọi Model để cập nhật ---
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

    public function viewAlbum() {
        $tour_id = $_GET['id'];
        $tour = $this->tourModel->find($tour_id); 
        $photos = $this->tourModel->getAlbumByTourId($tour_id);

        $content = render("tours/album/view", [ 
            'tour' => $tour,
            'photos' => $photos
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function addPhoto() {
        $tour_id = $_GET['tour_id'];
        $tour = $this->tourModel->find($tour_id);

        $content = render("tours/album/add", [ 
            'tour' => $tour
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function savePhoto() {
        $tour_id = $_POST['tour_id'];
        $caption = $_POST['caption'] ?? '';
        $img = null;

        // Xử lý upload file
        if (!empty($_FILES['image_file']['name'])) {
            $name = "album_img_" . uniqid() . ".jpg";
            $upload_dir = dirname(__DIR__) . "/assets/uploads/album/";
            
            // Đảm bảo thư mục tồn tại
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $path = "assets/uploads/album/" . $name;
            move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_dir . $name);
            $img = $path;
        }

        if ($img) {
            $data = [
                "tour_id" => $tour_id,
                "image_path" => $img,
                "caption" => $caption
            ];
            $this->tourModel->insertPhoto($data);
        }
        
        // Chuyển hướng về trang Album sau khi lưu
        header("Location: index.php?action=viewAlbum&id=" . $tour_id);
    }

    public function deletePhoto() {
        $id = $_GET['id'];
        $tour_id = $_GET['tour_id'];
        
        // Cần thêm logic xóa file vật lý tại đây nếu muốn
        
        $this->tourModel->deletePhoto($id);
        
        // Chuyển hướng về trang Album
        header("Location: index.php?action=viewAlbum&id=" . $tour_id);
    }

    
}