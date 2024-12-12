<?php
session_start();

// Include database connection
include '../includes/connection.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch book details
    $query = "SELECT * FROM book WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($book) {
        // Initialize cart session array
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add book to cart
        $_SESSION['cart'][] = $book;
    }
}

header("Location: cart.php");
exit;
?>
