<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table = 'bookings';
    protected $staffTable = 'staff';
    protected $partnerTable = 'partners';       // bảng partner
    protected $historyTable = 'booking_history';
    protected $tourTable = 'tours';
    protected $bookingPartnerTable = 'booking_partners'; // bảng trung gian booking-partner

    /**
     * Lấy tất cả booking kèm staff + partner (nhiều partner)
     */
    public function getAll()
    {
        // Lấy tất cả booking
        $bookings = $this->queryAll("SELECT * FROM {$this->table} ORDER BY booking_date DESC");

        // Gắn staff và partner cho từng booking
        foreach ($bookings as &$booking) {
            // Staff
            $staff = $this->queryOne("SELECT name FROM {$this->staffTable} WHERE id = :id", ['id' => $booking['staff_id']]);
            $booking['staff_name'] = $staff['name'] ?? null;

            // Partners
            $partners = $this->getPartnersByBooking($booking['id']);
            $booking['partners'] = $partners; // trả về mảng partner
        }

        return $bookings;
    }

    /**
     * Lấy danh sách partner của 1 booking
     */
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

    /**
     * Lấy danh sách nhân viên
     */
    public function getAllStaff()
    {
        $sql = "SELECT id, name FROM {$this->staffTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    /**
     * Lấy danh sách partner
     */
    public function getAllPartners()
    {
        $sql = "SELECT id, name FROM {$this->partnerTable} ORDER BY name ASC";  
        return $this->queryAll($sql);
    }

    /**
     * Lấy danh sách tour
     */
    public function getAllTours()
    {
        $sql = "SELECT id, name FROM {$this->tourTable} ORDER BY name ASC";
        return $this->queryAll($sql);
    }

    /**
     * Tạo booking mới (có thể kèm nhiều partner)
     * $data: mảng dữ liệu booking
     * $partnerIds: mảng id partner
     */
    public function createBooking($data, $partnerIds = [])
    {
        // 1. Insert booking
        $bookingId = $this->insert($data);

        // 2. Gắn partner nếu có
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
     * Thêm lịch sử booking
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

        // Nếu không thay đổi thì bỏ qua
        if ($oldStatus === $newStatus) {
            return true;
        }

        // Cập nhật bảng bookings
        $updateSql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $updateResult = $this->query($updateSql, [
            'status' => $newStatus,
            'id' => $id
        ]);

        if ($updateResult) {
            // Lưu lịch sử trạng thái
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
