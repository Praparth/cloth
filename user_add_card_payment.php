<?php
// Start session
session_start();

    // Access user data from session
    if (!isset($_SESSION['login_user'])) {
        header("Location: user_login_profile.php");
        exit();
    }

// Retrieve shipping information from session
$shippingInfo = $_SESSION['shipping_info'];

// Check if 'products' array is set in the session
if (isset($_SESSION['products'])) {
    $products = $_SESSION['products'];

    // Calculate total payment amount
    $totalPrice = 0;
    foreach ($products as $product) {
        $totalPrice += $product['product_price']; // Assuming each product price is stored in 'product_price' key
    }

    
    // Retrieve user name from session
    $userName = $_SESSION['login_user'];

// Access the total price from session
if (isset($_SESSION['total_price'])) {
    $totalPrice = $_SESSION['total_price'];
    // Now you can use $totalPrice variable as needed
} else {
    // Handle the case when total price is not set in session
}

echo $totalPrice;   
echo $product['qty'];


    // Database connection code here
    $host = 'localhost'; // Update with your actual host
    $username = 'root'; // Update with your actual username
    $password = ''; // Update with your actual password
    $database = 'cloth'; // Update with your actual database name

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
        // Retrieve payment option from form
        $paymentOption = $_POST['payment'];
        
        // Loop through products to gather seller names
        $sellerNames = array();
        foreach ($products as $product) {
            // Fetch the seller's name based on the product name
            $product_name = $product['product_name'];
            $sqlSeller = "SELECT seller_name FROM user_add_to_card WHERE product_name = ?";
            $stmtSeller = mysqli_prepare($conn, $sqlSeller);

            if (!$stmtSeller) {
                die("Error: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmtSeller, "s", $product_name);
            if (!mysqli_stmt_execute($stmtSeller)) {
                die("Error executing statement: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_result($stmtSeller, $sellerName);
            mysqli_stmt_fetch($stmtSeller);
            mysqli_stmt_close($stmtSeller);

            // Add seller name to the array
            $sellerNames[] = $sellerName;
        }

        // Combine seller names into a single string
        $sellerNamesString = implode(", ", $sellerNames);

        // Prepare insert query for shipping info
        $sqlShipping = "INSERT INTO shipping_info (order_id, name, email, phone, address, country, state, order_notes, seller_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtShipping = mysqli_prepare($conn, $sqlShipping);
        mysqli_stmt_bind_param($stmtShipping, "issssssss",
            $orderId,
            $shippingInfo['name'],
            $shippingInfo['email'],
            $shippingInfo['phone'],
            $shippingInfo['address'],
            $shippingInfo['country'],
            $shippingInfo['state'],
            $shippingInfo['order_notes'],
            $sellerNamesString // Use the combined seller names
        );

        // Execute the insert query for shipping info
        if (!mysqli_stmt_execute($stmtShipping)) {
            die("Error: " . mysqli_error($conn));
        }
    


        // Get the ID of the inserted order
        $orderId = mysqli_insert_id($conn);

        // Loop through products to insert each one into product_details table
        foreach ($products as $product) {
            // Fetch the seller's name based on the product name
            $product_name = $product['product_name'];
            $sqlSeller = "SELECT seller_name FROM product WHERE product_name = ?";
            $stmtSeller = mysqli_prepare($conn, $sqlSeller);
        
            if (!$stmtSeller) {
                die("Error: " . mysqli_error($conn));
            }
        
            mysqli_stmt_bind_param($stmtSeller, "s", $product_name);
            if (!mysqli_stmt_execute($stmtSeller)) {
                die("Error executing statement: " . mysqli_error($conn));
            }
        
            mysqli_stmt_bind_result($stmtSeller, $sellerName);
            mysqli_stmt_fetch($stmtSeller);
            mysqli_stmt_close($stmtSeller);
        
            // Insert product details into product_details table with user_name
            $stmtProducts = "INSERT INTO product_details (order_id, product_image, product_name, product_price, product_qty, seller_name, user_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtProducts = mysqli_prepare($conn, $stmtProducts);
            
            if ($stmtProducts === false) {
                die("Error in preparing statement: " . mysqli_error($conn));
            }
            
            // Assuming $orderId, $product['product_image'], $product['product_name'], $product['product_price'], $product['qty'], $sellerName, $userName are defined elsewhere
            mysqli_stmt_bind_param($stmtProducts, "issdsss", $orderId, $product['product_image'], $product['product_name'], $product['product_price'], $product['qty'], $sellerName, $userName);
            
            if (!mysqli_stmt_execute($stmtProducts)) {
                die("Error in executing statement: " . mysqli_error($conn));
            }
                 
            // Delete the product from user_add_to_card table
            $deleteQuery = "DELETE FROM user_add_to_card WHERE user_name = ? AND product_name = ? AND product_price = ?";
            $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        
            // Check if statement preparation succeeded
            if ($deleteStmt === false) {
                die("Error preparing delete statement: " . mysqli_error($conn));
            }
        
            // Assuming $product_name is defined earlier in your code
            mysqli_stmt_bind_param($deleteStmt, "sss", $userName, $product_name, $product['product_price']);
        
            // Execute the delete statement
            if (!mysqli_stmt_execute($deleteStmt)) {
                die("Error executing delete statement: " . mysqli_error($conn));
            }
        
            // Close the delete statement
            mysqli_stmt_close($deleteStmt);
        }
        
        // Prepare insert query for payment details
        $sqlPayment = "INSERT INTO payment_details (order_id, payment_option, total_payment) VALUES (?, ?, ?)";
        $stmtPayment = mysqli_prepare($conn, $sqlPayment);
        mysqli_stmt_bind_param($stmtPayment, "iss", $orderId, $paymentOption, $totalPrice); // Assuming $totalPrice contains the total payment amount

        // Execute the insert query for payment details
        if (!mysqli_stmt_execute($stmtPayment)) {
            die("Error: " . mysqli_error($conn));
        }
       
        foreach ($products as $product) {
            $product_name = $product['product_name'];
            $product_price = $product['product_price'];
            $seller_name = $sellerName; // Assuming the seller name is the currently logged-in user
            $product_qty = $product['qty']; // Assuming quantity is stored under 'qty' key in the session
        
        
            // Update product quantity by subtracting the session quantity
            $updateQuery = "UPDATE product SET product_qty = product_qty - ? WHERE product_name = ? AND product_price = ? AND seller_name = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            
            if ($updateStmt === false) {
                die("Error preparing update statement: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($updateStmt, "dsss", $product_qty, $product_name, $product_price, $seller_name);
            
            if (!mysqli_stmt_execute($updateStmt)) {
                die("Error executing update statement: " . mysqli_error($conn));
            }
        
            // Close the update statement
            mysqli_stmt_close($updateStmt);
        }
        



        // Close prepared statements
        mysqli_stmt_close($stmtShipping);
        mysqli_stmt_close($stmtProducts);
        mysqli_stmt_close($stmtPayment);
        
        // Close database connection
        mysqli_close($conn);

        // Redirect to a success page or do any further processing
        header("Location: user_payment_submit.php"); // Redirect to success page
        exit();
    }
} else {
    
    echo "No products found in the session.";
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Payment</title>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h4>CHECKOUT</h4>
            <h5>Ecommerce / Checkout</h5>
        </div>

        <div class="d-flex col-12">
            <div class="d-flex flex-column col-md-3 mt-5">
                <div class="box p-3 bg-light text-center ">
                    <a href="user_add_card_Address.php" class="text-decoration-none text-dark">
                        <i class="fas fa-truck-fast fa-3x"></i>
                        <p>Shipping Info</p>
                    </a>
                </div>
                <div class="box p-3 bg-light text-center mx-2 my-5">
                    <a href="user_add_card_confirmation.php" class="text-decoration-none text-dark">
                        <i class="fas fa-square-check fa-3x"></i>
                        <p>Confirmation</p>
                    </a>
                </div>
                <div class="box p-3 bg-primary text-center text-white mx-2">
                    <a href="user_add_card_payment.php" class="text-decoration-none text-dark">
                        <i class="fas fa-money-bill fa-3x"></i>
                        <p>Payment Info</p>
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div id="information">
                    <div id="shipping" class="bg-white p-3">
                        <h3 class="fw-normal">Shipping information</h3>
                        <h4 class="text-secondary">Fill All Information below</h4>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div id="payment" class="mt-3">
                                <input type="radio" name="payment" id="credit" class="me-2" value="credit">
                                <label for="credit" class="me-4">Credit / Debit Card</label>

                                <!-- <input type="radio" name="payment" id="paypal" class="me-2" value="paypal">
                                <label for="paypal" class="me-4">Paypal</label>

                                <input type="radio" name="payment" id="cash" class="me-2" value="cash">
                                <label for="cash">Cash on Delivery</label>
                            </div> -->
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <a href="user_add_card_confirmation.php" class="text-decoration-none me-2">Back to
                                        confirmation</a>
                                    <button type="submit" name="submit" class="btn btn-primary">Proceed to
                                        Payment</button> 
                                    
                                    
                                  
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>