<?php
class Farmer {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM farmer WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
