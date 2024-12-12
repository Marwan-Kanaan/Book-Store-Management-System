<?php
session_start();
include '../includes/connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all "Contact Us" messages
$query = "SELECT * FROM contact_us";
$result = $conn->query($query);
$messages = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['messages'] as $messageId => $status) {
        $read = isset($status['read_it']) ? 1 : 0;
        $working_on = isset($status['working_on']) ? 1 : 0;
        $done = isset($status['done']) ? 1 : 0;

        $updateQuery = "UPDATE contact_us SET read_it = ?, working_on = ?, done = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiii", $read, $working_on, $done, $messageId);
        $stmt->execute();
    }

    // Redirect back to the page after updating
    header("Location: view_contacts.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contact Us Messages - Admin Dashboard</title>
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

        button[type="submit"] {
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #2F4F4F;
            color: #FFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #1f3a3a;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="title">Admin Dashboard</div>
        <div class="links">
            <a href="dashboard.php">Dashboard</a>
            <a href="books/manage_books.php">Manage Books</a>
            <a href="customers/manage_customers.php">Manage Customers</a>
            <a href="orders/manage_orders.php">Manage Orders</a>
            <a href="manage_contacts.php">Manage Contacts</a>
            <a href="../includes/logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="top-bar">
            <h1>Manage Contact Us Messages</h1>
        </div>

        <!-- Messages Table -->
        <form method="POST" action="view_contacts.php">
            <table>
                <thead>
                    <tr>
                        <th>Message ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Read</th>
                        <th>Work on</th>
                        <th>Done</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($messages)) : ?>
                        <?php foreach ($messages as $message) : ?>
                            <tr>
                                <td><?= htmlspecialchars($message['id']) ?></td>
                                <td><?= htmlspecialchars($message['name']) ?></td>
                                <td><?= htmlspecialchars($message['email']) ?></td>
                                <td><?= htmlspecialchars($message['subject']) ?></td>
                                <td><?= htmlspecialchars($message['message']) ?></td>
                                <td>
                                    <input type="checkbox" name="messages[<?= htmlspecialchars($message['id']) ?>][read_it]" <?= $message['read_it'] ? 'checked' : '' ?> value="1">
                                </td>
                                <td>
                                    <input type="checkbox" name="messages[<?= htmlspecialchars($message['id']) ?>][working_on]" <?= $message['working_on'] ? 'checked' : '' ?> value="1">
                                </td>
                                <td>
                                    <input type="checkbox" name="messages[<?= htmlspecialchars($message['id']) ?>][done]" <?= $message['done'] ? 'checked' : '' ?> value="1">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8">No messages found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>

</html>
