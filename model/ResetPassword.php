<?php


class ResetPasswordModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function updatePassword($email, $newPasswordHash) {
 
        $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE email = ?');
        $stmt->bind_param('ss', $newPasswordHash, $email);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            return true;
        }
        $stmt = $this->db->prepare('UPDATE farmer SET password = ? WHERE email = ?');
        $stmt->bind_param('ss', $newPasswordHash, $email);
        $stmt->execute();

        return ($stmt->affected_rows > 0);
    }
}
?>