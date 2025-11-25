<?php
require_once "BaseModel.php";

class TourModel extends BaseModel
{
    protected $table = "tours";

    /**
     * Lấy tất cả tour kèm HDV, nhà cung cấp và album ảnh
     */
    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} ORDER BY id ASC");
        $stmt->execute();
        $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tours as &$tour) {
            // HDV
            $tour['hdv'] = '';
            if (!empty($tour['staff_id'])) {
                $stmt2 = $this->pdo->prepare("SELECT ho_ten AS name FROM huong_dan_vien WHERE id=?");
                $stmt2->execute([$tour['staff_id']]);
                $staff = $stmt2->fetch(PDO::FETCH_ASSOC);
                $tour['hdv'] = $staff['name'] ?? '';
            }

            // Nhà cung cấp
            $tour['ncc'] = '';
            if (!empty($tour['supplier_id'])) {
                $stmt3 = $this->pdo->prepare("SELECT name FROM 	partners WHERE id=?");
                $stmt3->execute([$tour['supplier_id']]);
                $supplier = $stmt3->fetch(PDO::FETCH_ASSOC);
                $tour['ncc'] = $supplier['name'] ?? '';
            }

            // Album ảnh từ bảng photos
            $stmt4 = $this->pdo->prepare("SELECT image_path AS image, caption FROM photos WHERE tour_id=?");
            $stmt4->execute([$tour['id']]);
            $tour['album'] = $stmt4->fetchAll(PDO::FETCH_ASSOC);
        }

        return $tours;
    }

    /**
     * Lấy 1 tour theo ID
     */
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tour) {
            // HDV
            $tour['hdv'] = '';
            if (!empty($tour['staff_id'])) {
                $stmt2 = $this->pdo->prepare("SELECT ho_ten AS name FROM huong_dan_vien WHERE id=?");
                $stmt2->execute([$tour['staff_id']]);
                $staff = $stmt2->fetch(PDO::FETCH_ASSOC);
                $tour['hdv'] = $staff['name'] ?? '';
            }

            // Nhà cung cấp
            $tour['ncc'] = '';
            if (!empty($tour['supplier_id'])) {
                $stmt3 = $this->pdo->prepare("SELECT name FROM partners WHERE id=?");
                $stmt3->execute([$tour['supplier_id']]);
                $supplier = $stmt3->fetch(PDO::FETCH_ASSOC);
                $tour['ncc'] = $supplier['name'] ?? '';
            }

            // Album ảnh
            $stmt4 = $this->pdo->prepare("SELECT image_path AS image, caption FROM photos WHERE tour_id=?");
            $stmt4->execute([$tour['id']]);
            $tour['album'] = $stmt4->fetchAll(PDO::FETCH_ASSOC);
        }

        return $tour;
    }

    /**
     * Thêm tour mới
     */
    public function insert($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} 
            (name, price, description, start_date, end_date, created_at, staff_id, supplier_id, main_image) 
            VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?)"
        );

        $stmt->execute([
            $data['name'],
            $data['price'],
            $data['description'],
            $data['start_date'],
            $data['end_date'],
            $data['staff_id'] ?? null,
            $data['supplier_id'] ?? null,
            $data['main_image'] ?? null
        ]);

        return $this->pdo->lastInsertId();
    }

    /**
     * Cập nhật tour
     */
    public function updateTour($id, $data)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->table} SET 
                name=?, price=?, description=?, start_date=?, end_date=?, staff_id=?, supplier_id=?, main_image=? 
            WHERE id=?"
        );

        return $stmt->execute([
            $data['name'],
            $data['price'],
            $data['description'],
            $data['start_date'],
            $data['end_date'],
            $data['staff_id'] ?? null,
            $data['supplier_id'] ?? null,
            $data['main_image'] ?? null,
            $id
        ]);
    }

    /**
     * Xóa tour
     */
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }


    /**
     * Lấy Lịch trình chi tiết của một tour theo ID
     */
    public function getItineraryByTourId($tourId) 
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM tour_itineraries 
            WHERE tour_id = ? 
            ORDER BY day_number ASC
        ");
        $stmt->execute([$tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy một mục Lịch trình theo ID của mục đó
     */
    public function findItinerary($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tour_itineraries WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Thêm mục Lịch trình mới
     */
    public function insertItinerary($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO tour_itineraries (tour_id, day_number, title, details) 
            VALUES (?, ?, ?, ?)"
        );

        return $stmt->execute([
            $data['tour_id'],
            $data['day_number'],
            $data['title'],
            $data['details']
        ]);
    }

    /**
     * Cập nhật mục Lịch trình
     */
    public function updateItinerary($id, $data)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE tour_itineraries SET 
                day_number=?, title=?, details=?
            WHERE id=?"
        );

        return $stmt->execute([
            $data['day_number'],
            $data['title'],
            $data['details'],
            $id
        ]);
    }

    /**
     * Xóa mục Lịch trình
     */
    public function deleteItinerary($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tour_itineraries WHERE id=?");
        return $stmt->execute([$id]);
    }
    public function getAlbumByTourId($tourId) 
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM photos 
            WHERE tour_id = ? 
            ORDER BY id ASC
        ");
        $stmt->execute([$tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm ảnh mới vào Album
     */
    public function insertPhoto($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO photos (tour_id, image_path, caption, created_at) 
            VALUES (?, ?, ?, NOW())"
        );
        return $stmt->execute([
            $data['tour_id'],
            $data['image_path'],
            $data['caption'] ?? null
        ]);
    }

    /**
     * Xóa ảnh khỏi Album
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
        
        // Bạn có thể thêm logic xóa file vật lý tại đây nếu muốn
        
        $this->tourModel->deletePhoto($id);
        
        // Chuyển hướng về trang Album
        header("Location: index.php?action=viewAlbum&id=" . $tour_id);
    }
    /**
     * Lấy tất cả Nhân sự (Staff) để hiển thị trong select box
     */
    public function getAllStaff()
    {
        // Giả định tên bảng là 'staff' và cột tên là 'name'
        $stmt = $this->pdo->prepare("SELECT id, ho_ten AS name FROM huong_dan_vien ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tất cả Nhà cung cấp (Suppliers) để hiển thị trong select box
     */
    public function getAllSuppliers()
    {
        // Giả định tên bảng là 'suppliers' và cột tên là 'name'
        $stmt = $this->pdo->prepare("SELECT id, name FROM partners ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tổng số ngày của một tour
     * (Cần thiết cho form edit để pre-fill trường total_days)
     */
    public function getTotalDays($tourId)
    {
        $tour = $this->find($tourId); // Sử dụng hàm find() đã có
        if ($tour && !empty($tour['start_date']) && !empty($tour['end_date'])) {
            try {
                $start = new DateTime($tour['start_date']);
                $end = new DateTime($tour['end_date']);
                $interval = $start->diff($end);
                return $interval->days + 1;
            } catch (Exception $e) {
                return 0; // Trả về 0 nếu có lỗi ngày tháng
            }
        }
        return 0;
    }

}
