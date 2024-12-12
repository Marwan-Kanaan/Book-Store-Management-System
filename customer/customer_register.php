<?php
// Initialize error message variable
$error = "";

// Include the database connection
include '../includes/connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';

    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($phone_number)) {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if the email already exists in the database
        $sql = "SELECT * FROM customer WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "An account with that email already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO customer (name, email, password, phone_number) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $email, $hashedPassword, $phone_number);

            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("Location: customer_login.php");
                exit;
            } else {
                $error = "There was an error during registration. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Register - Mira's Books</title>
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <!-- Registration Form -->
    <div class="register-form">
        <h2>Customer Registration</h2>

        <!-- Display error if there is one -->
        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Form fields -->
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="text" name="phone_number" placeholder="Enter your phone number" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="password" name="confirm_password" placeholder="Confirm your password" required>
            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="customer_login.php">Login here</a></p>
        <p>Are you an admin? <a href="../admin/admin_login.php">Log in here</a></p>
    </div>
</body>

</html>
