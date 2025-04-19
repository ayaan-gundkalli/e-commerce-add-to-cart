<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <nav>
        <div class="logo">Amazon</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="#">Deals</a>
            <a href="#">Orders</a>
            <a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?>)</a>
        </div>
    </nav>

    <h2 style="text-align: center; margin-top: 20px;">Your Cart</h2>

    <div class="product-section">
        <?php
        if (!empty($_SESSION['cart'])) {
            $cart_items = implode(',', $_SESSION['cart']);
            $result = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($cart_items)");
            $total = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                $total += $row['price'];
                echo '<div class="product-card">
                        <img src="' . $row['image'] . '" alt="Product" />
                        <h3>' . $row['name'] . '</h3>
                        <p>$' . $row['price'] . '</p>
                        <a href="remove_from_cart.php?id=' . $row['id'] . '"><button>Remove</button></a>
                      </div>';
            }

            echo "<h3 style='width: 100%; text-align: center;'>Total: $$total</h3>";

            echo '<form action="checkout.php" method="POST" style="width: 100%; text-align: center; margin-top: 20px;">
                    <button type="submit">Checkout</button>
                  </form>';
        } else {
            echo "<p style='width: 100%; text-align: center;'>Your cart is empty!</p>";
        }
        ?>
    </div>
</body>
</html>
