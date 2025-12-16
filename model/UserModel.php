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
        // Note: New users won't have a phone number yet. That's fine, they can add it in Edit Profile.
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
            $idColumn = 'farmer_id';
            $sql = "SELECT farmer_id, name AS first_name, email, phone_number, address, certificate_number FROM farmer WHERE farmer_id = ?";
        } else {
            $table = 'users';
            $idColumn = 'customer_id'; 
            
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

    public function updateFarmer($id, $name, $email, $phone, $address, $certNumber) {
        $sql = "UPDATE farmer SET name=?, email=?, phone_number=?, address=?, certificate_number=? WHERE farmer_id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $certNumber, $id);
        return $stmt->execute();
    }

    public function updateUser($id, $name, $email, $address, $phone) {
        $sql = "UPDATE users SET name=?, email=?, address=?, phone_number=? WHERE customer_id=?";
        $stmt = $this->db->prepare($sql);
        
        // Bind matches the SQL order: Name, Email, Address, Phone, ID
        $stmt->bind_param("ssssi", $name, $email, $address, $phone, $id);
        
        return $stmt->execute();
    }



    public function login($email, $password, $role) {
        $table = ($role === 'farmer') ? 'farmer' : 'users';
        $idColumn = ($role === 'farmer') ? 'farmer_id' : 'customer_id';

        $sql = "SELECT $idColumn, name, password FROM $table WHERE email = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                return [
                    'id' => $row[$idColumn], // Returns the ID
                    'name' => $row['name']
                ];
            }
        }
        return false;
    }
}
?>