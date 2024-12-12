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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Check if an image file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageFile = $_FILES['image']['name'];
        $imageTempPath = $_FILES['image']['tmp_name'];

        // Define the target directory for uploads
        $uploadDir = '../../uploads/';
        $uploadFilePath = $uploadDir . basename($imageFile);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($imageTempPath, $uploadFilePath)) {
            // Store only the relative path in the database
            $imagePath = basename($imageFile);

            // Insert book details into the database
            $stmt = $conn->prepare("INSERT INTO book (title, author, image, description, price) 
                                    VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssd', $title, $author, $imagePath, $description, $price);

            if ($stmt->execute()) {
                echo "Book added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error uploading the image.";
        }
    } else {
        echo "Error: Image file not provided.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
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
        input[type="number"],
        textarea,
        select,
        input[type="file"] {
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
        <h1>Add a New Book</h1>
        <form action="add_book.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Book Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="image">Book Image</label>
                <input type="file" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" required>
            </div>
            <button type="submit">Add Book</button>
            <br><br>
            <!-- Back to Dashboard Button -->
            <a href="manage_books.php" class="btn btn-secondary">Back to Manger</a>
        </form>
    </div>



</body>

</html>