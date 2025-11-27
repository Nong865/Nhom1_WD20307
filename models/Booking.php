<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table = 'bookings'; // tên bảng chính

    public $id;
    public $customer_id;
    public $tour_name;
    public $booking_date;
    public $status;

    public function __construct()
    {
        parent::__construct(); // quan trọng: khởi tạo PDO
    }

    // Lấy tất cả booking, kèm tên khách hàng
    public function getAll()
    {
        $sql = "SELECT b.*, c.name AS customer_name 
                FROM {$this->table} b
                JOIN customers c ON b.customer_id = c.id
                ORDER BY b.booking_date DESC";
        return $this->queryAll($sql);
    }

    // Tạo booking mới
    public function createBooking($data)
    {
        return $this->insert($data);
    }

    // Cập nhật trạng thái booking và lưu lịch sử
    public function updateStatus($booking_id, $new_status)
    {
        // Lấy trạng thái cũ
        $sql = "SELECT status FROM {$this->table} WHERE id = ?";
        $stmt = $this->query($sql, [$booking_id]);
        $old_status = $stmt->fetchColumn();

        if ($old_status != $new_status) {
            // Cập nhật trạng thái
            $this->update($booking_id, ['status' => $new_status]);

            // Lưu lịch sử thay đổi
            $sqlHistory = "INSERT INTO booking_status_history (booking_id, old_status, new_status) VALUES (?, ?, ?)";
            $this->insertRaw($sqlHistory, [$booking_id, $old_status, $new_status]);
        }
    }

    // Lấy lịch sử thay đổi trạng thái
    public function getStatusHistory($booking_id)
    {
        $sql = "SELECT * FROM booking_status_history WHERE booking_id = ? ORDER BY changed_at DESC";
        return $this->queryAll($sql, [$booking_id]);
    }
}
