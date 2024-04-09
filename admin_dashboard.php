<?php
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

// <!-- -------------------------------------------- Total user ---------------------------------------------------- -->

// Assuming you have already established a connection to your database

// Perform a SQL query to count the number of entries in the 'First_name' column in the 'profile' table
$sql = "SELECT COUNT(First_name) AS total_first_names FROM profile";
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

// <!-- --------------------------------------------  Total Seller ---------------------------------------------------- -->

// Perform a SQL query to count the number of entries in the 'Seller' column in the 'seller_register' table
$sql = "SELECT COUNT(sno) AS total_Seller FROM seller_register";
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
$sql = "SELECT SUM(total_payment) AS total_payment FROM payment_details";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch the row as an associative array
    $row = mysqli_fetch_assoc($result);
    
    // Get the total payment
    $totalPayment = $row['total_payment'];
    
   
} else {
    // Display an error message if the query fails
    // echo "Error: " . mysqli_error($conn);
}

// <!-- ------------------------------------------------ Today payment ------------------------------------------------ -->

// Get today's date
$todayDate = date("Y-m-d");

// Perform a SQL query to calculate the total payment for today in the 'payment_details' table
$sql = "SELECT SUM(total_payment) AS today_total_payment FROM payment_details WHERE DATE(payment_date) = '$todayDate'";
$result = mysqli_query($conn, $sql);

// Initialize $totalTodayPayment to 0
$totalTodayPayment = 0;

// Check if the query was successful
if ($result) {
    // Check if the query returned any rows
    if (mysqli_num_rows($result) > 0) {
        // Fetch the row as an associative array
        $row = mysqli_fetch_assoc($result);

        // Get the total payment for today
        $totalTodayPayment = $row['today_total_payment'];
    }
}




// <!-- ------------------------------------------ Pyment chart ------------------------------------------------------ -->

// Function to fetch and process data for the chart

// Retrieve data from the payment_details table
$sql = "SELECT `id`, `order_id`, `payment_option`, `total_payment`, `payment_date`, `payment_time` FROM `payment_details`";
$result = $conn->query($sql);

// Process the data to count the number of payments on each date
$paymentCounts = array();
while ($row = $result->fetch_assoc()) {
    $paymentDate = $row['payment_date'];
    $paymentCounts[$paymentDate] = isset($paymentCounts[$paymentDate]) ? $paymentCounts[$paymentDate] + 1 : 1;
}

// Echo JSON-encoded data for debugging
// echo json_encode($paymentCounts);


// <!-- ---------------------------------------------  user register --------------------------------------------------- -->


// Retrieve data from the profile table for the "User Login Today" chart
$sql = "SELECT `sno`, `First_name`, `Password`, `Email`, `State`, `City`, `Zip`, `profile_date` FROM `profile`";
$result = $conn->query($sql);

// Process the data to count the number of logins on each date for the "User Login Today" chart
$loginCountsToday = array();
while ($row = $result->fetch_assoc()) {
    $loginDate = date('Y-m-d', strtotime($row['profile_date']));
    $loginCountsToday[$loginDate] = isset($loginCountsToday[$loginDate]) ? $loginCountsToday[$loginDate] + 1 : 1;
}

// <!-- -------------------------------------------------- seller Regiseter ---------------------------------------------- -->

// Retrieve data from the seller_register table for the "Number of Logins" chart
$sql = "SELECT DATE(registerTime) AS loginDate, COUNT(*) AS loginCount FROM seller_register GROUP BY loginDate";
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

    .p-3 {
        max-height: 100vh;
        overflow-y: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .p-3::-webkit-scrollbar {
        display: none;
    }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div
                class="bg-dark col-4 col-sm-3  col-md-3 col-lg-3 min-vh-100 d-flex flex-column justify-content-between">
                <?php require 'admin_side_bar.php'?>
            </div>
            <!-- start  -->
            <div class="col-8 col-sm-9">
                <div class="p-3 ">

                    <!-- ------------------------------------------------------------------------------------------------ -->
                    <!--  (start) -->
                    <div class="d-flex justify-content-between">
                        <div class="border border-1 rounded-3  text-bg-danger  w-25   flex-fill m-2">
                            <div class="text-center p-4 fs-3 "><?php echo  $totalFirstNames?></div>
                            <!-- <div class="text-center p-4">4512</div> -->
                            <div class="text-center py-2 border border-1 border-bottom-0 border-start-0  border-end-0 ">
                                Total User
                            </div>
                        </div>
                        <div class="border border-1 rounded-3  text-bg-info  w-25   flex-fill m-2">
                            <div class="text-center p-4 fs-3 "><?php echo  $totalSeller?></div>
                            <!-- <div class="text-center p-4">4512</div> -->
                            <div class="text-center py-2 border border-1 border-bottom-0 border-start-0  border-end-0 ">
                                Total Seller
                            </div>
                        </div>
                        <div class="border border-1 rounded-3  text-bg-success   w-25   flex-fill m-2">
                            <div class="text-center p-4 d-flex ">
                                <span class="fs-3 me-2">RS</span>
                                <span class="mt-1 fs-4 "> <?php echo $totalPayment ?> </span>
                            </div>
                            <!-- <div class="text-center p-4">4512</div> -->
                            <div class="text-center py-2 border border-1 border-bottom-0 border-start-0  border-end-0 ">
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
                        <div class="w-50 ms-5 ">
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
                    <!-- <h2 class="text-center my-2 mb-3  text-decoration-underline text-info  "> Product deatils be sell  </h2>
                    <div class="table-responsive  mx-auto col-11">
                        <table id="Table" class="table table-striped ">
                            <thead>
                                <tr>
                                    <th scope="col">sno</th>
                                    <th scope="col">seller_name</th>
                                    <th scope="col">product_name</th>
                                    <th scope="col">product_price</th>
                                    <th scope="col">product_detail</th>
                                    <th scope="col">product_type</th>
                                    <th scope="col">product_size</th>
                                    <th scope="col">product_color</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM `product`";
                                    $result = mysqli_query($conn, $sql);
                                    $sno = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $sno = $sno + 1;
                                        echo "
                                            <tr>
                                                    <th scope='row'>" . $sno . "</th>
                                                    <td>" . $row['seller_name'] . "</td>
                                                    <td>" . $row['product_name'] . "</td>
                                                    <td>" . $row['product_price'] . "</td>
                                                    <td>" . $row['product_detail'] . "</td>
                                                    <td>" . $row['product_type'] . "</td>
                                                    <td>" . $row['product_size'] . "</td>
                                                    <td>" . $row['product_color'] . "</td>
                                                
                                            </tr>
                                        ";
                                    }
                                    
                                ?>
                            </tbody>
                        </table>
                    </div> -->

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
    var ctx = document.getElementById('loginChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($loginCountsToday)); ?>,
            datasets: [{
                label: 'User Register ',
                data: <?php echo json_encode(array_values($loginCountsToday)); ?>,
                backgroundColor: 'lightgreen',
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

    <script>
    // JavaScript to generate the "Number of Logins" chart using Chart.js
    var ctx1 = document.getElementById('loginChart1').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($loginCountsTotal)); ?>,
            datasets: [{
                label: 'Seller Register ',
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