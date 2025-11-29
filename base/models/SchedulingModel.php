<?php
require_once "BaseModel.php";

class SchedulingModel extends BaseModel
{
    protected $table = "schedules";

    /* ===============================================
        LẤY DANH SÁCH LỊCH – KÈM NHÂN SỰ + DỊCH VỤ
    ================================================ */
    public function getScheduleList()
    {
        $sql = "
            SELECT s.*, t.name AS tour_name 
            FROM schedules s
            JOIN tours t ON s.tour_id = t.id
            ORDER BY s.start_datetime DESC
        ";

        $schedules = $this->queryAll($sql);

        // GẮN NHÂN SỰ + DỊCH VỤ VÀO TỪNG LỊCH
        foreach ($schedules as &$s) {
            $s['staff'] = $this->getStaffBySchedule($s['id']);
            $s['services'] = $this->getServicesBySchedule($s['id']);
        }

        return $schedules;
    }

    /* ===============================================
        THÊM LỊCH
    ================================================ */
    public function insertSchedule($data)
    {
        return $this->insert($data);
    }

    /* ===============================================
        LẤY 1 LỊCH THEO ID
    ================================================ */
    public function getSchedule($id)
    {
        $sql = "
            SELECT s.*, t.name AS tour_name
            FROM schedules s
            JOIN tours t ON s.tour_id = t.id
            WHERE s.id = ?
        ";
        return $this->queryOne($sql, [$id]);
    }

    /* ===============================================
        DANH SÁCH TOUR / NHÂN SỰ / ĐỐI TÁC
    ================================================ */
    public function getTourList()
    {
        return $this->queryAll("SELECT id, name FROM tours");
    }

    public function getStaffList()
    {
        return $this->queryAll("SELECT id, name FROM staff");
    }

    public function getPartners()
{
    return $this->queryAll("SELECT id, name, service_type FROM partners");
}


    /* ===============================================
        PHÂN CÔNG NHÂN SỰ
    ================================================ */
    public function assignStaff($schedule_id, $staff_id, $role)
    {
        $sql = "INSERT INTO schedule_staff (schedule_id, staff_id, role) VALUES (?, ?, ?)";
        return $this->insertRaw($sql, [$schedule_id, $staff_id, $role]);
    }

    /* ===============================================
        PHÂN BỔ DỊCH VỤ
    ================================================ */
    public function assignService($schedule_id, $partner_id, $type, $qty)
    {
        $sql = "
            INSERT INTO schedule_services (schedule_id, partner_id, service_type, qty)
            VALUES (?, ?, ?, ?)
        ";
        return $this->insertRaw($sql, [$schedule_id, $partner_id, $type, $qty]);
    }

    /* ===============================================
        LẤY NHÂN SỰ CỦA LỊCH
    ================================================ */
    public function getStaffBySchedule($schedule_id)
    {
        $sql = "
            SELECT ss.*, st.name, ss.role
            FROM schedule_staff ss
            JOIN staff st ON ss.staff_id = st.id
            WHERE ss.schedule_id = ?
        ";
        return $this->queryAll($sql, [$schedule_id]);
    }

    /* ===============================================
        LẤY DỊCH VỤ CỦA LỊCH
    ================================================ */
    public function getServicesBySchedule($schedule_id)
    {
        $sql = "
            SELECT ss.*, p.name AS partner_name
            FROM schedule_services ss
            JOIN partners p ON p.id = ss.partner_id
            WHERE ss.schedule_id = ?
        ";
        return $this->queryAll($sql, [$schedule_id]);
    }
}
