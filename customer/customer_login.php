<?php
// Start session for user login state
session_start();

// Initialize error message variable
$error = "";

// Include the database connection
include '../includes/connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Please fill in both fields.";
    } else {
        // Query to check if the user exists with the provided email
        $sql = "SELECT * FROM customer WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists and verify password
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify password (assuming hashed password is stored in the database)
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['customer_id'] = $user['id'];
                $_SESSION['customer_name'] = $user['name'];

                // Redirect to homepage or dashboard after successful login
                header("Location: ../index.php");
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mira's Books</title>
    <link rel="stylesheet" href="../css/log.css">
</head>

<body>
    <!-- Login Form -->
    <div class="login-form">
        <h2>Customer Login</h2>

        <!-- Display error if there is one -->
        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Form fields -->
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="customer_register.php">Register here</a></p>
        <p>Are you an admin? <a href="../admin/admin_login.php">Log in here</a></p>
    </div>
</body>

</html>