<?php
require_once "BaseModel.php";

class User extends BaseModel {

    protected $table = "users";

   public function findByUsername($username) {
    return $this->query("SELECT * FROM users WHERE username = ?", [$username])->fetch();
}


    public function getAll() {
        $sql = "SELECT u.*, r.name AS role_name
                FROM users u
                JOIN roles r ON u.role_id = r.id";
        return $this->query($sql)->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO users(username, full_name, email, password, role_id, created_at)
                VALUES(?,?,?,?,?,NOW())";
        return $this->query($sql, [
            $data['username'],
            $data['full_name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['role_id']
        ]);
    }
}
