<?php

class RecoveryModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function emailExists($email) {
    
        $stmt = $this->db->prepare('SELECT 1 FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return true;
        }

 
        $stmt = $this->db->prepare('SELECT 1 FROM farmer WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return true;
        }

        return false;
    }
}
?>