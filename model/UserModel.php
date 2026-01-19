<?php

class UserModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function emailExists($email, $role) {
        $table = ($role === 'farmer') ? 'farmer' : 'users';
        $idField = ($role === 'farmer') ? 'farmer_id' : 'customer_id';

        $query = "SELECT $idField FROM $table WHERE email = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }

    public function registerFarmer($fullName, $email, $phone, $address, $certNumber, $passwordHash) {
        $stmt = $this->db->prepare("INSERT INTO farmer (name, email, phone_number, address, certificate_number, password_hash) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullName, $email, $phone, $address, $certNumber, $passwordHash);
        
        if ($stmt->execute()) {
            return $stmt->insert_id; 
        }
        return false;
    }

    public function registerUser($fullName, $email, $address, $passwordHash) {
        // Note: New users won't have a phone number yet.
        $stmt = $this->db->prepare("INSERT INTO users (name, email, address, password, registration_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $fullName, $email, $address, $passwordHash);
        
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }

    public function getUserById($id, $role) {
        if ($role === 'farmer') {
            $table = 'farmer';
            // Assuming table is 'farmer'
            $sql = "SELECT farmer_id, name AS first_name, email, phone_number, address, certificate_number FROM farmer WHERE farmer_id = ?";
        } else {
            $table = 'users'; 
            // Assuming table is 'users'
            $sql = "SELECT name AS first_name, email, address, phone_number FROM users WHERE customer_id = ?";
        }

        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }

        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }

    public function updateUser($userId, $name, $email, $phone, $address) {
        // FIXED: Using 'customer_id' and 'users' table based on your code
        $sql = "UPDATE users SET name = ?, email = ?, phone_number = ?, address = ? WHERE customer_id = ?";
    
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("SQL Prepare Error (User): " . $this->db->error);
        }

        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $userId);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Execution Error (User): " . $stmt->error);
        }
    }

    // FIXED: Moved this INSIDE the class and fixed the SQL/Binding
    public function updateFarmer($id, $name, $email, $phone, $address, $certNumber) {
        // FIXED: Changed table from 'users' to 'farmer'
        $sql = "UPDATE farmer SET name = ?, email = ?, phone_number = ?, address = ?, certificate_number = ? WHERE farmer_id = ?";
        
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
             die("SQL Prepare Error (Farmer): " . $this->db->error);
        }

        // FIXED: Use bind_param instead of execute([])
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $certNumber, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Execution Error (Farmer): " . $stmt->error);
        }
    }

    public function login($email, $password, $role) {
    // 1. Set Table and ID Column
    if ($role === 'farmer') {
        $table = 'farmer';
        $idColumn = 'farmer_id';
        $passColumn = 'password'; // Farmer uses 'password'
    } elseif ($role === 'admin') {
        $table = 'admins';         
        $idColumn = 'id';         
        $passColumn = 'password_hash'; 
    } else {
        $table = 'users';
        $idColumn = 'customer_id';
        $passColumn = 'password'; 
    }

   
    $sql = "SELECT $idColumn, name, $passColumn FROM $table WHERE email = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
    
        if (password_verify($password, $row[$passColumn])) {
            return [
                'id' => $row[$idColumn], 
                'name' => $row['name']
            ];
        }
    }
    return false;
    }
}
?>