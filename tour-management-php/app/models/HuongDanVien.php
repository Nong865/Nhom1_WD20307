<?php
// XÓA: Dòng này không cần thiết vì Controller sẽ chịu trách nhiệm include Model.
// require_once __DIR__ . '/../models/HuongDanVien.php'; 

// XÓA: Dòng này không cần thiết vì bạn đã truyền đối tượng $db vào construct.
// require_once __DIR__ . "/app/../../config/database.php"; 

class HuongDanVien {
    private $conn;
    private $table = 'huong_dan_vien'; // Đã sửa tên bảng cho khớp với SQL bên dưới

    // 1. CHỈ NHẬN VÀ LƯU KẾT NỐI
    public function __construct($db) {
        // XÓA: Không cần thiết vì bạn đã truyền $db vào.
        // global $conn;
        
        // XÓA: Không cần kiểm tra $conn vì $db đã được kiểm tra ở index.php.
        // if ($conn === null){
        //     die("Lỗi kết nối database");
        // }

        // Gán đối tượng PDO (đã được truyền vào) cho thuộc tính $this->conn
        $this->conn = $db; 

        // XÓA LỖI LỚN: Loại bỏ vòng lặp khởi tạo vô hạn và lỗi Undefined property.
        // $this->hdvModel = new HuongDanVien($this->db);
    }

    /**
     * Lấy tất cả HDV, có thể lọc theo nhóm
     * $groupId: id của nhóm trong bảng nhom_hdv
     */
    public function getAll($groupId = null)
    {
        // Đã sửa tên bảng trong câu lệnh SQL để khớp với $this->table
        if ($groupId === null || $groupId === "") {
            // Lấy tất cả HDV
            $stmt = $this->conn->prepare("SELECT * FROM $this->table ORDER BY id ASC");
            $stmt->execute();
        } else {
            // Lấy HDV theo nhóm (Đã sửa tên bảng huong_dan_vien thành $this->table nếu cần)
            $stmt = $this->conn->prepare("
                SELECT h.*
                FROM $this->table h
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

    // Các hàm còn lại (find, insert, update, delete, getGroupsByHdv, filterByGroup)
    // được giữ nguyên vì chúng đã sử dụng $this->conn đúng cách.
    // ...
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
    
}