<?php
session_start();
include 'connection.php'; // Adjust path as needed

// Pre-fill customer details if logged in
$name = '';
$email = '';
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];

    // Fetch customer details from the database
    $stmt = $conn->prepare("SELECT name, email FROM customer WHERE id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $name = htmlspecialchars($customer['name']);
        $email = htmlspecialchars($customer['email']);
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Save the message to the database
        $stmt = $conn->prepare("INSERT INTO contact_us (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success_message = "Thank you for contacting us! We will get back to you soon.";
        } else {
            $error_message = "Failed to send your message. Please try again.";
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
    <title>Contact Us</title>
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

        form div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
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
        
        .btn-submit {
            background-color: #FFCC00;
            color: #4A4A4A;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #D4A300;
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
        <h1>Contact Us</h1>

        <?php if (!empty($success_message)): ?>
            <p class="message success"><?= $success_message ?></p>
        <?php elseif (!empty($error_message)): ?>
            <p class="message error"><?= $error_message ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= $name ?>" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $email ?>" required>
            </div>
            <div>
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div>
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Submit</button>
            <br><br>
            <a href="../index.php" class="btn btn-secondary">Back to Home</a>
        </form>
    </div>
</body>

</html>
