<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table = 'bookings';

    // Lấy tất cả booking
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY booking_date DESC";
        return $this->queryAll($sql);
    }

    // Tạo booking mới (cả khách lẻ và đoàn)
    public function createBooking($data)
    {
        // $data phải có: customer_name, customer_phone, quantity, tour_name, tour_date, special_request, status, type, booking_date
        return $this->insert($data);
    }

    // Cập nhật trạng thái booking
    public function updateStatus($id, $new_status)
    {
        // Lấy trạng thái cũ
        $sql = "SELECT status FROM {$this->table} WHERE id = ?";
        $old_status = $this->query($sql, [$id])->fetchColumn();

        if ($old_status !== $new_status) {

            // Lưu lịch sử
            $historySQL = "
                INSERT INTO booking_status_history (booking_id, old_status, new_status)
                VALUES (?, ?, ?)
            ";
            $this->insertRaw($historySQL, [$id, $old_status, $new_status]);

            // Cập nhật trạng thái mới
            $this->update($id, ['status' => $new_status]);
        }
    }

    // Lấy lịch sử trạng thái của booking
    public function getStatusHistory($booking_id)
    {
        $sql = "SELECT * FROM booking_status_history
                WHERE booking_id = ?
                ORDER BY changed_at DESC";

        return $this->queryAll($sql, [$booking_id]);
    }
}
