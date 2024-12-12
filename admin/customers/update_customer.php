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

// Get customer ID from URL
$customer_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Update customer details
    $stmt = $conn->prepare("UPDATE customer SET name = ?, email = ?, phone_number = ? WHERE id = ?");
    $stmt->bind_param('sssi', $name, $email, $phone_number, $customer_id);

    if ($stmt->execute()) {
        echo "Customer updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    // Fetch current customer details
    $query = "SELECT * FROM customer WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <style>
        body {
            background-color: #FAF3E0;
            font-family: Arial, sans-serif;
            color: #4A4A4A;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #8B5E3C;
            text-align: center;
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #8B5E3C;
            /* Dashboard theme color */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #4A4A4A;
            /* A darker shade for secondary buttons */
        }

        .btn:hover {
            background-color: #6b3f2b;
            /* Slightly darker shade for hover effect */
        }
        
        button {
            background-color: #FFCC00;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #e6b800;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Update Customer</h1>
        <form action="update_customer.php?id=<?= $customer_id ?>" method="POST">
            <div class="form-group">
                <label for="name">Customer Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?= htmlspecialchars($customer['phone_number']) ?>" required>
            </div>
            <button type="submit">Update Customer</button>
            <br><br>
            <a href="manage_customers.php" class="btn btn-secondary">Back to Manger</a>
        </form>
    </div>

</body>

</html>
