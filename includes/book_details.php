<?php
// Start session
session_start();

// Include database connection
include '../includes/connection.php';

// Get book ID from URL
$book_id = $_GET['id'];
$isLoggedIn = isset($_SESSION['customer_id']);
// Fetch book details from the database
$query = "SELECT * FROM book WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "Book not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
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

        img {
            display: block;
            margin: 0 auto;
            max-width: 40%;
            height: auto;
            border-radius: 8px;
        }

        .details {
            margin: 20px 0;
            text-align: center;
        }

        p {
            font-size: 16px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .back-btn, .cart-btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .back-btn {
            background-color: #FFCC00;
        }

        .back-btn:hover {
            background-color: #e6b800;
        }

        .cart-btn {
            background-color: #8B5E3C;
        }

        .cart-btn:hover {
            background-color: #6b3f2b;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1><?= htmlspecialchars($book['title']) ?></h1>
        <img src="../uploads/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?> Image">
        <div class="details">
            <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($book['description']) ?></p>
            <p><strong>Price:</strong> $<?= htmlspecialchars($book['price']) ?></p>
        </div>
        <div class="button-container">
            <a href="../index.php" class="back-btn">Back to Books</a>
            <?php if ($isLoggedIn) : ?>
                <a href="../customer/add_to_cart.php?id=<?= $book['id'] ?>" class="cart-btn">Add to Cart</a>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>
