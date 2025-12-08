<?php

class BaseModel
{
    protected $table;
    protected $key = 'id';
    protected $pdo;

    public function __construct()
    {
        // Giả sử các hằng số DB đã được định nghĩa
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8',
            DB_HOST,
            DB_PORT,
            DB_NAME
        );

        try {
            // Giả sử các hằng số DB_USERNAME, DB_PASSWORD, DB_OPTIONS đã được định nghĩa
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }

    /* ============================================================
        QUERY CƠ BẢN (EXECUTE, ALL, ONE)
    ============================================================ */

    /**
     * Thực thi SQL (UPDATE, DELETE, INSERT) và trả về kết quả execution (bool)
     */
    public function queryExecute($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params); 
        } catch (PDOException $e) {
            // error_log("Lỗi thực thi SQL: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Thực thi SQL và lấy một bản ghi duy nhất
     */
    public function queryOne($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thực thi SQL và lấy TẤT CẢ các bản ghi
     */
    public function queryAll($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thực thi SQL và trả về đối tượng Statement (dùng cho các truy vấn phức tạp hoặc fetch sau)
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Thực thi SQL và trả về lastInsertId (dùng cho INSERT không an toàn/cũ)
     */
    public function insertRaw($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }

    /* ============================================================
        CRUD CHÍNH & MỞ RỘNG
    ============================================================ */

    // Lấy toàn bộ dữ liệu
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->queryAll($sql);
    }

    // Lấy 1 bản ghi theo ID
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->key} = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm mới bản ghi (hỗ trợ tên bảng tùy chỉnh, cần cho Booking/History)
     */
    public function insert($data, $tableName = null)
    {
        $targetTable = $tableName ?? $this->table; // Chọn tên bảng mặc định hoặc tùy chỉnh
        $fields = array_keys($data);
        $columns = implode(",", $fields);
        $placeholders = implode(",", array_fill(0, count($fields), '?'));

        $sql = "INSERT INTO {$targetTable} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(array_values($data));

        return $this->pdo->lastInsertId();
    }

    // Cập nhật
    public function update($id, $data)
    {
        $setString = implode("=?, ", array_keys($data)) . "=?";
        $sql = "UPDATE {$this->table} SET $setString WHERE {$this->key} = ?";

        $stmt = $this->pdo->prepare($sql);
        $values = array_values($data);
        $values[] = $id;

        return $stmt->execute($values);
    }

    // Xoá
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->key} = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Lấy tất cả Hướng dẫn viên theo nhóm (Hàm bổ sung)
     */
    public function getAllByGroup($groupId)
    {
        $sql = "
            SELECT h.*, GROUP_CONCAT(n.ten_nhom SEPARATOR ', ') AS nhom
            FROM huong_dan_vien h
            INNER JOIN hdv_nhom hn ON h.id = hn.hdv_id
            INNER JOIN nhom_hdv n ON hn.nhom_id = n.id
            WHERE n.id = ?
            GROUP BY h.id, h.ho_ten, h.cccd, h.sdt, h.chung_chi, h.kinh_nghiem, h.luong /* Thêm các cột HDV khác vào GROUP BY */
            ORDER BY h.id DESC
        ";
        return $this->queryAll($sql, [$groupId]);
    }

    // Hủy kết nối
    public function __destruct()
    {
        $this->pdo = null;
    }
}