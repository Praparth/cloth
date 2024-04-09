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

// Fetch seller's name from the database
$query = "SELECT seller_name , qty , product_image FROM user_add_to_card WHERE user_name = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $fullName);
if (mysqli_stmt_execute($stmt)) {
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $sellerName = $row['seller_name'];
        $_SESSION['seller_name'] = $sellerName;
    } else {
        $sellerName = "Not Available";
    }
} else {
    $sellerName = "Not Available";
}

// Close prepared statement
mysqli_stmt_close($stmt);

// Process delete action
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $deleteQuery = "DELETE FROM user_add_to_card WHERE sno=?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $sno);
    if (mysqli_stmt_execute($deleteStmt)) {
        // Redirect to avoid re-submission on page refresh
        header("Location: user_add_card_confirmation.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
    mysqli_stmt_close($deleteStmt);
}

// Retrieve products from the database
$queryProducts = "SELECT sno, product_name, product_price, qty, product_image FROM user_add_to_card WHERE user_name = ?";
$stmtProducts = mysqli_prepare($conn, $queryProducts);
mysqli_stmt_bind_param($stmtProducts, "s", $fullName);
mysqli_stmt_execute($stmtProducts);
$resultProducts = mysqli_stmt_get_result($stmtProducts);

// Initialize an empty array to store products
$products = [];

// Fetch products and store them in the products array
if (mysqli_num_rows($resultProducts) > 0) {
    while ($rowProduct = mysqli_fetch_assoc($resultProducts)) {
        $products[] = $rowProduct;
    }
}

// Calculate the total amount of prices of all products
$totalPrice = 0;
foreach ($products as $product) {
    $totalPrice += $product['product_price'] * $product['qty']; // Multiply price with quantity
}

// Store total price in session
$_SESSION['total_price'] = $totalPrice;

echo $totalPrice;
echo $product['qty'];

// Store products array in session
$_SESSION['products'] = $products;

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>pp cloth</title>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h4>CHECKOUT</h4>
            <h5>Ecommerce / Checkout</h5>
        </div>

        <div class="d-flex">
            <div class="d-flex flex-column col-md-3 mt-5">
                <div class="box p-3 bg-light text-center mx-2">
                    <a href="user_add_card_Address.php" class="text-decoration-none text-dark">
                        <i class="fas fa-truck-fast fa-3x"></i>
                        <p>Shipping Info</p>
                    </a>
                </div>
                <div class="box p-3 bg-primary  text-center text-white mx-2 my-5">
                    <a href="user_add_card_confirmation.php" class="text-decoration-none text-dark">
                        <i class="fas fa-square-check fa-3x"></i>
                        <p>Confirmation</p>
                    </a>
                </div>
                <div class="box p-3 bg-light text-center  ">
                    <a href="user_add_card_payment.php" class="text-decoration-none text-dark">
                        <i class="fas fa-money-bill fa-3x"></i>
                        <p>Payment Info</p>
                    </a>
                </div>
            </div>

            <div class="p-3 bg-light col-md-9">
                <div id="summary" class="border p-3">
                    <h3>Order Summary</h3>
                    <div class="table-container" style="max-height: 500px; overflow-y: auto;">
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
                                        <th scope="col">Price</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">Total</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Output product details fetched from the session
                                    if (!empty($_SESSION['products'])) {
                                        foreach ($_SESSION['products'] as $product) {
                                            // Check if the necessary array keys exist
                                            if (isset($product['product_price'], $product['product_name'], $product['qty'], $product['product_image'], $product['sno'])) {
                                                $productPrice = $product['product_price'];
                                                $quantity = $product['qty'];
                                                $subtotal = $productPrice * $quantity; // Calculate subtotal by multiplying price with quantity
                                                $totalPrice += $subtotal; // Add subtotal to total price
                                        
                                                // Display the product details in table rows
                                                echo "<tr>";
                                                echo "<td><img src='" . $product['product_image'] . "' alt='" . $product['product_name'] . "' style='width: 100px; height: 100px;'></td>";
                                                echo "<td>" . $product['product_price'] . "</td>";
                                                echo "<td>" . $quantity . "</td>";
                                                echo "<td>" . $subtotal . "</td>"; // Display subtotal
                                                echo "<td><button class='delete btn btn-sm btn-primary' data-sno='{$product['sno']}'>Delete</button></td>";
                                                echo "</tr>";
                                            } else {
                                                echo "<tr><td colspan='5'>Product details are incomplete or not available</td></tr>";
                                            }
                                        }
                                    }
                                        
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-9 offset-md-3">
                            <h5>Total Amount: Rs<?php echo $totalPrice = $totalPrice/2; ?></h5>
                        </div>
                    </div>
                    <div class="row mt-3 d-flex ">
                        <div class="col-md-9 offset-md-3 justify-content-center ">
                            <a href="user_add_to_card.php" class="text-decoration-none me-2">Back to shopping
                                cart</a>
                            <button type="submit" class="btn btn-primary">
                                <a href="user_add_card_payment.php" class="text-decoration-none text-light">Proceed
                                    to Shipping</a>
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript for delete functionality -->
    <script>
        $(document).ready(function() {
            $('.delete').click(function() {
                var sno = $(this).data('sno');
                if (confirm("Are you sure you want to delete this product?")) {
                    window.location.href = 'user_add_card_confirmation.php?delete=' + sno;
                }
            });
        });
    </script>
</body>

</html>
