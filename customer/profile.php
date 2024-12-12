<?php
session_start();
include '../includes/connection.php';

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Fetch customer details
$stmt = $conn->prepare("SELECT name, email, phone_number FROM customer WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Fetch customer orders
$order_stmt = $conn->prepare("SELECT id, book_ids, total_price FROM cart WHERE customer_id = ?");
$order_stmt->bind_param("i", $customer_id);
$order_stmt->execute();
$orders = $order_stmt->get_result();

// Fetch emails sent by the customer
$email_stmt = $conn->prepare("SELECT id, email, subject, message, read_it, working_on, done FROM contact_us WHERE email = ?");
$email_stmt->bind_param("s", $customer['email']);
$email_stmt->execute();
$emails = $email_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            background-color: #FAF3E0;
            font-family: Arial, sans-serif;
            color: #4A4A4A;
        }

        .container {
            width: 70%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #8B5E3C;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #8B5E3C;
            color: white;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            font-size: 16px;
            color: #fff;
            background-color: #8B5E3C;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            margin: 10px;
        }

        .btn-secondary {
            background-color: #4A4A4A;
        }

        .btn:hover {
            background-color: #6b3f2b;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>My Profile</h1>

        <h2>Personal Details</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($customer['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></p>
        <p><strong>Phone Number:</strong> <?= htmlspecialchars($customer['phone_number']) ?></p>

        <a href="update_profile.php" class="btn">Update Details</a>

        <h2>My Orders</h2>
        <?php if ($orders->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Books</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $orders->fetch_assoc()): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= htmlspecialchars(implode(', ', json_decode($order['book_ids'], true))) ?></td>
                            <td>$<?= number_format($order['total_price'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>

        <h2>My Emails Sent</h2>
        <?php if ($emails->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Email ID</th>
                        <th>Recipient Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Read</th>
                        <th>Work on</th>
                        <th>Done</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($email = $emails->fetch_assoc()): ?>
                        <tr>
                            <td><?= $email['id'] ?></td>
                            <td><?= htmlspecialchars($email['email']) ?></td>
                            <td><?= htmlspecialchars($email['subject']) ?></td>
                            <td><?= htmlspecialchars($email['message']) ?></td>
                            <td><?= $email['read_it'] ? 'Yes' : 'No' ?></td>
                            <td><?= $email['working_on'] ? 'Yes' : 'No' ?></td>
                            <td><?= $email['done'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p>No emails found.</p>
        <?php endif; ?>

        <a href="../index.php" class="btn btn-secondary">Back to Home</a>
    </div>
</body>

</html>