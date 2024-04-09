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
            <div class="bg-dark col-4 col-sm-3  col-md-3 col-lg-3 vh-100 d-flex flex-column justify-content-between">
                <?php require 'seller_side_bar.php'?>
            </div>
            <!-- start  -->
            <div class="col-8 col-sm-9">
                <div class="p-3">

                    <!-- ------------------------------------------------------------------------------------------------ -->
                    <!-- user data inser Form  (start) -->
      


                    <!-- user data inser Form  (end) -->
                    <!-- ------------------------------------------------------------------------------------------------ -->
                    <div class="table-container" style="max-height: 90vh; overflow-y: auto;">
                    <style>
                                .table-container::-webkit-scrollbar {
                                    width: 0;
                                }
                            </style>    
                        <table id="Table" class="table table-striped " >
                            <thead>
                                <tr>
                                    <th scope="col">Sno</th>
                                    <th scope="col">seller Name</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Product Detail</th>
                                    <th scope="col">Product Type</th>
                                    <th scope="col">Product Size</th>
                                    <th scope="col">Product Color</th>
                                    <th scope="col">Product Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM `product` WHERE `seller_name` = '$fullName'"; // Assuming `product` is your table name
                                    $result = mysqli_query($conn, $sql);
                                    $sno = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $sno++;
                                        echo "<tr>";
                                        echo "<td>" . $sno . "</td>";
                                        echo "<td>" . $row["seller_name"] . "</td>";
                                        echo "<td>" . $row["product_name"] . "</td>";
                                        echo "<td>" . $row["product_price"] . "</td>";
                                        echo "<td>" . $row["product_detail"] . "</td>";
                                        echo "<td>" . $row["product_type"] . "</td>";
                                        echo "<td>" . $row["product_size"] . "</td>";
                                        echo "<td>" . $row["product_color"] . "</td>";
                                        echo "<td><img src='" . $row["product_image"] . "' style='width:100px;height:100px;'></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

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

    <script>
    $(document).ready(function() {
        $('#Table').DataTable();
    });
</script>

</body>

</html>
