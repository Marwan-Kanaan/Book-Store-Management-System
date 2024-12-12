<?php
session_start();

if (isset($_GET['id'])) {
    $key = $_GET['id'];

    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }
}

header("Location: cart.php");
exit;
?>
