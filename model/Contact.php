<?php
// models/ContactModel.php

class ContactModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function saveMessage($firstName, $lastName, $email, $phone, $subject, $message) {
        $sql = "INSERT INTO contact_messages (first_name, last_name, email, phone, subject, message, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            // Log error internally if needed
            return false;
        }

        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $subject, $message);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }
}
?>