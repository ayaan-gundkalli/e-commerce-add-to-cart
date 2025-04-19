<?php
session_start();
include 'db.php';

// Check admin login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Fetch orders
$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Orders</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">Amazon Admin</div>
        <div class="nav-links">
            <a href="index.php">User Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <h2 style="text-align: center; margin-top: 20px;">Manage Orders</h2>

    <div class="product-section" style="flex-direction: column; align-items: center;">
        <?php while ($order = $orders->fetch_assoc()): ?>
            <div class="product-card" style="width: 80%;">
                <h3>Order #<?php echo $order['id']; ?> (<?php echo $order['status']; ?>)</h3>
                <p>Placed on: <?php echo $order['created_at']; ?></p>
                <p><strong>Items:</strong></p>
                <ul>
                    <?php
                    $order_id = $order['id'];
                    $items = $conn->query("SELECT products.name FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = $order_id");
                    while ($item = $items->fetch_assoc()):
                        echo "<li>" . $item['name'] . "</li>";
                    endwhile;
                    ?>
                </ul>

                <?php if ($order['status'] === 'Pending'): ?>
                    <a href="update_order_status.php?id=<?php echo $order['id']; ?>&status=Approved"><button>Approve</button></a>
                    <a href="update_order_status.php?id=<?php echo $order['id']; ?>&status=Cancelled"><button>Cancel</button></a>
                    <a href="delete_order.php?id=<?php echo $order['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">
    <button style="
        padding: 8px 15px;
        background-color: #6c757d;
        border: none;
        border-radius: 4px;
        color: white;
        cursor: pointer;
        margin-top: 5px;
    ">Delete</button>
</a>

                <?php else: ?>
                    <strong>Status: <?php echo $order['status']; ?></strong>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
