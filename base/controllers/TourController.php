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
            $tours[$key]['lich_trinh'] = 'Chưa xác định'; // Mặc định
            
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
     * Phương thức hiển thị form thêm tour mới
     */
    public function add() {
        $active = 'tour';

        // Lấy danh sách cho các Select Box
        $staffs = $this->tourModel->getAllStaff();
        $suppliers = $this->tourModel->getAllSuppliers();
        $categories = $this->tourModel->getAllCategories(); // <--- ĐÃ THÊM CATEGORIES
        
        $content = render("tours/add", [
            'staffs' => $staffs,
            'suppliers' => $suppliers,
            'categories' => $categories, // <--- TRUYỀN CATEGORIES SANG VIEW
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
        
        $tour = $this->tourModel->find($id);

        $staffs = $this->tourModel->getAllStaff();
        $suppliers = $this->tourModel->getAllSuppliers();
        $categories = $this->tourModel->getAllCategories(); // <--- ĐÃ THÊM CATEGORIES

        // Tính tổng số ngày để điền vào form (nếu có)
        $total_days = $this->tourModel->getTotalDays($id);

        // Xử lý lỗi nếu không tìm thấy tour
        if (!$tour) {
header("Location: index.php?action=listTours&message=Không tìm thấy Tour cần sửa");
             exit;
        }

        $content = render("tours/edit", [
            'tour' => $tour,
            'staffs' => $staffs,    
            'suppliers' => $suppliers, 
            'categories' => $categories, // <--- TRUYỀN CATEGORIES SANG VIEW
            'total_days' => $total_days, 
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Phương thức lưu tour mới (ĐÃ CẬP NHẬT: Thêm category_id)
     */
    public function save() {
        $img = null;

        // --- 1. Xử lý tải lên ảnh ---
        if (!empty($_FILES['main_image']['name'])) {
            $name = "tour_img_" . uniqid() . ".jpg";
            $path = "assets/uploads/" . $name;
            // Kiểm tra và tạo thư mục nếu cần
            $upload_dir = dirname(__DIR__) . "/assets/uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            move_uploaded_file($_FILES['main_image']['tmp_name'], dirname(__DIR__) . "/" . $path);
            $img = $path;
        }

        // Lấy dữ liệu thô từ POST
        $start_date_post = $_POST['start_date'] ?? '';
        $total_days = (int)($_POST['total_days'] ?? 0);

        $end_date = null;
        $start_date = null;

        // --- 2. LOGIC TÍNH TOÁN NGÀY KẾT THÚC VÀ CHUẨN HÓA ---
        if (!empty($start_date_post) && $total_days > 0) {
            try {
                $start_date = $start_date_post; // Ngày bắt đầu hợp lệ
                $end_date_obj = new DateTime($start_date);
                $end_date_obj->modify('+' . ($total_days - 1) . ' days');
                $end_date = $end_date_obj->format('Y-m-d');
            } catch (Exception $e) {
                // Nếu lỗi ngày tháng, gán NULL
                $start_date = null; 
                $end_date = null;
            }
        } else {
            // Nếu không có total_days hoặc start_date rỗng, gán NULL
            $start_date = empty($start_date_post) ? null : $start_date_post;
            $end_date = null; 
        }
        
        // --- 3. KHẮC PHỤC LỖI 1366 (Cột INT) và LẤY CATEGORY_ID ---
        $staff_id = empty($_POST['staff_id']) ? null : $_POST['staff_id'];
        $supplier_id = empty($_POST['supplier_id']) ? null : $_POST['supplier_id'];
        $category_id = empty($_POST['category_id']) ? null : $_POST['category_id']; // <--- THÊM CATEGORY_ID

        // --- 4. GÁN DỮ LIỆU ĐỂ LƯU ---
        $data = [
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            
            "start_date" => $start_date,
            "end_date" => $end_date, 
            
            "staff_id" => $staff_id,
            "supplier_id" => $supplier_id,
"category_id" => $category_id, // <--- TRUYỀN CATEGORY_ID
            
            "main_image" => $img
        ];

        // --- 5. GỌI MODEL VÀ CHUYỂN HƯỚNG ---
        $this->tourModel->insert($data); 
        
        header("Location: index.php?action=listTours&message=Thêm tour thành công");
        exit;
    }
    
    /**
     * Phương thức cập nhật tour (ĐÃ CẬP NHẬT: Thêm category_id)
     */
    public function update() {
        $id = $_POST['id'];
        $img = $_POST['old_image'];

        // --- 1. Xử lý tải lên ảnh ---
        if (!empty($_FILES['main_image']['name'])) {
            $name = "tour_img_" . uniqid() . ".jpg";
            $path = "assets/uploads/" . $name;
             $upload_dir = dirname(__DIR__) . "/assets/uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            move_uploaded_file($_FILES['main_image']['tmp_name'], dirname(__DIR__) . "/" . $path);
            $img = $path;
        }

        // Lấy dữ liệu ngày tháng/lịch trình từ POST
        $start_date_post = $_POST['start_date'] ?? '';
        $total_days = (int)($_POST['total_days'] ?? 0); 

        $end_date = null;
        $start_date = null;

        // --- 2. LOGIC TÍNH TOÁN VÀ XỬ LÝ LỖI NGÀY THÁNG ---
        if ($total_days > 0 && !empty($start_date_post)) {
            try {
                $start_date = $start_date_post;
                $end_date_obj = new DateTime($start_date);
                $end_date_obj->modify('+' . ($total_days - 1) . ' days');
                $end_date = $end_date_obj->format('Y-m-d');
            } catch (Exception $e) {
                $start_date = null;
                $end_date = null;
            }
        } else {
            // Chuẩn hóa ngày
            $start_date = empty($start_date_post) ? null : $start_date_post;
            $end_date = null; 
        }
        
        // --- 3. Lấy các khóa ngoại ---
        $staff_id = empty($_POST['staff_id']) ? null : $_POST['staff_id'];
        $supplier_id = empty($_POST['supplier_id']) ? null : $_POST['supplier_id'];
        $category_id = empty($_POST['category_id']) ? null : $_POST['category_id']; // <--- THÊM CATEGORY_ID

        $data = [
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            
            "start_date" => $start_date, 
            "end_date" => $end_date, 
            
            "staff_id" => $staff_id,
            "supplier_id" => $supplier_id,
            "category_id" => $category_id, // <--- TRUYỀN CATEGORY_ID
            "main_image" => $img
        ];

        // --- 4. Gọi Model để cập nhật ---
        $this->tourModel->updateTour($id, $data); 
        header("Location: index.php?action=listTours&message=Cập nhật tour thành công");
        exit;
    }

    /**
* Phương thức xóa tour
     */
    public function delete() {
        $id = $_GET['id'];
        $this->tourModel->delete($id);
        header("Location: index.php?action=listTours&message=Xóa tour thành công");
        exit;
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

        $content = render("tours/itineraries/itinerary_detail", [
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
        
        $content = render("tours/itineraries/add", [
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
        header("Location: index.php?action=viewItinerary&id=" . $tour_id . "&message=Thêm lịch trình thành công");
        exit;
    }

    /**
     * Hiển thị form chỉnh sửa một mục Lịch trình
     */
    public function editItinerary() {
        $id = $_GET['id']; // ID của mục lịch trình
        $item = $this->tourModel->findItinerary($id);

        if (!$item) {
             header("Location: index.php?action=listTours&message=Không tìm thấy mục lịch trình");
             exit;
        }

        $tour = $this->tourModel->find($item['tour_id']);

        $content = render("tours/itineraries/edit", [
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
        header("Location: index.php?action=viewItinerary&id=" . $tour_id . "&message=Cập nhật lịch trình thành công");
        exit;
    }

    /**
     * Xử lý xóa mục Lịch trình
     */
    public function deleteItinerary() {
        $id = $_GET['id']; // ID của mục lịch trình
        $tour_id = $_GET['tour_id']; // ID của tour (để tiện redirect)

        $this->tourModel->deleteItinerary($id);
        header("Location: index.php?action=viewItinerary&id=" . $tour_id . "&message=Xóa lịch trình thành công");
        exit;
    }

    // ----------------------------------------------------------------------
    // PHƯƠNG THỨC QUẢN LÝ ALBUM ẢNH (Photo CRUD)
    // ----------------------------------------------------------------------

    /**
     * Hiển thị Album ảnh của một Tour
     */
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

    /**
     * Hiển thị form thêm ảnh mới
     */
    public function addPhoto() {
        $tour_id = $_GET['tour_id'];
        $tour = $this->tourModel->find($tour_id);

        $content = render("tours/album/add", [ 
            'tour' => $tour
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    /**
     * Xử lý lưu ảnh mới
     */
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
        
        header("Location: index.php?action=viewAlbum&id=" . $tour_id . "&message=Thêm ảnh thành công");
        exit;
    }

    /**
     * Xử lý xóa ảnh
     */
   public function deletePhoto() {
    $id = $_GET['id'];
    $tour_id = $_GET['tour_id'];

    // 1. TÌM ĐƯỜNG DẪN ẢNH VẬT LÝ
    // Giả sử bạn tạo một hàm mới trong TourModel: findPhoto($id)
$photo_record = $this->tourModel->findPhoto($id); 

    if ($photo_record && !empty($photo_record['image_path'])) {
        $file_path = dirname(__DIR__) . '/' . $photo_record['image_path'];
        
        // 2. XÓA FILE VẬT LÝ (Kiểm tra file tồn tại trước khi xóa)
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    // 3. XÓA BẢN GHI TRONG DB
    $this->tourModel->deletePhoto($id);
    
    header("Location: index.php?action=viewAlbum&id=" . $tour_id . "&message=Xóa ảnh thành công");
    exit;
}
}
