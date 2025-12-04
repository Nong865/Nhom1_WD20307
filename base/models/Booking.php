<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table = 'bookings';
    
    protected $huongDanVienTable = 'huong_dan_vien';
    protected $partnerTable = 'partners';
    protected $historyTable = 'booking_history'; // Tên bảng lịch sử trạng thái
    protected $tourTable = 'tours';
    protected $bookingPartnerTable = 'booking_partners';

    // ======================================================================
    // 1. CHỨC NĂNG READ (LIST & DETAIL)
    // ======================================================================

    /**
     * Lấy tất cả booking kèm thông tin Hướng dẫn viên + Partner
     */
    public function getAll()
    {
        $sql = "SELECT 
                    b.*, 
                    hdv.ho_ten AS hdv_ho_ten, 
                    hdv.chung_chi AS hdv_chung_chi
                FROM {$this->table} b
                LEFT JOIN {$this->huongDanVienTable} hdv ON b.huong_dan_vien_id = hdv.id
                ORDER BY b.booking_date DESC";

        $bookings = $this->queryAll($sql);

        foreach ($bookings as &$booking) {
            $partners = $this->getPartnersByBooking($booking['id']);
            $booking['partners'] = $partners;
            
            $booking['hdv_ho_ten'] = $booking['hdv_ho_ten'] ?? 'Chưa phân công';
            $booking['hdv_chung_chi'] = $booking['hdv_chung_chi'] ?? '';
        }

        return $bookings;
    }

    /**
     * Lấy một Booking theo ID (Hỗ trợ Detail/Edit)
     */
    public function getById($id)
        {
        $sql = "SELECT 
                    b.*, 
                    h.ho_ten AS hdv_ho_ten,
                    t.name AS tour_name_full,
                    t.price AS price_per_person
                FROM {$this->table} b
                LEFT JOIN {$this->huongDanVienTable} h ON b.huong_dan_vien_id = h.id
                LEFT JOIN {$this->tourTable} t ON b.tour_name = t.name 
                WHERE b.id = :id";
                
        $booking = $this->queryOne($sql, ['id' => $id]);
        
        if ($booking) {
            $booking['partners'] = $this->getPartnersByBooking($booking['id']);
        }
        return $booking;
    }
    
    /**
     * Lấy lịch sử trạng thái của một Booking (Hỗ trợ Controller History)
     */
    public function history($bookingId)
    {
        $sql = "
            SELECT old_status, new_status, changed_at
            FROM {$this->historyTable}
            WHERE booking_id = :id
            ORDER BY changed_at DESC
        ";
        return $this->queryAll($sql, ['id' => $bookingId]);
    }


    // ======================================================================
    // 2. CHỨC NĂNG HELPER & CREATE
    // ======================================================================

public function getPartnersByBooking($bookingId)
{
    $sql = "
        SELECT p.id, p.name
        FROM {$this->partnerTable} p
        INNER JOIN {$this->bookingPartnerTable} bp ON bp.partner_id = p.id
        WHERE bp.booking_id = :booking_id /* SỬA TÊN CỘT KHÓA NGOẠI */
    ";
    // Đảm bảo key trong mảng execute khớp:
    return $this->queryAll($sql, ['booking_id' => $bookingId]); 
}

    public function getAllHuongDanVien()
    {
        $sql = "SELECT id, ho_ten, chung_chi FROM {$this->huongDanVienTable} ORDER BY ho_ten ASC";
        return $this->queryAll($sql);
    }

    public function getAllPartners()
    {
        $sql = "SELECT id, name FROM {$this->partnerTable} ORDER BY name ASC"; 
        return $this->queryAll($sql);
    }

    public function getAllTours()
    {
        $sql = "SELECT id, name, price FROM {$this->tourTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    public function getTourByName($name)
    {
        $sql = "SELECT id, name, price FROM {$this->tourTable} WHERE name = :name LIMIT 1";
        return $this->queryOne($sql, ['name' => $name]);
    }
    
    public function createBooking($data, $partnerIds = [])
    {
        // ... (Logic tạo Booking và Booking Partners) ...
        // Logic này không có trong đoạn mã bạn gửi, nhưng giả định là đã tồn tại.
        return true; 
    }
    
    /**
     * Lấy trạng thái hiện tại của Booking
     */
    public function getBookingStatus($id)
    {
        $sql = "SELECT status FROM {$this->table} WHERE id = :id";
        $result = $this->queryOne($sql, ['id' => $id]);
        return $result['status'] ?? null;
    }

    /**
     * Thêm bản ghi lịch sử trạng thái
     */
    public function insertHistory($data) {
        $table = 'booking_history';
        $dataToInsert = [
            'booking_id' => $data['booking_id'], 
            'old_status' => $data['old_status'],
            'new_status' => $data['new_status'],
            'changed_at' => $data['changed_at'] ?? date('Y-m-d H:i:s')
        ];
        return $this->insert($dataToInsert, $table); // Giả sử hàm $this->insert() tồn tại
    }

    // ======================================================================
    // 3. CHỨC NĂNG UPDATE (EDIT/UPDATE STATUS)
    // ======================================================================

    /**
     * Cập nhật thông tin chi tiết Booking (Hỗ trợ Controller Update)
     */
    public function updateBooking($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                    customer_name = :customer_name, 
                    customer_phone = :customer_phone, 
                    tour_name = :tour_name, 
                    tour_date = :tour_date, 
                    special_request = :special_request,
                    quantity = :quantity,
                    huong_dan_vien_id = :huong_dan_vien_id,
                    total_price = :total_price
                WHERE id = :id";

        $params = [
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'tour_name' => $data['tour_name'],
            'tour_date' => $data['tour_date'],
            'special_request' => $data['special_request'],
            'quantity' => $data['quantity'],
            'huong_dan_vien_id' => $data['huong_dan_vien_id'],
            'total_price' => $data['total_price'],
            'id' => $id
        ];
        
        return $this->queryExecute($sql, $params);
    }
    
    /**
     * Cập nhật trạng thái Booking và lưu lịch sử
     * (Hỗ trợ Controller updateStatus)
     */
    public function updateStatus($id, $newStatus)
    {
        $oldStatus = $this->getBookingStatus($id);

        if ($oldStatus === null || $oldStatus === $newStatus) {
            // Không tìm thấy booking hoặc không có thay đổi trạng thái
            return false; 
        }

        try {
            // Bắt đầu giao dịch để đảm bảo tính toàn vẹn dữ liệu
            $this->pdo->beginTransaction(); // Giả sử $this->pdo là đối tượng PDO
            
            // 1. Cập nhật trạng thái trong bảng chính
            $sql_update = "UPDATE {$this->table} SET status = :status WHERE id = :id";
            $updateResult = $this->queryExecute($sql_update, ['status' => $newStatus, 'id' => $id]);

            if ($updateResult) {
                // 2. Chèn bản ghi lịch sử
                $historyData = [
                    'booking_id' => $id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ];
                $historyResult = $this->insertHistory($historyData);
                
                if (!$historyResult) {
                    throw new Exception("Failed to insert booking history.");
                }
            } else {
                throw new Exception("Failed to update booking status.");
            }

            // Kết thúc giao dịch thành công
            $this->pdo->commit();
            return true;
            
        } catch (Exception $e) {
            // Hoàn tác giao dịch nếu có lỗi
            $this->pdo->rollBack();
            // Bạn có thể ghi log lỗi ở đây: error_log($e->getMessage());
            return false;
        }
    }


    // ======================================================================
    // 4. CHỨC NĂNG DELETE (XÓA)
    // ======================================================================

    /**
     * Xóa Booking và các bản ghi liên quan (Lịch sử, Partners)
     */
    public function deleteBooking($id)
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Xóa Booking Partners liên quan
            $sql_partners = "DELETE FROM {$this->bookingPartnerTable} WHERE booking_id = ?";
            $this->queryExecute($sql_partners, [$id]);
            
            // 2. Xóa Lịch sử Booking liên quan
            $sql_history = "DELETE FROM {$this->historyTable} WHERE booking_id = ?";
            $this->queryExecute($sql_history, [$id]);
            
            // 3. Xóa bản ghi Booking chính
            $sql_booking = "DELETE FROM {$this->table} WHERE id = ?";
            $result = $this->queryExecute($sql_booking, [$id]);

            $this->pdo->commit();
            return $result;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}