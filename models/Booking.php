<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table = 'bookings';
    protected $staffTable = 'staff';
    protected $supplierTable = 'suppliers';
    protected $historyTable = 'booking_history';
    protected $tourTable = 'tours'; // ⭐ Thêm bảng tour

    /**
     * Lấy danh sách booking + join staff + supplier
     */
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
     * Lấy tất cả nhân viên
     */
    public function getAllStaff()
    {
        $sql = "SELECT id, name FROM {$this->staffTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    /**
     * Lấy tất cả nhà cung cấp
     */
    public function getAllSuppliers()
    {
        $sql = "SELECT id, name FROM {$this->supplierTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    /**
     * ⭐ Lấy tất cả tour từ bảng tour
     */
    public function getAllTours()
    {
        $sql = "SELECT id, name FROM {$this->tourTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    /**
     * Tạo booking mới
     */
    public function createBooking($data)
    {
        return $this->insert($data);
    }

    /**
     * Lấy trạng thái hiện tại của booking
     */
    public function getBookingStatus($id)
    {
        $sql = "SELECT status FROM {$this->table} WHERE id = :id";
        $result = $this->queryOne($sql, ['id' => $id]);
        return $result['status'] ?? null;
    }

    /**
     * Thêm lịch sử thay đổi trạng thái
     */
    public function insertHistory($historyData)
    {
        return $this->insert($historyData, $this->historyTable);
    }

    /**
     * Cập nhật trạng thái + lưu lịch sử
     */
    public function updateStatus($id, $newStatus)
    {
        $oldStatus = $this->getBookingStatus($id);

        if ($oldStatus === $newStatus) {
            return true; // Không đổi trạng thái thì không cần lưu
        }

        // 1. Cập nhật bảng bookings
        $updateSql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $updateResult = $this->query($updateSql, [
            'status' => $newStatus,
            'id' => $id
        ]);

        if ($updateResult) {
            // 2. Lưu lịch sử
            $historyData = [
                'booking_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_at' => date('Y-m-d H:i:s')
            ];

            return $this->insertHistory($historyData);
        }

        return false;
    }

    /**
     * Lịch sử trạng thái booking
     */
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

        return $this->queryAll($sql, ['id' => $bookingId]);
    }
}
