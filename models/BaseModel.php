<?php

class BaseModel
{
    protected $table;
    protected $key = 'id';
    protected $pdo;

    public function __construct()
    {
        // Giả định các hằng số DB_HOST, DB_PORT, DB_NAME, DB_USERNAME, DB_PASSWORD, DB_OPTIONS đã được định nghĩa
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8',
            DB_HOST,
            DB_PORT,
            DB_NAME
        );

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }

 

    public function queryAll($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
   
    public function queryOne($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Chỉ lấy MỘT hàng
    }


    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        // Hàm này thường được dùng cho UPDATE/DELETE/CREATE TABLE hoặc trả về PDOStatement cho các mục đích nâng cao.
        return $stmt->rowCount(); // Trả về số lượng hàng bị ảnh hưởng (tốt hơn là trả về PDOStatement)
    }
    
    // Ghi chú: Nếu bạn cần $this->query() trả về PDOStatement, hãy thay đổi return trên thành: return $stmt;

    public function insertRaw($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }

    /* ============================================================
        CRUD CHÍNH
    ============================================================ */

    // Lấy toàn bộ dữ liệu
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->queryAll($sql);
    }

    // Lấy 1 bản ghi theo ID (Dùng hàm find() này thay vì queryOne cho CRUD cơ bản)
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->key} = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function insert($data, $tableName = null)
    {
        $targetTable = $tableName ?? $this->table; 
        
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

    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->key} = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
    
    public function getAllByGroup($groupId)
    {
        $sql = "
            SELECT h.*, GROUP_CONCAT(n.ten_nhom SEPARATOR ', ') AS nhom
            FROM huong_dan_vien h
            INNER JOIN hdv_nhom hn ON h.id = hn.hdv_id
            INNER JOIN nhom_hdv n ON hn.nhom_id = n.id
            WHERE n.id = ?
            GROUP BY h.id
            ORDER BY h.id DESC
        ";
        return $this->queryAll($sql, [$groupId]);
    }
}