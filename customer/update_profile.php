<?php
session_start();
include '../includes/connection.php';

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Fetch current customer details
$stmt = $conn->prepare("SELECT name, email, phone_number FROM customer WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);

    if (!empty($name) && !empty($email) && !empty($phone_number)) {
        // Update customer details
        $update_stmt = $conn->prepare("UPDATE customer SET name = ?, email = ?, phone_number = ? WHERE id = ?");
        $update_stmt->bind_param("sssi", $name, $email, $phone_number, $customer_id);

        if ($update_stmt->execute()) {
            $success_message = "Profile updated successfully.";
            // Refresh customer data
            $customer['name'] = $name;
            $customer['email'] = $email;
            $customer['phone_number'] = $phone_number;
        } else {
            $error_message = "Failed to update profile. Please try again.";
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
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

        form {
            margin-top: 20px;
        }

        form div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
        }

        .btn:hover {
            background-color: #6b3f2b;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .error {
            color: #D9534F;
        }

        .success {
            color: #5CB85C;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Profile</h1>

        <?php if (!empty($success_message)): ?>
            <p class="message success"><?= $success_message ?></p>
        <?php elseif (!empty($error_message)): ?>
            <p class="message error"><?= $error_message ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required>
            </div>
            <div>
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="<?= htmlspecialchars($customer['phone_number']) ?>" required>
            </div>
            <button type="submit" class="btn">Update Profile</button>
        </form>
        
        <br>
        <a href="profile.php" class="btn">Back to Profile</a>
    </div>
</body>

</html>
