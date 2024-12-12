<?php
session_start();
include 'includes/connection.php';

$books = [];
$error = "";
$isLoggedIn = isset($_SESSION['customer_id']);

if (!empty($_GET)) {
    $title = $_GET['title'] ?? '';
    $price_min = $_GET['price_min'] ?? 0;
    $price_max = $_GET['price_max'] ?? PHP_INT_MAX;

    $query = "SELECT * FROM book WHERE 1=1";
    $params = [];
    $bindTypes = '';

    if (!empty($title)) {
        $query .= " AND title LIKE ?";
        $params[] = "%$title%";
        $bindTypes .= 's';
    }

    if (!empty($price_min) && !empty($price_max)) {
        $query .= " AND price >= ? AND price <= ?";
        $params[] = $price_min;
        $params[] = $price_max;
        $bindTypes .= 'ii';
    } elseif (!empty($price_min)) {
        $query .= " AND price >= ?";
        $params[] = $price_min;
        $bindTypes .= 'i';
    } elseif (!empty($price_max)) {
        $query .= " AND price <= ?";
        $params[] = $price_max;
        $bindTypes .= 'i';
    }

    $stmt = $conn->prepare($query);
    if ($params) {
        $stmt->bind_param($bindTypes, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $conn->prepare("SELECT * FROM book");
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    $error = "No books found.";
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mira's Books</title>
    <style>
        /* General Body Style */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FAF3E0;
        }

        /* Navigation Bar */
        header {
            position: fixed;
            top: 0;
            width: 95%;
            background-color: transparent;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        header h1 {
            font-family: 'Georgia', serif;
            font-size: 30px;
            margin: 0;
            color: #FFCC00;
        }

        nav {
            display: flex;
            gap: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            position: relative;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav a:hover {
            color: #FFCC00;
            transform: translateY(-5px);
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #FFCC00;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease;
        }

        nav a:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .hero {
            position: relative;
            width: 100%;
            height: 800px;
            background-image: url('images/hero.jpg');
            background-size: cover;
            background-position: center;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            max-width: 600px;
        }

        .hero h2 {
            font-size: 40px;
            font-family: 'Georgia', serif;
        }

        .hero p {
            font-size: 24px;
        }

        /* Search Section */
        .search-section {
            margin: 50px auto;
            padding: 20px;
            max-width: 900px;
            background-color: #FFF;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .search-section h3 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #4A4A4A;
        }

        .search-section form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-section input,
        .search-section select,
        .search-section button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #CCC;
            border-radius: 5px;
        }

        .search-section input {
            flex: 2;
        }

        .search-section select {
            flex: 1;
        }

        .search-section button {
            flex: 0.5;
            background-color: #FFCC00;
            color: #4A4A4A;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-section button:hover {
            background-color: #D4A300;
        }

        /* Book Cards Section */
        .book-cards {
            margin: 30px auto;
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .book-card {
            background-color: #FFF;
            border: 1px solid #CCC;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .book-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 5px;
        }

        .book-card h4 {
            font-size: 20px;
            margin: 10px 0;
            color: #4A4A4A;
        }

        .book-card button {
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .details-btn {
            background-color: #FFCC00;
            color: #4A4A4A;
        }

        .details-btn:hover {
            background-color: #D4A300;
        }

        .add-cart-btn {
            background-color: #A8C686;
            color: white;
        }

        .add-cart-btn:hover {
            background-color: #89A866;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <header>
        <h1>Mira's Books</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="includes/contact.php">Contact Us</a>
            <?php if (isset($_SESSION['customer_id'])): ?>
                <a href="customer/cart.php">Cart</a>
                <a href="customer/profile.php">Profile</a>
                <a href="includes/logout.php">Logout</a>

            <?php else: ?>
                <a href="customer/customer_login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content">
            <h2>Welcome to Mira's Books</h2>
            <p>Find your next great read and get lost in a world of stories!</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <h3>Search for Books</h3>
        <form method="GET" action="">
            <input type="text" name="title" placeholder="Search by title..." />
            <input type="number" name="price_min" placeholder="Min Price" min="0" />
            <input type="number" name="price_max" placeholder="Max Price" min="0" />
            <button type="submit">Search</button>
        </form>
    </div>



    <!-- Book Cards Section -->
    <div class="book-cards">
        <?php
        // Use the books array to display either search results or default books
        $booksToDisplay = !empty($books) ? $books : []; // Use $books if search results exist
        if (!empty($booksToDisplay)) :
            foreach ($booksToDisplay as $book) :
        ?>
                <div class="book-card">
                    <!-- Update the src attribute to use the file path -->
                    <img src="uploads/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?> Image">
                    <h4><?= htmlspecialchars($book['title']) ?></h4>
                    <h4><?= htmlspecialchars($book['price']) ?> $</h4>
                    <button class="details-btn" onclick="window.location.href='includes/book_details.php?id=<?= $book['id'] ?>'">View Details</button>
                    <?php if ($isLoggedIn) : ?>
                        <button class="add-cart-btn" onclick="window.location.href='customer/add_to_cart.php?id=<?= $book['id'] ?>'">Add to Cart</button>
                    <?php endif; ?>
                </div>
            <?php
            endforeach;
        else :
            ?>
            <p>No books found to display.</p>
        <?php endif; ?>
    </div>




</body>

</html>