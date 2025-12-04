<?php
require_once "BaseModel.php";

class TourModel extends BaseModel
{
    protected $table = "tours";

    // ======================================================================
    // 1. CHỨC NĂNG CƠ BẢN (CRUD Tour)
    // ======================================================================

    /**
     * Lấy tất cả tour kèm HDV, Nhà cung cấp, và Danh mục (Cho trang list)
     * LƯU Ý: Vẫn dùng nhiều truy vấn con (N+1) để dễ đọc, nên cân nhắc dùng JOIN nếu dữ liệu lớn.
     */
    public function getAll()
    {
        $sql = "SELECT 
                    t.*, 
                    hdv.ho_ten AS hdv_name, 
                    p.name AS ncc_name,
                    c.name AS category_name  /* <-- Tên Danh mục */
                FROM {$this->table} t
                LEFT JOIN huong_dan_vien hdv ON t.staff_id = hdv.id
                LEFT JOIN partners p ON t.supplier_id = p.id
                LEFT JOIN categories c ON t.category_id = c.id /* <-- JOIN với Categories */
                ORDER BY t.id ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Vòng lặp chỉ còn xử lý Album Ảnh (và gán tên từ JOIN)
        foreach ($tours as &$tour) {
            // Gán tên từ kết quả JOIN
            $tour['hdv'] = $tour['hdv_name'] ?? '';
            $tour['ncc'] = $tour['ncc_name'] ?? '';
            $tour['category_name'] = $tour['category_name'] ?? 'Chưa gán'; // <--- Tên danh mục đã có

            // Album ảnh (Vẫn cần truy vấn riêng cho Album nếu không muốn phức tạp hóa JOIN)
            $stmt4 = $this->pdo->prepare("SELECT image_path AS image, caption FROM photos WHERE tour_id=?");
            $stmt4->execute([$tour['id']]);
            $tour['album'] = $stmt4->fetchAll(PDO::FETCH_ASSOC);
            
            // Xóa các trường JOIN tạm thời
            unset($tour['hdv_name'], $tour['ncc_name']); 
        }

        return $tours;
    }

    /**
     * Lấy 1 tour theo ID
     */
    public function find($id)
    {
        $sql = "SELECT 
                    t.*, 
                    hdv.ho_ten AS hdv_name, 
                    p.name AS ncc_name,
                    c.name AS category_name 
                FROM {$this->table} t
                LEFT JOIN huong_dan_vien hdv ON t.staff_id = hdv.id
                LEFT JOIN partners p ON t.supplier_id = p.id
                LEFT JOIN categories c ON t.category_id = c.id
                WHERE t.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tour) {
            // Gán tên từ kết quả JOIN
            $tour['hdv'] = $tour['hdv_name'] ?? '';
            $tour['ncc'] = $tour['ncc_name'] ?? '';
            $tour['category_name'] = $tour['category_name'] ?? 'Chưa gán'; 

            // Album ảnh
            $stmt4 = $this->pdo->prepare("SELECT image_path AS image, caption FROM photos WHERE tour_id=?");
            $stmt4->execute([$tour['id']]);
            $tour['album'] = $stmt4->fetchAll(PDO::FETCH_ASSOC);
            
            // Xóa các trường JOIN tạm thời
            unset($tour['hdv_name'], $tour['ncc_name']); 
        }

        return $tour;
    }

    /**
     * Thêm tour mới (ĐÃ CẬP NHẬT: Thêm category_id)
     */
    public function insert($data, $tableName = null)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} 
             (name, price, description, start_date, end_date, created_at, staff_id, supplier_id, main_image, category_id) 
             VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)"
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
            $data['category_id'] ?? null // <--- Đã thêm category_id
        ]);
    }

    /**
     * Cập nhật tour (ĐÃ CẬP NHẬT: Thêm category_id)
     */
    public function updateTour($id, $data)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->table} SET 
                name=?, price=?, description=?, start_date=?, end_date=?, staff_id=?, supplier_id=?, main_image=?, category_id=? 
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
            $data['category_id'] ?? null, // <--- Đã thêm category_id
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

    // ======================================================================
    // 2. CHỨC NĂNG HỖ TRỢ (Dùng cho Form SELECT và Logic Tính toán)
    // ======================================================================

    /**
     * Lấy tất cả Danh mục tour (Categories)
     */
    public function getAllCategories(){
        $stmt = $this->pdo->prepare("SELECT id, name FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tour theo Danh mục (dùng để lọc)
     */
   public function getByCategory($categoryId)
{
    $sql = "SELECT 
                t.*, 
                hdv.ho_ten AS hdv_name, 
                p.name AS ncc_name,
                c.name AS category_name 
            FROM {$this->table} t
            LEFT JOIN huong_dan_vien hdv ON t.staff_id = hdv.id
            LEFT JOIN partners p ON t.supplier_id = p.id
            LEFT JOIN categories c ON t.category_id = c.id
            WHERE t.category_id = ?       /* <--- Thêm điều kiện lọc */
            ORDER BY t.id ASC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$categoryId]); // <--- Truyền tham số ID vào execute
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Bổ sung logic gán tên và Album (Copy từ hàm getAll())
    foreach ($tours as &$tour) {
        $tour['hdv'] = $tour['hdv_name'] ?? 'Chưa gán';
        $tour['ncc'] = $tour['ncc_name'] ?? 'Chưa gán';
        $tour['category_name'] = $tour['category_name'] ?? 'Chưa gán';
        
        // Logic Album ảnh (nếu cần)
        $stmt4 = $this->pdo->prepare("SELECT image_path AS image, caption FROM photos WHERE tour_id=?");
        $stmt4->execute([$tour['id']]);
        $tour['album'] = $stmt4->fetchAll(PDO::FETCH_ASSOC);
        
        unset($tour['hdv_name'], $tour['ncc_name']); 
    }

    return $tours;
}
public function updateCategoryOnTours($categoryId) {
    // Đặt category_id của tất cả các tour thuộc danh mục này về NULL
    $sql = "UPDATE tours SET category_id = NULL WHERE category_id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$categoryId]);
    return $stmt->rowCount();
}
    
    /**
     * Lấy tất cả Hướng dẫn viên (huong_dan_vien) để hiển thị trong select box
     */
    public function getAllStaff()
    {
        $stmt = $this->pdo->prepare("SELECT id, ho_ten AS name FROM huong_dan_vien ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tất cả Nhà cung cấp (partners) để hiển thị trong select box
     */
    public function getAllSuppliers()
    {
        $stmt = $this->pdo->prepare("SELECT id, name FROM partners ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tổng số ngày của một tour
     */
    public function getTotalDays($tourId)
    {
        $tour = $this->find($tourId); 
        if ($tour && !empty($tour['start_date']) && !empty($tour['end_date'])) {
            try {
                $start = new DateTime($tour['start_date']);
                $end = new DateTime($tour['end_date']);
                $interval = $start->diff($end);
                return $interval->days + 1;
            } catch (Exception $e) {
                return 0;
            }
        }
        return 0;
    }

    // ======================================================================
    // 3. CHỨC NĂNG LỊCH TRÌNH (ITINERARY CRUD)
    // ======================================================================

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
     * Cập nhật mục Lịch trình dựa trên ID
     */
    public function updateItinerary($id, $data)
    {
        $sql = "UPDATE tour_itineraries SET day_number = ?, title = ?, details = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $data['day_number'],
            $data['title'],
            $data['details'],
            $id // ID của mục lịch trình cần cập nhật
        ]);
    }

    /**
     * Tìm một mục Lịch trình bằng ID
     */
    public function findItinerary($id)
    {
        $sql = "SELECT * FROM tour_itineraries WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Xóa mục Lịch trình
     */
    public function deleteItinerary($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tour_itineraries WHERE id=?");
        return $stmt->execute([$id]);
    }
    
    // ======================================================================
    // 4. CHỨC NĂNG ALBUM ẢNH (PHOTO CRUD)
    // ======================================================================

    /**
     * Lấy tất cả ảnh (Album) của một tour
     */
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
    public function deletePhoto($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM photos WHERE id=?");
        return $stmt->execute([$id]);
    }
  
    public function findPhoto($id)
    {
        $sql = "SELECT image_path FROM photos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ======================================================================
// 5. CHỨC NĂNG BẢO TOÀN KHÓA NGOẠI
// ======================================================================

/**
 * Đặt category_id về NULL cho tất cả các Tour thuộc danh mục sắp bị xóa.
 * Đây là bước cần thiết trước khi xóa danh mục trong bảng 'categories'.
 * @param int $categoryId ID của danh mục sắp bị xóa
 * @return bool Kết quả của lệnh UPDATE
 */
public function setCategoryToNull($categoryId)
{
    $sql = "UPDATE {$this->table} SET category_id = NULL WHERE category_id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$categoryId]);
}
}