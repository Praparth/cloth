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
        $sql = "DELETE FROM user_add_to_card WHERE sno=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $sno);
        if (mysqli_stmt_execute($stmt)) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
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
                <div class="">



                    <!-- Main content -->
                    <div class="col-10 d-flex ">
                        <div class="col-12 col-md-12 col-lg-10">
                            <h2 class="fw-normal fs-3 me-3">Add To Card Product</h2>
                            <div class="table-container" style="max-height: 90vh; overflow-y: auto;">
                                <style>
                                    .table-container::-webkit-scrollbar {
                                        width: 0;
                                    }
                                </style>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Product Desc</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">QTY</th>
                                            <th scope="col">Total</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // Retrieve products from the database
                                        $query = "SELECT * FROM user_add_to_card WHERE user_name = ?";
                                        $stmt = mysqli_prepare($conn, $query);
                                        mysqli_stmt_bind_param($stmt, "s", $fullName); // Bind the parameter
                                        mysqli_stmt_execute($stmt); // Execute the prepared statement
                                        $result = mysqli_stmt_get_result($stmt); // Get the result set

                                        // Check if the query was executed successfully
                                        if ($result === false) {
                                            die("Error: " . mysqli_error($conn));
                                        }

                                        $totalPrice = 0; // Initialize total price variable

                                        if (mysqli_num_rows($result) > 0) {
                                            // Iterate over each row in the result set
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $productPrice = $row['product_price'];
                                                $quantity = $row['qty'];
                                                $subtotal = $productPrice * $quantity; // Calculate subtotal by multiplying price with quantity
                                                $totalPrice += $subtotal; // Add subtotal to total price

                                                // Display the product details in table rows
                                                echo "<tr>";
                                                echo "<td><img src='" . $row['product_image'] . "' alt='" . $row['product_name'] . "' style='width: 100px; height: 100px;'></td>";
                                                echo "<td>" . $row['product_name'] . "</td>";
                                                echo "<td>" . $row['product_price'] . "</td>";
                                                echo "<td>" . $quantity . "</td>";
                                                echo "<td>" . $subtotal . "</td>"; // Display subtotal
                                                echo "<td><button class='delete btn btn-sm btn-primary' id='d{$row['sno']}'>Delete</button></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            // If no products are found, display a message in a single table row
                                            echo "<tr><td colspan='6'>No products found</td></tr>";
                                        }

                                        // Display total price after displaying all products
                                        // echo "<tr><td colspan='4'><strong>Total:</strong></td><td><strong>" . $totalPrice . "</strong></td><td></td></tr>";
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        
                        <div class="col-4 mt-5 mx-2 flex-column">
                            <div class="card border border-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Total</h5>
                                    <p class="card-text border-bottom border-primary pb-2">Total Products: <?php echo mysqli_num_rows($result); ?></p>
                                    <p class="card-text border-bottom border-primary pb-2">Total Price:<?php echo $totalPrice; ?></p>
                                    <a href="user_add_card_Address.php" class="btn btn-warning mt-3 d-block w-100">Buy Now</a>
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


        <!-- //-----------------------------------delete  ---------------------------------------// -->
        <script>
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("delete ");
                sno = e.target.id.substr(1, );


                if (confirm("press a Button")) {
                    console.log("yes");
                    window.location = `user_add_to_card.php?delete=${sno}`; // chage the path
                    // TODP : create a form  and use post request to submit a form
                } else {
                    console.log("No");
                }

            })
        })
        </script>

</body>

</html>