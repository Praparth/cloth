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

// Database connection parameters
$servername = "localhost"; // Usually "localhost"
$username = "root";
$password = "";
$database = "cloth";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// <!-- -------------------------------------------- Total sell ---------------------------------------------------- -->

// Assuming you have already established a connection to your database

// Perform a SQL query to count the number of entries in the 'First_name' column in the 'profile' table
$sql = "SELECT COUNT(*) AS total_first_names FROM product_details WHERE seller_name = '$fullName'";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch the row as an associative array
    $row = mysqli_fetch_assoc($result);
    
    // Get the total number of entries in the 'First_name' column
    $totalFirstNames = $row['total_first_names'];
    
    // Return the total number of entries
    // echo $totalFirstNames;
} else {
    // Return an error message if the query fails
    echo "Error: " . mysqli_error($conn);
}

// <!-- --------------------------------------------  Total Product ---------------------------------------------------- -->

// Perform a SQL query to count the number of entries in the 'Seller' column in the 'seller_register' table
$sql = "SELECT COUNT(*) AS total_Seller FROM product WHERE seller_name = '$fullName'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch the row as an associative array
    $row = mysqli_fetch_assoc($result);
    
    // Get the total number of entries in the 'Seller' column
    $totalSeller = $row['total_Seller'];
    
    // Return the total number of entries
    // echo $totalSeller;
} else {
    // Return an error message if the query fails
    echo "Error: " . mysqli_error($conn);
}

// <!-- ---------------------------------------------- Total sell -------------------------------------------------- -->

// Perform a SQL query to calculate the total payment in the 'payment_details' table
$sql = "SELECT SUM(product_price) AS product_price FROM product_details WHERE seller_name = '$fullName'" ;
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch the row as an associative array
    $row = mysqli_fetch_assoc($result);
    
    // Get the total payment
    $totalPayment = $row['product_price'];
    
   
} else {
    // Display an error message if the query fails
    // echo "Error: " . mysqli_error($conn);
}

// <!-- ------------------------------------------------ Today payment ------------------------------------------------ -->
// Get today's date
$todayDate = date("Y-m-d");

// Initialize $totalTodayPayment to 0
$totalTodayPayment = 0;

// Perform a SQL query to calculate the total payment for today in the 'product_details' table
$sql = "SELECT SUM(product_price) AS today_total_payment 
        FROM product_details 
        WHERE DATE(product_dt) = '$todayDate' 
        AND seller_name = '$fullName'";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Check if the query returned any rows
    if (mysqli_num_rows($result) > 0) {
        // Fetch the row as an associative array
        $row = mysqli_fetch_assoc($result);

        // Get the total payment for today
        $totalTodayPayment = $row['today_total_payment'];
    }
} else {
    // Display an error message if the query fails
    echo "Error: " . mysqli_error($conn);
}

// Output the total payment for today
 $totalTodayPayment ;



// <!-- ------------------------------------------ Pyment chart ------------------------------------------------------ -->

// Function to fetch and process data for the chart

// Retrieve data from the payment_details table
$sql = "SELECT `id`, `order_id`, `user_name`, `product_name`, `product_price`, `seller_name`, `product_image`, `product_dt` FROM `product_details` WHERE `seller_name` = '$fullName'";
$result = $conn->query($sql);

// Process the data to count the number of payments on each date
$paymentCounts = array();
while ($row = $result->fetch_assoc()) {
    $paymentDate = $row['product_dt'];
    $paymentCounts[$paymentDate] = isset($paymentCounts[$paymentDate]) ? $paymentCounts[$paymentDate] + 1 : 1;
}

// Echo JSON-encoded data for debugging
// echo json_encode($paymentCounts);


// <!-- ---------------------------------------------  user register --------------------------------------------------- -->


// Retrieve data from the product_details table for the specific seller
$sql = "SELECT `id`, `order_id`, `user_name`, `product_name`, `product_price`, `seller_name`, `product_image`, `product_dt` FROM `product_details` WHERE seller_name = '$fullName'";
$result = $conn->query($sql);

// Process the data to count the number of products sold on each date
$productsSoldByDate = array();
while ($row = $result->fetch_assoc()) {
    $productDate = date('Y-m-d', strtotime($row['product_dt']));
    if (isset($productsSoldByDate[$productDate])) {
        $productsSoldByDate[$productDate]++;
    } else {
        $productsSoldByDate[$productDate] = 1;
    }
}

// <!-- -------------------------------------------------- seller Regiseter ---------------------------------------------- -->

// Retrieve data from the seller_register table for the "Number of Logins" chart
$sql = "SELECT DATE(product_upload_td) AS loginDate, COUNT(*) AS loginCount 
        FROM product 
        WHERE seller_name = '$fullName' 
        GROUP BY loginDate";

$result = $conn->query($sql);

// Process the data to count the number of logins on each date for the "Number of Logins" chart
$loginCountsTotal = array();
while ($row = $result->fetch_assoc()) {
    $loginCountsTotal[$row['loginDate']] = $row['loginCount'];
}

// <!-- ------------------------------------------------------------------------------------------------ -->




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
    <script src="path/to/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
    .message {
        padding: 10px;
        margin: 5px;
        border-radius: 10px;
    }

    .user-message {
        background-color: blue;
        color: white;
        text-align: right;
    }

    .admin-message {
        background-color: red;
        color: white;
    }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div
                class="bg-dark col-4 col-sm-3  col-md-3 col-lg-3 min-vh-100 d-flex flex-column justify-content-between">
                <?php require 'seller_side_bar.php'?>
            </div>
            <!-- start  -->
            <div class="col-8 col-sm-9">
                <div class="p-3 mt-3"
                    style="overflow-y: auto; max-height: 95vh; -ms-overflow-style: none; scrollbar-width: none;">


                    <!-- ------------------------------------------------------------------------------------------------ -->
                    <!--  (start) -->
                    <div class="d-flex justify-content-between">
                        <div class="border border-1 rounded-3  text-bg-danger  w-25   flex-fill m-2">
                            <div class="text-center p-4 fs-3 "><?php echo  $totalFirstNames?></div>
                            <!-- <div class="text-center p-4">4512</div> -->
                            <div class="text-center py-2 border border-1 border-bottom-0 border-start-0  border-end-0 ">
                                Total selle
                            </div>
                        </div>
                        <div class="border border-1 rounded-3  text-bg-info  w-25   flex-fill m-2">
                            <div class="text-center p-4 fs-3 "><?php echo  $totalSeller?></div>
                            <!-- <div class="text-center p-4">4512</div> -->
                            <div class="text-center py-2 border border-1 border-bottom-0 border-start-0  border-end-0 ">
                                Total product
                            </div>
                        </div>
                        <div class="border border-1 rounded-3 text-bg-success w-25 flex-fill m-2">
                            <div class="text-center p-4 d-flex">
                                <span class="fs-3 me-2">RS</span>
                                <?php if ($totalPayment == 0): ?>
                                <span class="mt-1 fs-4">0</span>
                                <?php else: ?>
                                <span class="mt-1 fs-4"><?php echo $totalPayment ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="text-center py-2 border border-1 border-bottom-0 border-start-0 border-end-0">
                                Total Sell
                            </div>
                        </div>

                        <div class="border border-1 rounded-3 text-bg-secondary w-25 flex-fill m-2">
                            <div class="text-center p-4 d-flex">
                                <span class="fs-3 me-2">RS</span>
                                <?php if ($totalTodayPayment > 0) : ?>
                                <span class="mt-1 fs-4"><?php echo $totalTodayPayment ?></span>
                                <?php else : ?>
                                <span class="mt-1 fs-4">0</span>
                                <?php endif; ?>
                            </div>
                            <div class="text-center py-2 border border-1 border-bottom-0 border-start-0 border-end-0">
                                Today Sell
                            </div>
                        </div>

                    </div>



                    <!--  (end) -->
                    <!-- ------------------------------------------------------------------------------------------------ -->

                    <!-- chart (Start) -->
                    <div class="d-flex my-5">
                        <div class="w-50 ">
                            <!-- Chart.js Canvas -->
                            <canvas id="paymentChart"></canvas>
                        </div>
                        <div class="w-50 ms-5">
                            <!-- Chart.js Canvas -->
                            <canvas id="loginChart"></canvas>
                        </div>

                    </div>

                    <div class="d-flex my-5 ">
                        <div class="w-75 ">
                            <canvas id="loginChart1"></canvas>
                        </div>

                    </div>

                    <!-- chart (End) -->

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    $(document).ready(function() {
        $('#Table').DataTable();
    });
    </script>


    <script>
    // JavaScript to generate the chart using Chart.js
    var ctx = document.getElementById('paymentChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($paymentCounts)); ?>,
            datasets: [{
                label: 'Number of Payments',
                data: <?php echo json_encode(array_values($paymentCounts)); ?>,
                backgroundColor: 'skyblue',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>
    <!-- ----------------------------------------------------------------------------- -->
    <script>
    // JavaScript to generate the "User Login Today" chart using Chart.js
    // Assuming you have the data in PHP variable $productsSoldByDate

    // Extracting dates and counts from PHP array
    var dates = Object.keys(<?php echo json_encode($productsSoldByDate); ?>);
    var counts = Object.values(<?php echo json_encode($productsSoldByDate); ?>);

    // Creating a new Chart instance
    var ctx = document.getElementById('loginChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [{
                label: 'Products Sold',
                data: counts,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>

    <script>
    // JavaScript to generate the "Number of Logins" chart using Chart.js
    var ctx1 = document.getElementById('loginChart1').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($loginCountsTotal)); ?>,
            datasets: [{
                label: 'Seller total Product ',
                data: <?php echo json_encode(array_values($loginCountsTotal)); ?>,
                backgroundColor: 'lightblue',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>




</body>

</html>