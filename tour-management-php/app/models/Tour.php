<?php
class Tour {
    private $conn;
    private $table = 'tours';

    public $id;
    public $name;
    public $price;
    public $description;
    public $start_date;
    public $end_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $sql = "INSERT INTO {$this->table} (name, price, description, start_date, end_date) VALUES (:name, :price, :description, :start_date, :end_date)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        return $stmt->execute();
    }
}
?>