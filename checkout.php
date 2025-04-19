<?php
session_start();
include 'db.php';

if (!empty($_SESSION['cart'])) {
    $conn->query("INSERT INTO orders (status) VALUES ('Pending')");
    $order_id = $conn->insert_id;

    foreach ($_SESSION['cart'] as $product_id) {
        $conn->query("INSERT INTO order_items (order_id, product_id) VALUES ($order_id, $product_id)");
    }

    unset($_SESSION['cart']);

    echo "<script>alert('Order placed successfully!'); window.location='index.php';</script>";
} else {
    header("Location: cart.php");
    exit();
}
?>
