<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['login_seller'])) {
    // Redirect to login page if user is not logged in
    header("Location: seller.php");
    exit();
}

// Access user data from session
$fullName = $_SESSION['login_seller'];

// Connect to your MySQL database
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "cloth"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['status_update'])) {
    // Check if order_id and status are set
    if (isset($_POST['order_id']) && isset($_POST['status'])) {
        // Prepare update statement
        $stmt = mysqli_prepare($conn, "UPDATE product_details SET seller_status = ? WHERE order_id = ?");
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "si", $_POST['status'], $_POST['order_id']);

        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            // echo "Status updated successfully";
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Order ID and status are required";
    }
} else {
    // echo "Invalid request";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP Cloth</title>
    <link rel="shortcut icon" type="image/x-icon" href="/image/icon1.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div class="bg-dark col-4 col-sm-3 col-md-3 col-lg-3 vh-100 d-flex flex-column justify-content-between">
                <?php require 'seller_side_bar.php'?>
            </div>
            <!-- start -->
            <div class="col-8 col-sm-9">
                <div class="">
                    <!-- user data inser Form  (start) --> 
                    <div class="col-10 d-flex ">
                        <div class="col-12 col-md-12 col-lg-10">
                            <h2 class="fw-normal fs-3 me-3">Add To Card</h2>
                            <div class="table-container " style="width:70vw; max-height: 90vh; overflow-y: auto;">
                                <style>
                                .table-container::-webkit-scrollbar {
                                    width: 0;
                                }
                                </style>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product Image</th>
                                            <th scope="col">User Information</th>
                                            <th scope="col">Product Price</th>
                                            <th scope="col">Product details</th>
                                            <th scope="col">Product Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
$query = "SELECT  
            pd.product_image,
            pd.product_name, 
            pd.product_price, 
            pd.product_qty,
            pd.seller_status,
            pd.order_id,
            SUM(CASE WHEN pd.product_qty = 0 THEN 1 ELSE pd.product_qty END) AS total_qty,
            SUM(pd.product_price * CASE WHEN pd.product_qty = 0 THEN 1 ELSE pd.product_qty END) AS total_product_price,
             si.name, 
            si.address, 
            si.phone, 
            si.state, 
            si.email
            FROM 
            shipping_info AS si 
            INNER JOIN 
            product_details AS pd ON si.id = pd.order_id
            WHERE 
            pd.seller_name = ?
            GROUP BY 
            pd.order_id";

$stmt = mysqli_prepare($conn, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $fullName);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                // Output product and shipping details
                echo "<td><img src='{$row['product_image']}' alt='Product Image' style='width: 100px; height: 100px;'></td>";
                echo "<td>";
                echo "<p><strong>Name:</strong> {$row['name']}</p>";
                echo "<p><strong>Address:</strong> {$row['address']}</p>";
                echo "<p><strong>Phone Number:</strong> {$row['phone']}</p>";
                echo "<p><strong>Status:</strong> {$row['state']}</p>";
                echo "<p><strong>Email Address:</strong> {$row['email']}</p>";
                echo "</td>";
                echo "<td>{$row['total_product_price']}</td>"; // Total product price
                 // Action column remains the same
                 echo "<td id='{$row['order_id']}'> <a href='#' class='nav-link d-flex flex-column imageClick'> <!-- Anchor element with some classes -->
                 <span>Order Receipt</span>
                 </a> </td>";
                // Dropdown for updating product status
                echo "<td>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='order_id' value='{$row['order_id']}'>";
                echo "<select class='form-select' name='status'>";
                echo "<option value='Pending' " . ($row['seller_status'] == 'Pending' ? 'selected' : '') . ">Pending</option>";
                echo "<option value='Active' " . ($row['seller_status'] == 'Active' ? 'selected' : '') . ">Active</option>";
                // Add more options if needed
                echo "</select>";
                echo "</td>";
                echo "<td>";
                echo "<button type='submit' class='btn btn-primary' name='status_update'>Update</button>";
                echo "</td>";
                echo "</form>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No products found</td></tr>";
        }
    } else {
        echo "Error executing statement: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error in preparing statement: " . mysqli_error($conn);
}
?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- user data inser Form  (end) --> 
                </div>
            </div>
        </div>
    </div>


    <script>
    document.querySelectorAll(".imageClick").forEach(function(element) {
        element.addEventListener("click", function() {
            // Get the ID of the clicked image
            var imageId = element.parentNode.id;

            // Construct the URL with the image ID as a query parameter
            //var url = "user_product.php?imageId=" + encodeURIComponent(imageId);
            var url = "seller_order_details.php?imageId=" + encodeURIComponent(imageId);

            // Redirect to another page with the image ID in the URL
            window.location.href = url;
        });
    });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>
