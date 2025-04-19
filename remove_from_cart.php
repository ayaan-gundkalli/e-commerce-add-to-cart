<?php
session_start();

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    if (!empty($_SESSION['cart'])) {
        $_SESSION['cart'] = array_diff($_SESSION['cart'], [$product_id]);
    }
}

header("Location: cart.php");
exit();
?>
