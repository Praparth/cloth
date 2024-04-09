<?php
session_start();

    // Access user data from session
    if (!isset($_SESSION['login_user'])) {
        header("Location: user_login_profile.php");
        exit();
    }


if(isset($_POST['productName']) && isset($_POST['productImage']) && isset($_POST['productPrice'])) {
    // Access user data from session
    $fullName = $_SESSION['login_user'];
    // You need to define the seller name or retrieve it from your database if applicable
    $sellerName = ""; 

    // Database connection
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "cloth";
    $conn = mysqli_connect($server, $username, $password, $database);

    // Check if the database connection is successful
    if (!$conn) {
        die("Error: " . mysqli_connect_error());
    }

    // Insert product details into user_add_to_card table
    $productName = $_POST['productName'];
    $productImage = $_POST['productImage'];
    $productPrice = $_POST['productPrice'];

    // Prepare the SQL statement
    $sql = "INSERT INTO user_add_to_card (user_name, seller_name, product_name, product_price, product_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "sssss", $fullName, $sellerName, $productName, $productPrice, $productImage);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "success";
        } else {
            echo "Error inserting record: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request";
}
?>
