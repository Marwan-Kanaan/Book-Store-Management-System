<?php
session_start();
include '../../includes/connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit;
}

// Fetch all orders with customer names and book titles
$query = "
    SELECT cart.id AS order_id, cart.total_price, cart.book_ids, cart.total_items, customer.name AS customer_name
    FROM cart
    INNER JOIN customer ON cart.customer_id = customer.id
";

// Prepare text file content
$fileContent = "Order ID | Customer Name | Books | Total Items | Total Price\n";
$fileContent .= str_repeat("-", 90) . "\n";

$orders = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

foreach ($orders as $order) {
    // Decode book names JSON
    $bookNames = json_decode($order['book_ids']);
    $fileContent .= sprintf(
        "%s | %s | %s | %d | $%.2f\n",
        $order['order_id'],
        $order['customer_name'],
        implode(', ', $bookNames),
        $order['total_items'],
        $order['total_price']
    );
}

// Generate the file and prompt download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="orders.txt"');
echo $fileContent;
exit;
?>
