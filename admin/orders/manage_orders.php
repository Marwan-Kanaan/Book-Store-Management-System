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

// Fetch orders from database
$search = "";
$orders = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "
        SELECT cart.id AS order_id, cart.total_price, cart.book_ids, cart.total_items, customer.name AS customer_name
        FROM cart
        INNER JOIN customer ON cart.customer_id = customer.id
        WHERE customer.name LIKE ?
    ";
    $stmt = $conn->prepare($query);
    $searchTerm = "%$search%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $query = "
        SELECT cart.id AS order_id, cart.total_price, cart.book_ids, cart.total_items, customer.name AS customer_name
        FROM cart
        INNER JOIN customer ON cart.customer_id = customer.id
    ";
    $result = $conn->query($query);
    $orders = $result->fetch_all(MYSQLI_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2F4F4F;
            color: #FFF;
            padding: 10px 20px;
        }

        .navbar .title {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar .links a {
            color: #FFCC00;
            text-decoration: none;
            margin-left: 15px;
            font-size: 16px;
        }

        .navbar .links a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #FFCC00;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #D4A300;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        table th,
        table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #2F4F4F;
            color: #FFF;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="title">Admin Dashboard</div>
        <div class="links">
            <a href="../dashboard.php">Dashboard</a>
            <a href="../books/manage_books.php">Manage Books</a>
            <a href="../customers/manage_customers.php">Manage Customers</a>
            <a href="manage_orders.php">Manage Orders</a>
            <a href="../view_contacts.php">Manage Contacts</a>
            <a href="../../includes/logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="top-bar">
            <h1>Manage Orders</h1>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET" action="manage_orders.php">
                <input type="text" name="search" placeholder="Search by customer name" value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <form method="POST" action="generate_text.php">
            <button type="submit" style="padding: 10px 15px; background-color: #FFCC00; border: none; border-radius: 5px; cursor: pointer;">
                Download Orders as Text
            </button>
        </form>


        <!-- Orders Table -->
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Books</th>
                    <th>Total Items</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)) : ?>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['customer_name']) ?></td>
                            <td><?= htmlspecialchars(implode(', ', json_decode($order['book_ids'], true))) ?></td>
                            <td><?= htmlspecialchars($order['total_items']) ?></td>
                            <td>$<?= number_format($order['total_price'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>