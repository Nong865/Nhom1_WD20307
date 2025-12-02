<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table = 'bookings';
    
    // THAY ĐỔI: Đổi tên bảng staff thành bảng huong_dan_vien
    protected $huongDanVienTable = 'huong_dan_vien';
    
    protected $partnerTable = 'partners';
    protected $historyTable = 'booking_history';
    protected $tourTable = 'tours';
    protected $bookingPartnerTable = 'booking_partners';

    /**
     * Lấy tất cả booking kèm thông tin Hướng dẫn viên + Partner
     */
    public function getAll()
    {
        // Giả sử trong bảng 'bookings' bạn đã đổi cột 'staff_id' thành 'huong_dan_vien_id'
        // Nếu chưa đổi tên cột trong database, hãy sửa câu SQL dưới đây hoặc đổi lại logic
        $bookings = $this->queryAll("SELECT * FROM {$this->table} ORDER BY booking_date DESC");

        foreach ($bookings as &$booking) {
            // THAY ĐỔI: Lấy ho_ten và chung_chi từ bảng huong_dan_vien
            // Lưu ý: check xem cột khóa ngoại trong bảng bookings là 'huong_dan_vien_id' hay vẫn là 'staff_id'
            // Ở đây mình để là 'huong_dan_vien_id' cho đồng bộ với Controller
            $hdvId = $booking['huong_dan_vien_id'] ?? $booking['staff_id'] ?? null;

            if ($hdvId) {
                $sqlHdv = "SELECT ho_ten, chung_chi FROM {$this->huongDanVienTable} WHERE id = :id";
                $hdv = $this->queryOne($sqlHdv, ['id' => $hdvId]);
                
                $booking['hdv_ho_ten']    = $hdv['ho_ten'] ?? 'Chưa phân công';
                $booking['hdv_chung_chi'] = $hdv['chung_chi'] ?? '';
            } else {
                $booking['hdv_ho_ten']    = 'Chưa phân công';
                $booking['hdv_chung_chi'] = '';
            }

            // Lấy thông tin partners
            $partners = $this->getPartnersByBooking($booking['id']);
            $booking['partners'] = $partners;
        }

        return $bookings;
    }

    public function getPartnersByBooking($bookingId)
    {
        $sql = "
            SELECT p.id, p.name
            FROM {$this->partnerTable} p
            INNER JOIN {$this->bookingPartnerTable} bp ON bp.partner_id = p.id
            WHERE bp.booking_id = :booking_id
        ";
        return $this->queryAll($sql, ['booking_id' => $bookingId]);
    }

    // THAY ĐỔI: Hàm lấy danh sách Hướng dẫn viên (Tên + Chứng chỉ)
    // Hàm này được gọi ở BookingController -> create()
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

    /**
     * Lấy danh sách tour, kèm giá
     */
    public function getAllTours()
    {
        $sql = "SELECT id, name, price FROM {$this->tourTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    /**
     * Lấy tour theo tên (để tính tổng tiền)
     */
    public function getTourByName($name)
    {
        $sql = "SELECT id, name, price FROM {$this->tourTable} WHERE name = :name LIMIT 1";
        return $this->queryOne($sql, ['name' => $name]);
    }

    public function createBooking($data, $partnerIds = [])
    {
        // $data bây giờ sẽ chứa key 'huong_dan_vien_id' từ Controller gửi sang
        $bookingId = $this->insert($data);

        if ($bookingId && !empty($partnerIds)) {
            foreach ($partnerIds as $partnerId) {
                $this->insert([
                    'booking_id' => $bookingId,
                    'partner_id' => $partnerId
                ], $this->bookingPartnerTable);
            }
        }

        return $bookingId;
    }

    public function getBookingStatus($id)
    {
        $sql = "SELECT status FROM {$this->table} WHERE id = :id";
        $result = $this->queryOne($sql, ['id' => $id]);
        return $result['status'] ?? null;
    }

    public function insertHistory($historyData)
    {
        return $this->insert($historyData, $this->historyTable);
    }

    public function updateStatus($id, $newStatus)
    {
        $oldStatus = $this->getBookingStatus($id);

        if ($oldStatus === $newStatus) return true;

        $updateSql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $updateResult = $this->query($updateSql, ['status' => $newStatus, 'id' => $id]);

        if ($updateResult) {
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
}