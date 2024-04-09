<?php
// Start session
session_start();

    // Access user data from session
    if (!isset($_SESSION['login_user'])) {
        header("Location: user_login_profile.php");
        exit();
    }


// Access user data from session
$fullName = $_SESSION['login_user'];

// Establish database connection
$server = "localhost";
$username = "root";
$password = "";
$database = "cloth";
$conn = mysqli_connect($server, $username, $password, $database);

// Check if the database connection is successful
if (!$conn) {
    die("Error: " . mysqli_connect_error());
}

// Delete the record
if(isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM wishlist WHERE sno=?";
    $stmt = mysqli_prepare($conn, $sql);

    // Check if statement preparation succeeded
    if ($stmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "i", $sno);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

// Insert product details into the user_add_to_card table only if the form is submitted
// Insert product details into the user_add_to_card table only if the form is submitted
if (isset($_POST['addToCart'])) {
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productImage = $_POST['productImage'];
    $qty = $_POST['qty']; // Retrieve the quantity from the form
    
    // Fetch the seller's name and qty based on the product name
    $sqlSeller = "SELECT seller_name, qty FROM wishlist WHERE product_name = ?";
    $stmtSeller = mysqli_prepare($conn, $sqlSeller);

    if (!$stmtSeller) {
        die("Error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmtSeller, "s", $productName);
    if (!mysqli_stmt_execute($stmtSeller)) {
        die("Error executing statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_result($stmtSeller, $sellerName, $qtyFromWishlist);
    mysqli_stmt_fetch($stmtSeller);
    mysqli_stmt_close($stmtSeller);

    // Prepare the insertion query
    $insertQuery = "INSERT INTO user_add_to_card (user_name, seller_name, product_name, qty, product_price, product_image) VALUES (?, ?, ?, ?, ?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertQuery);

    // Check if statement preparation succeeded
    if ($insertStmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($insertStmt, "ssssss", $fullName, $sellerName, $productName, $qtyFromWishlist, $productPrice, $productImage);

        // Execute the statement
        if (mysqli_stmt_execute($insertStmt)) {
             // Delete the product from the wishlist after adding to cart
             $deleteQuery = "DELETE FROM wishlist WHERE sno=?";
             $deleteStmt = mysqli_prepare($conn, $deleteQuery);
             mysqli_stmt_bind_param($deleteStmt, "i", $productId);
             mysqli_stmt_execute($deleteStmt);
             mysqli_stmt_close($deleteStmt);
 
            // Redirect the user to another page to prevent form resubmission
            header("Location: user_Wishlist.php"); // Change "success.php" to the desired URL
            exit(); // Terminate the script to ensure the redirection takes effect
        } else {
            echo "Error adding product to cart: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($insertStmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP Cloth</title>
    <link rel="shortcut icon" type="image/x-icon" href="/image/icon1.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
    * {
        padding: 0%;
        margin: 0%
    }
    </style>

</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div class="bg-dark col-4 col-sm-3  col-md-3 col-lg-3 vh-100 d-flex flex-column justify-content-between">
                <?php require 'user_side_bar.php'?>
            </div>
            <!-- start  -->
            <div class="col-8 col-sm-9">
                <div class="p-3">
                    <div class="col-12 d-flex ">

                        <div class="col-12 col-md-12 col-lg-10">
                            <h2 class="fw-normal fs-3  me-3">Card</h2>

                            <div class="table-container" style="max-height: 820px; overflow-y: auto;">
                                <style>
                                .table-container::-webkit-scrollbar {
                                    width: 0;
                                }
                                </style>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Product Desc</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">QTY</th>
                                                <th scope="col">Total</th>
                                                <th scope="col"></th>
                                                <th scope="col"></th> <!-- Add this column for Add to Cart button -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                    $query = "SELECT `sno`, `user_name`, `seller_name`, `product_name`, `qty`, `product_price`, `product_image`, `product_dt` FROM wishlist WHERE user_name = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    if (!$stmt) {
                        die("Error: " . mysqli_error($conn)); // Print the error if preparation fails
                    }
                    mysqli_stmt_bind_param($stmt, "s", $fullName);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    // Check if the query was executed successfully
                    if ($result === false) {
                        die("Error: " . mysqli_error($conn));
                    }

                    $totalPrice = 0; // Initialize total price variable

                    if (mysqli_num_rows($result) > 0) {
                        // Prepare the insertion query for product details
                        $sqlProducts = "INSERT INTO product_details (order_id, product_name, product_price, seller_name) VALUES (?, ?, ?, ?)";
                        $stmtProducts = mysqli_prepare($conn, $sqlProducts);
                        if (!$stmtProducts) {
                            die("Error: " . mysqli_error($conn));
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                            $qty = $row['qty']; // Assuming qty is fetched from the database
                            $productPrice = $row['product_price'];
                            // Ensure $productPrice is a numeric value
                            if (!is_numeric($productPrice)) {
                                continue; // Skip this iteration if $productPrice is not numeric
                            }

                            // Calculate subtotal for each product
                            $subtotal = $qty *$productPrice;
                            $totalPrice += $subtotal; // Add subtotal to total price

                            echo "<tr>";
                            echo "<td style='width:15vh;'><img src='" . $row['product_image'] . "' class='card-img-top  ' alt='" . $row['product_name'] . "'></td>";
                            echo "<td>" . $row['product_name'] . "</td>";
                            echo "<td>" . $productPrice . "</td>";
                            echo "<td>" . $qty . "</td>";
                            echo "<td class='total-price'>" . $subtotal . "</td>";
                            echo "<td><button class='delete btn btn-sm btn-primary' id='d{$row['sno']}'>Delete</button></td>";
                            echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='productId' value='{$row['sno']}'>
                                <input type='hidden' name='productName' value='{$row['product_name']}'>
                                <input type='hidden' name='productPrice' value='{$productPrice}'>
                                <input type='hidden' name='productImage' value='{$row['product_image']}'>
                                <button type='submit' class='addToCart btn btn-sm btn-success' name='addToCart'>Add to Cart</button>
                                <input type='hidden' name='qty' value='<?php echo $qty; ?>'>
                            </form>
                        
                                </td>"; // Add to Cart button
                            echo "</tr>";
                            
                            // Bind parameters and execute the statement to insert product details
                            mysqli_stmt_bind_param($stmtProducts, "isds", $orderId, $row['product_name'], $productPrice, $sellerName);
                            if (!mysqli_stmt_execute($stmtProducts)) {
                                die("Error: " . mysqli_error($conn));
                            }
                        }
                        // Close the statement for product details
                        mysqli_stmt_close($stmtProducts);
                    } else {
                        echo "<tr><td colspan='7'>No products found</td></tr>";
                    }

                    // Output the total price row after the while loop
                    // echo "<tr><td colspan='4'><strong>Total Price:</strong></td><td><strong>{$totalPrice}</strong></td><td></td></tr>";
                    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


        <!-- Bootstrap JavaScript dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Delete and Add to Cart script -->
        <script>
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("delete ");
                sno = e.target.id.substr(1, );


                if (confirm("Are you sure you want to delete this item?")) {
                    console.log("yes");
                    window.location = `user_Wishlist.php?delete=${sno}`; // chage the path
                    // TODO: create a form and use post request to submit a form
                } else {
                    console.log("No");
                }

            })
        })
        </script>


</body>

</html>
