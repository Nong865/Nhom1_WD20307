<?php
class Tour {
    private $conn;
    private $table = 'tours';

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

    public function getAll() {
        $sql = "SELECT t.*, s.name AS staff_name, sup.name AS supplier_name
                FROM {$this->table} t
                LEFT JOIN staff s ON t.staff_id = s.id
                LEFT JOIN suppliers sup ON t.supplier_id = sup.id
                ORDER BY t.id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $sql = "INSERT INTO {$this->table} 
                (name, price, description, start_date, end_date, staff_id, supplier_id, main_image)
                VALUES (:name, :price, :description, :start_date, :end_date, :staff_id, :supplier_id, :main_image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $this->name,
            ':price' => $this->price,
            ':description' => $this->description,
            ':start_date' => $this->start_date,
            ':end_date' => $this->end_date,
            ':staff_id' => $this->staff_id,
            ':supplier_id' => $this->supplier_id,
            ':main_image' => $this->main_image
        ]);
    }
}
?>
