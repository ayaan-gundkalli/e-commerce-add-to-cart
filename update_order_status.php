<?php
session_start();
include 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = intval($_GET['id']);
    $status = $_GET['status'];

    // Prepare and execute update query
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        header("Location: admin_orders.php?message=Order updated successfully!");
        exit();
    } else {
        echo "Error updating order: " . $conn->error;
    }
} else {
    header("Location: admin_orders.php?message=Invalid request!");
    exit();
}
?>
