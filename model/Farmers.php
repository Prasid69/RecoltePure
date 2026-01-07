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

    public function getAllFarmers() {
        $sql = "SELECT farmer_id, name, address, email, phone_number, certificate_number, registration_date , account_status
                FROM farmer"; 
        
        $result = $this->db->query($sql);
        
        $farmers = [];
        if ($result) {
            $farmers = $result->fetch_all(MYSQLI_ASSOC);
        }
        foreach ($farmers as &$singleFarmer) {
            $singleFarmer['products'] = $this->getFarmerProducts($singleFarmer['farmer_id']);
        }
        
        return $farmers;
    }

    private function getFarmerProducts($farmerId) {
        $sql = "SELECT product_name, image, price 
                FROM products 
                WHERE farmer_id = ? 
                LIMIT 3"; 
                
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $farmerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>