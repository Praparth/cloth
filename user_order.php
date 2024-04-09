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
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div class="bg-dark col-4 col-sm-3 col-md-3 col-lg-3 vh-100 d-flex flex-column justify-content-between">
                <?php require 'user_side_bar.php'?>
            </div>
            <div class="col-8 col-sm-9">
                <div class="p-3">
                    <div class="col-10 d-flex ">
                        <div class="col-12 col-md-12 col-lg-10">
                            <h2 class="fw-normal fs-3 me-3">Add To Card</h2>
                            <div class="table-container" style="width:70vw;  max-height: 88vh; overflow-y: auto;">
                                <style>
                                .table-container::-webkit-scrollbar {
                                    width: 0;
                                }
                                </style>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">User Information</th>
                                            <th scope="col">Product Price</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
            $query = "SELECT DISTINCT
                pd.product_image,
                pd.product_name, 
                pd.product_price, 
                pd.seller_status,
                
                pd.product_dt,
                si.name, 
                si.address, 
                si.phone, 
                si.state, 
                si.email,
                pd.order_id,
                p.total_payment
                FROM 
                shipping_info AS si 
                INNER JOIN 
                product_details AS pd ON si.id = pd.order_id
                INNER JOIN 
                payment_details AS p ON si.id = p.order_id
                WHERE 
                si.name = ? 
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
                            echo "<td>#{$row['order_id']}</td>";
                            echo "<td>";
                            echo "<p><strong>Name:</strong> {$row['name']}</p>";
                            echo "<p><strong>Address:</strong> {$row['address']}</p>";
                            echo "<p><strong>Phone Number:</strong> {$row['phone']}</p>";
                            echo "<p><strong>Status:</strong> ";

                            // Logic to determine product status based on seller_status and admin_status
                            if ($row['seller_status'] == 'active' && $row['admin_status'] == 'active' && strtotime($row['product_dt']) <= strtotime('+3 days')) {
                                echo "Product on the way";
                            } elseif ($row['seller_status'] == 'active' && $row['admin_status'] == 'active') {
                                echo "Product in production";
                            } elseif ($row['seller_status'] != 'active' || $row['admin_status'] != 'active') {
                                echo "Product pending";
                            }

                            echo "</p>";
                            echo "<p><strong>Email Address:</strong> {$row['email']}</p>";
                            echo "</td>";
                            echo "<td>{$row['total_payment']}</td>";
                            
                            // Add status and time columns
                            echo "<td>";
                            // Display product status
                          // Logic to determine product status and apply Bootstrap classes for different statuses
                          if ($row['seller_status'] == 'Active' && strtotime($row['product_dt']) <= strtotime('+3 days')) {
                            echo "<span class='badge bg-success'>On the way</span>";
                        } elseif ($row['seller_status'] == 'Active') {
                            echo "<span class='badge bg-warning text-dark'>In production</span>";
                        } else {
                            echo "<span class='badge bg-danger'>Pending</span>";
                        }
                        echo "</td>";
                        
                            echo "</td>";
                            // Display product time
                            echo "<td>";
                            // Display product date with 3 days added
                            if (!empty($row['product_dt'])) {
                                $productDate = date('Y-m-d', strtotime($row['product_dt'] . ' +3 days'));
                                echo $productDate;
                            } else {
                                echo "";
                            }
                            echo "</td>";
                            
                            
                            // Action column remains the same
                            echo "<td id='{$row['order_id']}'> <a href='#' class='nav-link d-flex flex-column imageClick'> <!-- Anchor element with some classes -->
                                <span>Order Receipt</span>
                                </a> </td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No products found</td></tr>";
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
                </div>
            </div>
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

    <script>
    document.querySelectorAll(".imageClick").forEach(function(element) {
        element.addEventListener("click", function() {
            // Get the ID of the clicked image
            var imageId = element.parentNode.id;

            // Construct the URL with the image ID as a query parameter
            //var url = "user_product.php?imageId=" + encodeURIComponent(imageId);
            var url = "user_product_recipt.php?imageId=" + encodeURIComponent(imageId);

            // Redirect to another page with the image ID in the URL
            window.location.href = url;
        });
    });
    </script>
</body>

</html>