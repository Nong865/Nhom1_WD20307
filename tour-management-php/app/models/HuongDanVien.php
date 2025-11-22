<?php
require_once __DIR__ . "/app/../../config/database.php";

class HuongDanVien {

    private $conn;
    private $table = "huong_dan_vien";

    public function __construct() {
        $this->conn = connectDB();
    }

    /**
     * Lấy tất cả HDV, có thể lọc theo nhóm
     * $groupId: id của nhóm trong bảng nhom_hdv
     */
    public function getAll($groupId = null)
    {
        if ($groupId === null || $groupId === "") {
            // Lấy tất cả HDV
            $stmt = $this->conn->prepare("SELECT * FROM $this->table ORDER BY id ASC");
            $stmt->execute();
        } else {
            // Lấy HDV theo nhóm
            $stmt = $this->conn->prepare("
                SELECT h.*
                FROM huong_dan_vien h
                JOIN hdv_nhom hn ON h.id = hn.hdv_id
                JOIN nhom_hdv n ON hn.nhom_id = n.id
                WHERE n.id = ?
                ORDER BY h.id DESC
            ");
            $stmt->execute([$groupId]);
        }

        $hdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Gắn nhóm cho mỗi HDV
        foreach ($hdvs as &$h) {
            $groups = $this->getGroupsByHdv($h['id']);
            $h['groups'] = implode(", ", $groups);
        }

        return $hdvs;
    }

    /**
     * Lấy 1 HDV theo ID
     */
    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm HDV mới
     */
  public function insert($data) {
    $sql = "INSERT INTO huong_dan_vien 
        (ho_ten, ngay_sinh, anh, so_dien_thoai, email, chung_chi, ngon_ngu, nam_kinh_nghiem, lich_su_tour, danh_gia, suc_khoe, ghi_chu)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        $data['ho_ten'],
        $data['ngay_sinh'],
        $data['anh'],
        $data['so_dien_thoai'],
        $data['email'],
        $data['chung_chi'],
        $data['ngon_ngu'],
        $data['nam_kinh_nghiem'],
        $data['lich_su_tour'],
        $data['danh_gia'],
        $data['suc_khoe'],
        $data['ghi_chu']
    ]);
}

    /**
     * Cập nhật HDV
     */
    public function update($id, $data) {
        $sql = "UPDATE $this->table SET 
            ho_ten=?, ngay_sinh=?, anh=?, so_dien_thoai=?, email=?, chung_chi=?, ngon_ngu=?, 
            nam_kinh_nghiem=?, lich_su_tour=?, danh_gia=?, suc_khoe=?, ghi_chu=? 
        WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['ho_ten'],
            $data['ngay_sinh'],
            $data['anh'],
            $data['so_dien_thoai'],
            $data['email'],
            $data['chung_chi'],
            $data['ngon_ngu'],
            $data['nam_kinh_nghiem'],
            $data['lich_su_tour'],
            $data['danh_gia'],
            $data['suc_khoe'],
            $data['ghi_chu'],
            $id
        ]);
    }

    /**
     * Xóa HDV
     */
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id=?");
        return $stmt->execute([$id]);
    }

    /**
     * Lấy nhóm của 1 HDV
     */
    public function getGroupsByHdv($hdv_id) {
        $sql = "
            SELECT nhom_hdv.ten_nhom
            FROM hdv_nhom 
            JOIN nhom_hdv ON hdv_nhom.nhom_id = nhom_hdv.id
            WHERE hdv_nhom.hdv_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$hdv_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Lọc HDV theo nhóm (dùng cho bộ lọc)
     */
    public function filterByGroup($groupId)
    {
        $stmt = $this->conn->prepare("
            SELECT h.*
            FROM huong_dan_vien h
            JOIN hdv_nhom hn ON h.id = hn.hdv_id
            JOIN nhom_hdv n ON hn.nhom_id = n.id
            WHERE n.id = ?
            ORDER BY h.id DESC
        ");
        $stmt->execute([$groupId]);
        $hdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($hdvs as &$h) {
            $groups = $this->getGroupsByHdv($h['id']);
            $h['groups'] = implode(", ", $groups);
        }

        return $hdvs;
    }
}
