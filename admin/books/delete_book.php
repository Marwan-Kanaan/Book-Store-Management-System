<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit;
}

// Include the connection file
include('../../includes/connection.php');

// Check if the ID is set in the URL and is valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $bookId = $_GET['id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM book WHERE id = ?");
    $stmt->bind_param("i", $bookId);

    if ($stmt->execute()) {
        // Redirect to the manage books page with a success message
        header("Location: manage_books.php?message=Book deleted successfully");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid book ID.";
}
?>
