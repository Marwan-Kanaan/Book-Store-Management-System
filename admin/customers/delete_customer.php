<?php
// Start session
session_start();

// Include database connection
include '../../includes/connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit;
}

// Check if the ID is set in the URL and is valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $CustomreId = $_GET['id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM customer WHERE id = ?");
    $stmt->bind_param("i", $CustomreId);

    if ($stmt->execute()) {
        // Redirect to the manage books page with a success message
        header("Location: manage_customers.php?message=Customer deleted successfully");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid Customer ID.";
}
?>
