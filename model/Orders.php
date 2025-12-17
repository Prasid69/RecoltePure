<?php
class OrderModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getOrdersByCustomerId($customerId) {
    $sql = "SELECT 
                oc.delivery_id AS order_customer_id,  
                oc.delivery_id AS order_delivery_id, 
                MAX(oc.delivery_date) AS order_date,  
                SUM(oc.total_price) AS total_amount,  
                GROUP_CONCAT(p.product_name SEPARATOR ', ') AS product_names,

                COALESCE(d.delivery_status, 'Processing') AS delivery_status
                
            FROM order_or_cart oc
            LEFT JOIN delivery d ON oc.delivery_id = d.delivery_id
            
            LEFT JOIN products p ON oc.product_id = p.product_id
            
            WHERE oc.customer_id = ?
            GROUP BY oc.delivery_id
            ORDER BY oc.delivery_date DESC";

    $stmt = $this->db->prepare($sql);
    
    if (!$stmt) {
        die("Error preparing statement: " . $this->db->error);
    }

    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}



    public function createOrder($userId, $cartItems) {
    $newDeliveryId = time(); 
    $currentDate = date('Y-m-d H:i:s');
    $sqlDelivery = "INSERT INTO delivery (delivery_id, order_id, delivery_date, delivery_status, delivery_partner, tracking_number) 
                    VALUES (?, ?, ?, 'Pending', 'Waiting', 'N/A')";
    
    $stmt = $this->db->prepare($sqlDelivery);
    if (!$stmt) {
        die("Prepare failed (Delivery): " . $this->db->error);
    }
    $stmt->bind_param("iis", $newDeliveryId, $newDeliveryId, $currentDate);
    
    if (!$stmt->execute()) {
        die("Execute failed (Delivery): " . $stmt->error);
    }
    $stmt->close();
    $sqlItem = "INSERT INTO order_or_cart (customer_id, delivery_id, product_id, total_price, delivery_date) 
                VALUES (?, ?, ?, ?, ?)";
    
    $stmtItem = $this->db->prepare($sqlItem);
    if (!$stmtItem) {
        die("Prepare failed (Items): " . $this->db->error);
    }
    $p_userId = $userId;
    $p_deliveryId = $newDeliveryId;
    $p_productId = 0;
    $p_totalPrice = 0.0;
    $p_date = $currentDate;
    $stmtItem->bind_param("iiids", $p_userId, $p_deliveryId, $p_productId, $p_totalPrice, $p_date);

    foreach ($cartItems as $keyId => $item) {
        $p_productId = isset($item['product_id']) ? $item['product_id'] : $keyId;
        $p_totalPrice = $item['price'] * $item['quantity'];
        if (!$p_productId) $p_productId = 0; 
        if (!$stmtItem->execute()) {
             die("Execute failed (Item ID: $p_productId): " . $stmtItem->error);
        }
    }
    $stmtItem->close();

    return true;
}


public function getOrderItems($deliveryId) {
        // This query fetches all products belonging to a specific delivery/order
        $sql = "SELECT oc.product_id, p.product_name, p.image 
                FROM order_or_cart oc
                JOIN products p ON oc.product_id = p.product_id
                WHERE oc.delivery_id = ?";
                
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("Error preparing getOrderItems: " . $this->db->error);
        }

        $stmt->bind_param("i", $deliveryId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>