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
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookId = $_POST['id']; // To identify the book being updated
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imagePath = null;

    // Handle image upload if a new image is provided
    if (!empty($_FILES['image']['tmp_name'])) {
        $imageFileName = basename($_FILES['image']['name']); // Get the image file name
        $targetDirectory = "../../uploads/"; // Directory to save uploaded images
        $targetFilePath = $targetDirectory . $imageFileName; // Full file path
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION)); // Get file extension

        // Allow only certain file formats
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedFileTypes)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = $imageFileName; // Store file name to save in database
            } else {
                echo "Error uploading the image.";
                exit;
            }
        } else {
            echo "Invalid image file type.";
            exit;
        }
    }

    // Update the database with or without changing the image
    if ($imagePath) {
        // Update all fields including the new image path
        $stmt = $conn->prepare("UPDATE book SET title = ?, author = ?, image = ?, description = ?, price = ? WHERE id = ?");
        $stmt->bind_param('ssssdi', $title, $author, $imagePath, $description, $price, $bookId);
    } else {
        // Update fields excluding the image
        $stmt = $conn->prepare("UPDATE book SET title = ?, author = ?, description = ?, price = ? WHERE id = ?");
        $stmt->bind_param('sssdi', $title, $author, $description, $price, $bookId);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Book updated successfully!";
        header("Location: manage_books.php"); // Redirect to manage books page
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch book details to populate the form
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM book WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
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
        <h1>Update Book</h1>
        <form action="update_book.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>"> <!-- Hidden input for book ID -->

            <div class="form-group">
                <label for="title">Book Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Book Image (Optional)</label>
                <input type="file" id="image" name="image">
                <small>If you wish to change the image, upload a new one here.</small>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($book['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="<?= htmlspecialchars($book['price']) ?>" required>
            </div>
            <button type="submit">Update Book</button>
            <br><br>
            <a href="manage_books.php" class="btn btn-secondary">Back to Manger</a>
        </form>
    </div>

</body>

</html>