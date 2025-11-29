<?php
require_once __DIR__ . '/BaseModel.php';

class TourCustomer extends BaseModel
{
    // tên bảng trong database
    protected $table = 'tour_customers';

    // khóa chính
    protected $key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lấy danh sách khách theo tour
     */
    public function getByTour($tour_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tour_id = ?";
        return $this->queryAll($sql, [$tour_id]);
    }

    /**
     * Cập nhật trạng thái check-in
     * arrived | not_arrived | absent
     */
    public function updateCheckin($id, $status)
    {
        $sql = "UPDATE {$this->table} SET checkin_status = ? WHERE {$this->key} = ?";
        return $this->query($sql, [$status, $id]);
    }

    /**
     * Cập nhật phòng khách sạn
     */
    public function updateRoom($id, $room_id)
    {
        $sql = "UPDATE {$this->table} SET room_id = ? WHERE {$this->key} = ?";
        return $this->query($sql, [$room_id, $id]);
    }

    /**
     * Lấy chi tiết 1 khách
     */
    public function getOne($id)
    {
        return $this->find($id); // dùng BaseModel::find()
    }
    public function getTourInfo($tour_id) {
    $sql = "SELECT * FROM tours WHERE id = ?";
    return $this->queryOne($sql, [$tour_id]);
}
// Thêm khách vào đoàn
public function addCustomer($data)
{
    return $this->insert($data);
}

// Sửa thông tin khách
public function updateCustomer($id, $data)
{
    return $this->update($id, $data);
}

// Xóa khách
public function deleteCustomer($id)
{
    return $this->delete($id);
}

// Lấy từng khách (để sửa)
public function findCustomer($id)
{
    return $this->find($id);
}


}
