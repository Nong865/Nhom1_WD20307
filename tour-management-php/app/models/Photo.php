<?php
class Photo {
    private $conn;
    private $table = 'photos';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPhotosByTourId($tour_id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE tour_id = :tour_id ORDER BY id ASC");
        $stmt->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>