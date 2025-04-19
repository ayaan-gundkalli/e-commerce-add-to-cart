<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Amazon Clone</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">Amazon</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="#">Deals</a>
            <a href="#">Orders</a>
            <a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?>)</a>
            <div style="text-align: center; margin-top: 20px;">
    <a href="admin_login.php">
        <button style="
            padding: 10px 20px;
            background-color: #ff9900;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 16px;
        ">
            Admin Login
        </button>
    </a>
</div>

        </div>
    </nav>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" placeholder="Search for products" />
        <button>Search</button>
    </div>

    <!-- Product Section -->
    <div class="product-section">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products");
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">
                    <img src="' . $row['image'] . '" alt="Product" />
                    <h3>' . $row['name'] . '</h3>
                    <p>$' . $row['price'] . '</p>
                    <form method="POST" action="add_to_cart.php">
                        <input type="hidden" name="product_id" value="' . $row['id'] . '" />
                        <button type="submit">Add to Cart</button>
                    </form>
                  </div>';
        }
        ?>
    </div>
</body>
</html>
