<?php


class Cart {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function getItems() {
        return $_SESSION['cart'];
    }

    public function add($id, $name, $price, $qty, $image) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                'name'     => $name,
                'price'    => $price,
                'quantity' => $qty,
                'image'    => $image
            ];
        }
    }

    public function updateQuantity($id, $change) {
        if (!isset($_SESSION['cart'][$id])) return;

        if ($change === 'increase') {
            $_SESSION['cart'][$id]['quantity']++;
        } elseif ($change === 'decrease') {
            $_SESSION['cart'][$id]['quantity']--;
            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                $this->remove($id);
            }
        }
    }

    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    public function clear() {
        unset($_SESSION['cart']);
    }

    public function calculateTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function countItems() {
        return array_sum(array_column($_SESSION['cart'], 'quantity'));
    }


    public static function getTotalQuantity() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['quantity'];
            }
        }
        return $total;
    }
}
?>