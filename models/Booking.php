<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table = 'bookings';
    protected $staffTable = 'staff'; // Tên bảng nhân sự
    protected $supplierTable = 'suppliers'; // Tên bảng nhà cung cấp

    // ... (Giữ nguyên các thuộc tính khác)

    /**
     * Lấy tất cả booking, join với staff và suppliers để lấy tên.
     * Giả định: bảng bookings có cột staff_id và supplier_id.
     * Giả định: bảng staff và suppliers có cột name.
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

    // Tạo booking mới (Giữ nguyên hoặc thêm staff_id, supplier_id vào $data)
    public function createBooking($data)
    {
        // $data phải có: customer_name, ..., booking_date, (có thể thêm staff_id, supplier_id)
        return $this->insert($data);
    }

    // ... (Giữ nguyên updateStatus và getStatusHistory)
}