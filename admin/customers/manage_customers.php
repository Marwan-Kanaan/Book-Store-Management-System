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

// Fetch customers from database
$search = "";
$customers = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM customer WHERE name LIKE ?";
    $stmt = $conn->prepare($query);
    $searchTerm = "%$search%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $customers = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $query = "SELECT * FROM customer";
    $result = $conn->query($query);
    $customers = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers - Admin Dashboard</title>
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

        .button {
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            margin-right: 5px;
        }

        .update-btn {
            background-color: #FFCC00;
        }

        .update-btn:hover {
            background-color: #D4A300;
        }

        .delete-btn {
            background-color: #D9534F;
        }

        .delete-btn:hover {
            background-color: #C9302C;
        }

        table {
            width: 113%;
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
            <a href="manage_customers.php">Manage Customers</a>
            <a href="../orders/manage_orders.php">Manage Orders</a>
            <a href="../view_contacts.php">Manage Contacts</a>
            <a href="../../includes/logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="top-bar">
            <h1>Manage Customers</h1>
            <a href="add_customer.php" class="button update-btn">Add Customer</a>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET" action="manage_customers.php">
                <input type="text" name="search" placeholder="Search by name" value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Customers Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)) : ?>
                    <?php foreach ($customers as $customer) : ?>
                        <tr>
                            <td><?= htmlspecialchars($customer['id']) ?></td>
                            <td><?= htmlspecialchars($customer['name']) ?></td>
                            <td><?= htmlspecialchars($customer['email']) ?></td>
                            <td><?= htmlspecialchars($customer['phone_number']) ?></td>
                            <td>
                                <!-- Update Button -->
                                <a href="update_customer.php?id=<?= $customer['id'] ?>" class="button update-btn">Update</a>

                                <!-- Delete Button -->
                                <a href="delete_customer.php?id=<?= $customer['id'] ?>" class="button delete-btn" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No customers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
