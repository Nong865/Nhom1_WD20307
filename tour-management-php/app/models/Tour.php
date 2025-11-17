<?php
class Tour {
    private $conn;
    private $table = 'tours';
    private $staff_table = 'staff';
    private $supplier_table = 'suppliers';

    public $id;
    public $name;
    public $price;
    public $description;
    public $start_date;
    public $end_date;
    public $staff_id;
    public $supplier_id;
    public $main_image;

    public function __construct($db) {
        $this->conn = $db;

        if (!$this->conn) {
            die("Không thể kết nối database trong Tour model");
        }
    }

    // =================================================
    // LẤY TẤT CẢ TOURS
    // =================================================
    public function getAll() {
        $query = "
            SELECT 
                t.*,
                s.name AS staff_name,
                sup.name AS supplier_name
            FROM {$this->table} t
            LEFT JOIN {$this->staff_table} s ON t.staff_id = s.id
            LEFT JOIN {$this->supplier_table} sup ON t.supplier_id = sup.id
            ORDER BY t.id ASC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =================================================
    // LẤY TOUR THEO ID
    // =================================================
    public function getTourById($id) {
        $query = "
            SELECT *
            FROM {$this->table}
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =================================================
    // TẠO TOUR MỚI
    // =================================================
    public function create() {
        $sql = "
            INSERT INTO {$this->table}
                (name, price, description, start_date, end_date, staff_id, supplier_id, main_image)
            VALUES
                (:name, :price, :description, :start_date, :end_date, :staff_id, :supplier_id, :main_image)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        $stmt->bindParam(':staff_id', $this->staff_id);
        $stmt->bindParam(':supplier_id', $this->supplier_id);
        $stmt->bindParam(':main_image', $this->main_image);

        return $stmt->execute();
    }

    // =================================================
    // CẬP NHẬT TOUR
    // =================================================
    public function update() {
        $sql = "
            UPDATE {$this->table}
            SET
                name = :name,
                price = :price,
                description = :description,
                start_date = :start_date,
                end_date = :end_date,
                staff_id = :staff_id,
                supplier_id = :supplier_id,
                main_image = :main_image
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        $stmt->bindParam(':staff_id', $this->staff_id);
        $stmt->bindParam(':supplier_id', $this->supplier_id);
        $stmt->bindParam(':main_image', $this->main_image);

        return $stmt->execute();
    }

    // =================================================
    // XOÁ TOUR
    // =================================================
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>
