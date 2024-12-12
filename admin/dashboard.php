<?php
// Start session
session_start();

// Include database connection
include '../includes/connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Get admin's first name
$admin_name = explode(" ", $_SESSION['admin_name'])[0];

// Fetch data for the cards
// Total books
$bookQuery = "SELECT COUNT(*) AS total_books FROM book";
$bookResult = $conn->query($bookQuery);
$totalBooks = $bookResult->fetch_assoc()['total_books'];

// Total customers
$customerQuery = "SELECT COUNT(*) AS total_customers FROM customer";
$customerResult = $conn->query($customerQuery);
$totalCustomers = $customerResult->fetch_assoc()['total_customers'];

// Total sales
$salesQuery = "SELECT SUM(total_price) AS total_sales FROM cart";
$salesResult = $conn->query($salesQuery);
$totalSales = $salesResult->fetch_assoc()['total_sales'] ?? 0;

// total orders
$orderQuery = "SELECT COUNT(*) AS total_orders FROM cart";
$orderResult = $conn->query($orderQuery);    
$totalOrders = $orderResult->fetch_assoc()['total_orders'] ?? 0;

$contactQuery = "SELECT COUNT(*) AS total_contacts FROM contact_us";
$contactResult = $conn->query($contactQuery);
$totalcontact = $contactResult->fetch_assoc()['total_contacts'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        /* Navigation Bar */
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

        .navbar .links {
            display: flex;
            gap: 15px;
        }

        .navbar .links a {
            color: #FFCC00;
            text-decoration: none;
            font-size: 16px;
            position: relative;
        }

        .navbar .links a:hover {
            text-decoration: underline;
        }

        /* Link animation */
        .navbar .links a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -5px;
            height: 2px;
            width: 0%;
            background-color: #FFCC00;
            transition: width 0.3s ease;
        }

        .navbar .links a:hover::after {
            width: 100%;
        }

        /* Welcome Message */
        .welcome {
            text-align: center;
            margin: 20px 0;
            font-size: 32px;
            color: #333;
        }

        /* Cards Container */
        .cards {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            margin: 20px auto;
            max-width: 1200px;
        }

        .card {
            background: #FFF;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 250px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card h3 {
            font-size: 20px;
            color: #4A4A4A;
        }

        .card p {
            font-size: 16px;
            color: #333;
        }

        /* Dashboard Links */
        .dashboard-actions {
            text-align: center;
            margin: 40px auto;
        }

        .dashboard-link {
            display: inline-block;
            margin: 20px;
            padding: 15px 30px;
            background-color: #FFCC00;
            color: #4A4A4A;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .dashboard-link:hover {
            background-color: #D4A300;
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="title">Admin Dashboard</div>
        <div class="links">
            <a href="dashboard.php">Dashboard</a>
            <a href="add_admin.php">Add Admin</a>
            <a href="../includes/logout.php">Logout</a>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="welcome">
        <p>Welcome, Admin <strong><?= htmlspecialchars($admin_name) ?></strong>!</p>
    </div>

    <!-- Cards Section -->
    <div class="cards">
        <div class="card">
            <h3>Total Books</h3>
            <p><?= $totalBooks ?></p>
        </div>
        <div class="card">
            <h3>Total Customers</h3>
            <p><?= $totalCustomers ?></p>
        </div>
        <div class="card">
            <h3>Total Orders</h3>
            <p><?= $totalOrders ?></p>
        </div>
        <div class="card">
            <h3>Total Emails</h3>
            <p><?= $totalcontact ?></p>
        </div>
        <div class="card">
            <h3>Total Sales</h3>
            <p>$<?= number_format($totalSales, 2) ?></p>
        </div>
    </div>

    <!-- Dashboard Links -->
    <div class="dashboard-actions">
        <a class="dashboard-link" href="books/manage_books.php">Manage Books</a>
        <a class="dashboard-link" href="customers/manage_customers.php">Manage Customers</a>
        <a class="dashboard-link" href="orders/manage_orders.php">Show All Orders</a>
        <a class="dashboard-link" href="view_contacts.php">Show All Emails</a> <!-- Added Button for Orders -->
    </div>
</body>

</html>
