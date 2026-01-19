<?php include 'view/layout/header.php'; ?>

<style>
    .orders-container {
        max-width: 1000px;
        margin: 50px auto;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
    }
    .orders-header {
        margin-bottom: 30px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        border-radius: 8px;
        overflow: hidden;
    }
    .orders-table th, .orders-table td {
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }
    .orders-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #555;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        text-transform: capitalize;
    }
    /* Status Colors */
    .status-delivered { background-color: #d4edda; color: #155724; }
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-cancelled { background-color: #f8d7da; color: #721c24; }

    .btn-review {
        background-color: #FFD700;
        color: #333;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.9rem;
        font-weight: bold;
        transition: 0.2s;
        display: inline-block;
    }
    .btn-review:hover {
        background-color: #ffc107;
        transform: translateY(-1px);
    }
    .no-orders {
        text-align: center;
        padding: 50px;
        color: #777;
        background: #f9f9f9;
        border-radius: 8px;
    }
</style>

<div class="orders-container">
    <div class="orders-header">
        <h1>My Orders</h1>
    </div>

    <?php if (empty($orders)): ?>
        <div class="no-orders">
            <h3>You haven't placed any orders yet.</h3>
            <a href="index.php?page=home" style="color: #4CAF50; text-decoration: none; margin-top: 10px; display: inline-block;">Start Shopping</a>
        </div>
    <?php else: ?>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Products</th> <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($order['order_customer_id']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                        
                        <td style="max-width: 250px; color: #555;">
                            <?php echo htmlspecialchars($order['product_names'] ?? 'Unknown Product'); ?>
                        </td>

                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                        
                        <td>
                            <span class="status-badge status-<?php echo strtolower($order['delivery_status']); ?>">
                                <?php echo htmlspecialchars($order['delivery_status']); ?>
                            </span>
                        </td>

                        <td>
                            
                                <a href="index.php?page=write_review&order_id=<?php echo $order['order_customer_id']; ?>&delivery_id=<?php echo $order['order_delivery_id']; ?>" class="btn-review">
                                    ★ Write Review
                                </a>
                            
                                
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>