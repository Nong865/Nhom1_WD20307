<?php
require_once "BaseModel.php";

class Booking extends BaseModel
{
    protected $table                = 'bookings';
    protected $huongDanVienTable    = 'huong_dan_vien';
    protected $partnerTable         = 'partners';
    protected $historyTable         = 'booking_history';
    protected $tourTable            = 'tours';
    protected $bookingPartnerTable  = 'booking_partners';
    protected $groupMembersTable    = 'booking_group_members';

    // Danh sách trạng thái hợp lệ (khớp chính xác enum trong DB)
    private const VALID_STATUSES = [
        'Chờ xác nhận',
        'Đã xác nhận',
        'Đã cọc',
        'Hoàn thành',
        'Đã hủy'
    ];

    // ======================================================================
    // 1. READ: LIST & DETAIL
    // ======================================================================

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

        foreach ($bookings as &$b) {
            $b['partners']      = $this->getPartnersByBooking($b['id']);
            $b['hdv_ho_ten']    = $b['hdv_ho_ten'] ?? 'Chưa phân công';
            $b['hdv_chung_chi'] = $b['hdv_chung_chi'] ?? '';

            if (($b['type'] ?? 'individual') === 'group') {
                $b['group_members'] = $this->getGroupMembersByBooking($b['id']);
            }
        }
        return $bookings;
    }

    public function getById($id)
    {
        $sql = "SELECT 
                    b.*, 
                    h.ho_ten AS hdv_ho_ten,
                    t.price AS price_per_person
                FROM {$this->table} b
                LEFT JOIN {$this->huongDanVienTable} h ON b.huong_dan_vien_id = h.id
                LEFT JOIN {$this->tourTable} t ON b.tour_name = t.name 
                WHERE b.id = :id";

        $booking = $this->queryOne($sql, ['id' => $id]);

        if ($booking) {
            $booking['partners'] = $this->getPartnersByBooking($booking['id']);
            if (($booking['type'] ?? 'individual') === 'group') {
                $booking['group_members'] = $this->getGroupMembersByBooking($booking['id']);
            }
        }
        return $booking ?: false;
    }

    public function history($bookingId)
    {
        $sql = "SELECT old_status, new_status, changed_at 
                FROM {$this->historyTable} 
                WHERE booking_id = :id 
                ORDER BY changed_at DESC";
        return $this->queryAll($sql, ['id' => $bookingId]);
    }

    public function getGroupMembersByBooking($bookingId)
    {
        $sql = "SELECT name FROM {$this->groupMembersTable} WHERE booking_id = :booking_id ORDER BY id ASC";
        $rows = $this->queryAll($sql, ['booking_id' => $bookingId]);
        return array_column($rows, 'name');
    }

    // ======================================================================
    // 2. HELPER
    // ======================================================================

    public function getPartnersByBooking($bookingId)
    {
        $sql = "SELECT p.id, p.name 
                FROM {$this->partnerTable} p
                INNER JOIN {$this->bookingPartnerTable} bp ON bp.partner_id = p.id
                WHERE bp.booking_id = :booking_id";
        return $this->queryAll($sql, ['booking_id' => $bookingId]);
    }

    public function getAllHuongDanVien()   { return $this->queryAll("SELECT id, ho_ten, chung_chi FROM {$this->huongDanVienTable} ORDER BY ho_ten"); }
    public function getAllPartners()       { return $this->queryAll("SELECT id, name FROM {$this->partnerTable} ORDER BY name"); }
    public function getAllTours()          { return $this->queryAll("SELECT id, name, price FROM {$this->tourTable} ORDER BY name"); }

    public function getTourByName($name)
    {
        return $this->queryOne("SELECT id, name, price FROM {$this->tourTable} WHERE name = :name LIMIT 1", ['name' => $name]);
    }

    public function getBookingStatus($id)
    {
        $row = $this->queryOne("SELECT status FROM {$this->table} WHERE id = :id", ['id' => $id]);
        return $row['status'] ?? null;
    }

    // ======================================================================
    // 3. CREATE
    // ======================================================================

    public function createBooking($data, $partnerIds = [])
    {
        try {
            $this->pdo->beginTransaction();

            $bookingData = [
                'customer_name'     => $data['customer_name'],
                'customer_phone'    => $data['customer_phone'],
                'type'              => $data['type'] ?? 'individual',
                'quantity'          => (int)$data['quantity'],
                'tour_name'         => $data['tour_name'],
                'tour_date'         => $data['tour_date'],
                'special_request'   => $data['special_request'] ?? '',
                'total_price'       => $data['total_price'],
                'huong_dan_vien_id' => $data['huong_dan_vien_id'] ?? null,
                'status'            => 'Chờ xác nhận',  // KHỚP ENUM DB
                'booking_date'      => date('Y-m-d H:i:s')
            ];

            $bookingId = $this->insert($bookingData, $this->table);
            if (!$bookingId) throw new Exception("Insert booking failed");

            // Partners
            foreach ((array)$partnerIds as $pid) {
                $this->insert(['booking_id' => $bookingId, 'partner_id' => (int)$pid], $this->bookingPartnerTable);
            }

            // Group members (nếu đoàn)
            if (($data['type'] ?? 'individual') === 'group' && !empty($data['group_members'])) {
                foreach ((array)$data['group_members'] as $name) {
                    $name = trim($name);
                    if ($name !== '') {
                        $this->insert(['booking_id' => $bookingId, 'name' => $name], $this->groupMembersTable);
                    }
                }
            }

            $this->pdo->commit();
            return $bookingId;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("CREATE BOOKING ERROR: " . $e->getMessage() . " | Data: " . print_r($data, true));
            return false;
        }
    }

    // ======================================================================
    // 4. UPDATE
    // ======================================================================

    public function updateBooking($id, $data)
    {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE {$this->table} SET 
                        customer_name     = :customer_name,
                        customer_phone    = :customer_phone,
                        type              = :type,
                        quantity          = :quantity,
                        tour_name         = :tour_name,
                        tour_date         = :tour_date,
                        special_request   = :special_request,
                        huong_dan_vien_id = :huong_dan_vien_id,
                        total_price       = :total_price,
                        status            = :status
                    WHERE id = :id";

            $params = [
                'customer_name'     => $data['customer_name'],
                'customer_phone'    => $data['customer_phone'],
                'type'              => $data['type'] ?? 'individual',
                'quantity'          => (int)$data['quantity'],
                'tour_name'         => $data['tour_name'],
                'tour_date'         => $data['tour_date'],
                'special_request'   => $data['special_request'] ?? '',
                'huong_dan_vien_id' => $data['huong_dan_vien_id'] ?? null,
                'total_price'       => $data['total_price'],
                'status'            => in_array($data['status'] ?? '', self::VALID_STATUSES) 
                                        ? $data['status'] 
                                        : 'Chờ xác nhận',
                'id'                => $id
            ];

            if (!$this->queryExecute($sql, $params)) {
                throw new Exception("Update main booking failed");
            }

            // Cập nhật partners (xóa cũ → thêm mới)
            $this->deletePartnersByBooking($id);
            foreach ((array)($data['partner_ids'] ?? []) as $pid) {
                $this->insert(['booking_id' => $id, 'partner_id' => (int)$pid], $this->bookingPartnerTable);
            }

            // Cập nhật group members
            $this->deleteGroupMembersByBooking($id);
            if (($data['type'] ?? 'individual') === 'group' && !empty($data['group_members'])) {
                foreach ((array)$data['group_members'] as $name) {
                    $name = trim($name);
                    if ($name !== '') {
                        $this->insert(['booking_id' => $id, 'name' => $name], $this->groupMembersTable);
                    }
                }
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("UPDATE BOOKING ERROR (ID $id): " . $e->getMessage());
            return false;
        }
    }

    // ======================================================================
    // 5. STATUS + HISTORY
    // ======================================================================

    public function insertHistory($data)
    {
        $insert = [
            'booking_id' => $data['booking_id'],
            'old_status' => $data['old_status'],
            'new_status' => $data['new_status'],
            'changed_at' => $data['changed_at'] ?? date('Y-m-d H:i:s')
        ];
        return $this->insert($insert, $this->historyTable);
    }

    public function updateStatus($id, $newStatus)
    {
        if (!in_array($newStatus, self::VALID_STATUSES)) return false;

        $oldStatus = $this->getBookingStatus($id);
        if ($oldStatus === null || $oldStatus === $newStatus) return false;

        try {
            $this->pdo->beginTransaction();

            $this->queryExecute("UPDATE {$this->table} SET status = :status WHERE id = :id", [
                'status' => $newStatus,
                'id'     => $id
            ]);

            $this->insertHistory([
                'booking_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("UPDATE STATUS ERROR: " . $e->getMessage());
            return false;
        }
    }

    // ======================================================================
    // 6. DELETE
    // ======================================================================

    public function deleteBooking($id)
    {
        try {
            $this->pdo->beginTransaction();

            $this->deleteGroupMembersByBooking($id);
            $this->deletePartnersByBooking($id);
            $this->queryExecute("DELETE FROM {$this->historyTable} WHERE booking_id = ?", [$id]);
            $this->queryExecute("DELETE FROM {$this->table} WHERE id = ?", [$id]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("DELETE BOOKING ERROR (ID $id): " . $e->getMessage());
            return false;
        }
    }

    // Helper xóa nhanh
    private function deletePartnersByBooking($id) {
        $this->queryExecute("DELETE FROM {$this->bookingPartnerTable} WHERE booking_id = :id", ['id' => $id]);
    }

    private function deleteGroupMembersByBooking($id) {
        $this->queryExecute("DELETE FROM {$this->groupMembersTable} WHERE booking_id = :id", ['id' => $id]);
    }
}