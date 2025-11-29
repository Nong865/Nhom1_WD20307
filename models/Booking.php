<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table = 'bookings';
    protected $staffTable = 'staff';
    protected $supplierTable = 'suppliers';
    protected $historyTable = 'booking_history'; 

    public function getAll()
    {
        $sql = "
            SELECT 
                b.*, 
                s.name AS staff_name, 
                sp.name AS supplier_name 
            FROM {$this->table} b
            LEFT JOIN {$this->staffTable} s ON b.staff_id = s.id
            LEFT JOIN {$this->supplierTable} sp ON b.supplier_id = sp.id
            ORDER BY b.booking_date DESC
        ";
        return $this->queryAll($sql);
    }

    /**
     * Lấy danh sách tất cả nhân sự (staff)
     */
    public function getAllStaff()
    {
        $sql = "SELECT id, name FROM {$this->staffTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    /**
     * Lấy danh sách tất cả nhà cung cấp (suppliers)
     */
    public function getAllSuppliers()
    {
        $sql = "SELECT id, name FROM {$this->supplierTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    /**
     * Tạo booking mới.
     */
    public function createBooking($data)
    {
        return $this->insert($data);
    }

    
    public function getBookingStatus($id)
    {
        $sql = "SELECT status FROM {$this->table} WHERE id = :id";
        
        
        $result = $this->queryOne($sql, ['id' => $id]);
        
        // Truy cập trực tiếp vào khóa 'status' của mảng kết quả
        return $result['status'] ?? null;
    }

    
    public function insertHistory($historyData)
    {
        // Giả định BaseModel có hàm insert($data, $tableName)
        return $this->insert($historyData, $this->historyTable);
    }

    
    public function updateStatus($id, $newStatus)
    {
        // 1. Lấy trạng thái CŨ
        $oldStatus = $this->getBookingStatus($id);

        if ($oldStatus === $newStatus) {
            // Không làm gì nếu trạng thái không đổi
            return true; 
        }

        // Bắt đầu Transaction nếu BaseModel hỗ trợ: $this->begin_transaction(); 

        // 2. Cập nhật trạng thái MỚI vào bảng bookings
        $updateSql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $updateResult = $this->query($updateSql, [
            'status' => $newStatus,
            'id' => $id
        ]);
        
        if ($updateResult) {
            // 3. Lưu bản ghi lịch sử
            $historyData = [
                'booking_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_at' => date('Y-m-d H:i:s')
            ];
            
            $historyResult = $this->insertHistory($historyData);

            // Nếu sử dụng Transaction, cần: if ($historyResult) { $this->commit(); } else { $this->rollback(); }
            return $historyResult;
        }
        return false; 
    }


    public function history($bookingId)
    {
        $sql = "
            SELECT 
                old_status, 
                new_status, 
                changed_at 
            FROM {$this->historyTable} 
            WHERE booking_id = :id 
            ORDER BY changed_at DESC
        ";
        // Giả định queryAll trả về mảng các mảng
        return $this->queryAll($sql, ['id' => $bookingId]);
    }
}