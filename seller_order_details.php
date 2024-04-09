<?php
// Start session
session_start();

    
// Check if user is logged in
if (!isset($_SESSION['login_seller'])) {
    // Redirect to login page if user is not logged in
    header("Location: seller.php");
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

// Check if the image ID is present in the query parameters
if(isset($_GET['imageId'])) {
    // Retrieve the image ID from the query parameters
    $imageId = mysqli_real_escape_string($conn, $_GET['imageId']);

    // Store the image ID in the session
    $_SESSION['imageId'] = $imageId;

    // Fetch data or perform actions based on the image ID
    // You can perform further processing or database queries based on the image ID
    // echo "Image ID: " . $imageId;
} else {
    // If image ID is not present in the query parameters, handle it accordingly
    echo "Image ID not found in the query parameters.";
    exit; // Stop further execution as imageId is required for filtering
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
    /* Custom styles */
    /* You can customize this as per your design requirements */
    .receipt-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .receipt-details {
        margin-bottom: 20px;
    }

    .receipt-details p {
        margin: 5px 0;
    }

    .receipt-items {
        border-collapse: collapse;
        width: 100%;
    }

    .receipt-items th,
    .receipt-items td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .receipt-total {
        margin-top: 20px;
        text-align: right;
    }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div class="bg-dark col-4 col-sm-3  col-md-3 col-lg-3 vh-100 d-flex flex-column justify-content-between">
                <?php require 'seller_side_bar.php'?>
            </div>
            <!-- start  -->
            <div class="col-8 col-sm-9">
                <div class="p-3">

                    <!-- ------------------------------------------------------------------------------------------------ -->
                    <!-- user data inser Form  (start) -->
                    <div class="table-container" style="max-height: 95vh; overflow-y: auto;">
                        <style>
                        .table-container::-webkit-scrollbar {
                            width: 0;
                        }
                        </style>
                        <div class="receipt-container">
                            <div class="receipt-header">
                                <h2>Order Details</h2>
                            </div>
                            <div class="receipt-details">
                                <?php 
                           $sql = "SELECT `id`, `order_id`, `name`, `email`, `phone`, `address`, `country`, `state`, `order_notes`, `seller_name`, `shipping_dt` FROM `shipping_info` WHERE `id` = $imageId";

                           $result = $conn->query($sql);
                           if ($result->num_rows > 0) {
                             // Output data of each row
                             while($row = $result->fetch_assoc()) {
                               $fullName = $row["name"];
                               $email = $row["email"];
                               $shipping_dt = $row["shipping_dt"];
                               $addres = $row["address"];
                               $phone = $row["phone"];
                               $state = $row["state"];

                           ?>
                                <div class="receipt-container">
                                    <div class="receipt-header">

                                    </div>
                                    <div class="receipt-details d-flex justify-content-between ">
                                        <span>
                                        <p><strong>Date:</strong> <?php echo $shipping_dt ?></p>
                                        <p><strong>Order ID:</strong> #<?php echo $imageId ?></p>
                                        <p><strong>Customer:</strong> <?php echo $fullName; ?></p>
                                        <p><strong>Email:</strong> <?php echo $email; ?></p>
                                        </span>
                                        <span>
                                        <p><strong>Address:</strong> <?php echo $addres; ?> </p>
                                        <p><strong>Phone Number:</strong> <?php echo $phone; ?> </p>
                                        <p><strong>Status:</strong> <?php echo $state; ?> </p>
                                        </span>
                                    </div>
                                    <!-- Add other receipt details as needed -->
                                </div>
                                <?php
                             }
                           } else {
                             echo "0 results";
                           }
                           ?>
                            </div>

                            <!-- ------------------------------------------------------------------- -->

                            <table class="table">
                                <thead>
                                    <tr>

                                        <th scope="col">User Information</th>
                                        <th scope="col">Product Price</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            $query = "SELECT  
                                                        pd.product_image,
                                                        pd.product_name, 
                                                        pd.product_price, 
                                                        pd.product_qty,
                                                        
                                                        si.name, 
                                                        si.address, 
                                                        si.phone, 
                                                        si.state, 
                                                        si.email,
                                                        pd.order_id
                                                    FROM 
                                                        shipping_info AS si 
                                                    INNER JOIN 
                                                        product_details AS pd ON si.id = pd.order_id
                                                    WHERE 
                                                        pd.order_id = ?";

                                            $total_price = 0;
                                            

                                            $stmt = mysqli_prepare($conn, $query);
                                            if ($stmt) {
                                                mysqli_stmt_bind_param($stmt, "s", $imageId);
                                                if (mysqli_stmt_execute($stmt)) {
                                                    $result = mysqli_stmt_get_result($stmt);
                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<tr>";
                                                            // Output product and shipping details
                                                            
                                                            echo "<td>";
                                                            
                                                            echo "<p><strong>Product Name:</strong> {$row['product_name']}</p>";
                                                            
                                                            // Adjusting quantity if it's 0
                                                            $quantity = ($row['product_qty'] == 0) ? 1 : $row['product_qty'];
                                                            echo "<p><strong>Qty:</strong> $quantity</p>";
                                                            echo "</td>";

                                                            echo "<td>" ;
                                                            echo"{$row['product_price']}";
                                                            "</td>";
                                                            echo "</tr>";
                                                            
                                                            // Adding product price to total price
                                                            $total_price += $row['product_price'] * $quantity;
                                            
                                                            "</td>";
                                                            echo "</tr>";
                                                            
                                                            // Adding product price to total price
                                                            
                                                            // echo "Total Price: $total_price";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='2'>No products found</td></tr>";
                                                    }
                                                } else {
                                                    echo "Error executing statement: " . mysqli_error($conn);
                                                }
                                                mysqli_stmt_close($stmt);
                                            } else {
                                                echo "Error in preparing statement: " . mysqli_error($conn);
                                            }

                                            // Close the database connection
                                            mysqli_close($conn);
                                            ?>



                                </tbody>
                            </table>
                            <div class="receipt-total">
                                <p><strong>Total:</strong> <?php echo $total_price?></p>
                            </div>
                        </div>
                    </div>

                    <!-- user data inser Form  (end) -->
                    <!-- ------------------------------------------------------------------------------------------------ -->

                    <!-- user data be update (Start) -->

                    <!-- user data be update (End) -->

                    <!-- ------------------------------------------------------------------------------------------------ -->

                    <!-- user data be so on screen (start) -->


                    <!-- user data be so on screen (end) -->

                    <!-- ------------------------------------------------------------------------------------------------ -->

                </div>
            </div>

            <!-- end -->
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>




</body>

</html>