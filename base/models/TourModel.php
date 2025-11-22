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
                $stmt2 = $this->pdo->prepare("SELECT name FROM staff WHERE id=?");
                $stmt2->execute([$tour['staff_id']]);
                $staff = $stmt2->fetch(PDO::FETCH_ASSOC);
                $tour['hdv'] = $staff['name'] ?? '';
            }

            // Nhà cung cấp
            $tour['ncc'] = '';
            if (!empty($tour['supplier_id'])) {
                $stmt3 = $this->pdo->prepare("SELECT name FROM suppliers WHERE id=?");
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
                $stmt2 = $this->pdo->prepare("SELECT name FROM staff WHERE id=?");
                $stmt2->execute([$tour['staff_id']]);
                $staff = $stmt2->fetch(PDO::FETCH_ASSOC);
                $tour['hdv'] = $staff['name'] ?? '';
            }

            // Nhà cung cấp
            $tour['ncc'] = '';
            if (!empty($tour['supplier_id'])) {
                $stmt3 = $this->pdo->prepare("SELECT name FROM suppliers WHERE id=?");
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
}
