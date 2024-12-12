<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit;
}

// Calculate total price and count the number of books
$total_price = 0;
$book_count = 0;

foreach ($_SESSION['cart'] as $book) {
    // Ensure each item in the cart is an array with expected keys
    if (is_array($book) && isset($book['title'], $book['author'], $book['price'])) {
        $total_price += $book['price'];
        $book_count++;
    } else {
        // Handle unexpected data gracefully
        echo "Invalid cart data.";
        exit;
    }
}

// Save cart data, total price, and total items to the database upon checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    include '../includes/connection.php';

    $customer_id = $_SESSION['customer_id']; // Assuming customer ID is available

    $books = [];
    foreach ($_SESSION['cart'] as $key => $book) {
        $books[] = $book['title'];  // Save book titles
    }

    $books_json = json_encode($books);

    // Save cart data, total price, and total items into the database
    $stmt = $conn->prepare("INSERT INTO cart (customer_id, book_ids, total_price, total_items) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('isdi', $customer_id, $books_json, $total_price, $book_count);

    if ($stmt->execute()) {
        unset($_SESSION['cart']);  // Clear the cart after checkout
        echo "Checkout successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #8B5E3C;
            color: white;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
        }

        .btn-remove {
            background-color: #D9534F;
        }

        .btn-remove:hover {
            background-color: #C9302C;
        }

        .btn-checkout {
            background-color: #FFCC00;
            display: block;
            margin: 20px auto;
        }

        .btn-checkout:hover {
            background-color: #D4A300;
        }

        .btn-back {
            background-color: #4A4A4A;
            color: white;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #333;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Your Cart</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $key => $book) :
                        if (is_array($book) && isset($book['title'], $book['author'], $book['price'])) :
                ?>
                            <tr>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['author']) ?></td>
                                <td>$<?= number_format($book['price'], 2) ?></td>
                                <td>
                                    <a href="remove_from_cart.php?id=<?= $key ?>" class="btn btn-remove" onclick="return confirm('Are you sure you want to remove this item?');">Remove</a>
                                </td>
                            </tr>
                <?php 
                        endif; 
                    endforeach; 
                } ?>
            </tbody>
        </table>

        <p><strong>Total Price:</strong> $<?= number_format($total_price, 2) ?></p>
        <p><strong>Total Items:</strong> <?= $book_count ?></p>

        <!-- Checkout Button -->
        <form method="POST" action="">
            <button type="submit" class="btn btn-checkout">Checkout</button>
        </form>

        <!-- Back Button -->
        <a href="../index.php" class="btn btn-back">Go Back</a>
    </div>

</body>

</html>
