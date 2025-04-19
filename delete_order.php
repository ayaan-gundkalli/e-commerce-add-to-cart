<?php
session_start();
include 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    // First, delete from order_items to avoid foreign key error
    $conn->query("DELETE FROM order_items WHERE order_id = $order_id");

    // Then, delete the order
    if ($conn->query("DELETE FROM orders WHERE id = $order_id")) {
        header("Location: admin_orders.php?message=Order deleted successfully!");
        exit();
    } else {
        echo "Error deleting order: " . $conn->error;
    }
} else {
    header("Location: admin_orders.php?message=Invalid request!");
    exit();
}
?>
