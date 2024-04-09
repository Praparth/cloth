<?php 
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['login_seller'])) {
        // Redirect to login page if user is not logged in
        header("Location: index.php");
        exit();
    }

    // Access user data from session
    $fullName = $_SESSION['login_seller'];

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

    // Check if form is submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['snoEdit'])){
            // Update the record
            $sno = $_POST['snoEdit'];
            $fullName = $_POST["fullNameedit"];
            $shopno = $_POST["shopnameedit"];
            $phoneno = $_POST["phonenoedit"];
            $Email = $_POST["Emailedit"];
            $Password = $_POST["Passwordedit"];
            $Product = $_POST["Productedit"];
            $Panno = $_POST["Pannoedit"];
            $GSTno = $_POST["GSTnoedit"];
            $Accountholdername = $_POST["Accountholdernameedit"];
            $Accountno = $_POST["Accountnoedit"];
            $IFSCno = $_POST["IFSCnoedit"];

            // Update SQL query using prepared statement
            $sql = "UPDATE `seller_register` SET `shopno`=?, `phoneno`=?, `Email`=?, `Password`=?, `Product`=?, `Panno`=?, `GSTno`=?, `Accountholdername`=?, `Accountno`=?, `IFSCno`=? WHERE `fullname`=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssssssss", $shopno, $phoneno, $Email, $Password, $Product, $Panno, $GSTno, $Accountholdername, $Accountno, $IFSCno, $fullName);
            $result = mysqli_stmt_execute($stmt);

            if($result){
                echo "The record has been updated successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Fetch shop name
    $sql_shop = "SELECT shopno FROM seller_register WHERE fullName = '$fullName'";
    $result_shop = mysqli_query($conn, $sql_shop);
    if (mysqli_num_rows($result_shop) > 0) {
        // Output data of the first row only
        $row_shop = mysqli_fetch_assoc($result_shop);
        $shopname = $row_shop["shopno"];
    } else {
        $shopname = ""; // Or set it to any default value you want
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
                    <div class="col-12 col-md-9 col-lg-10">

                        <!-- ----------------------------------------------------------------------------------------- -->


                        <!-- ----------------------------------------------------------------------------------------- -->
                        <div class="col-auto col-md-9 col-lg-10">
                            <div class="table-responsive">
                                <table id="Table" class="table table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th colspan="2">Profile</th>
                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                        <tr class="">
                                            <th scope="col">Full Name</th>
                                            <?php 
                                    echo "<td>" . $fullName. "</td>";

                                ?>
                                        </tr>
                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Shop Name</th>
                                            <?php

                                    $sql = "SELECT shopno FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["shopno"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                    
                                ?>
                                        </tr>
                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Phone No</th>
                                            <?php

                                    $sql = "SELECT phoneno FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["phoneno"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Email</th>
                                            <?php

                                    $sql = "SELECT Email FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["Email"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Password</th>
                                            <?php

                                    $sql = "SELECT Password FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["Password"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Product</th>
                                            <?php

                                    $sql = "SELECT Product FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["Product"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Pan no</th>
                                            <?php

                                    $sql = "SELECT Panno FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["Panno"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">GSTno</th>
                                            <?php

                                    $sql = "SELECT GSTno FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["GSTno"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Account Holder Name</th>
                                            <?php

                                    $sql = "SELECT Accountholdername FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["Accountholdername"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Account No</th>
                                            <?php

                                    $sql = "SELECT Accountno FROM seller_register WHERE fullName = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["Accountno"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">IFSC No</th>
                                            <?php

                                                $sql = "SELECT IFSCNo FROM seller_register WHERE fullName = '$fullName'";
                                                $result = mysqli_query($conn, $sql);
                                            
                                                if (mysqli_num_rows($result) > 0) {
                                                    // Output data of each row
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        echo "<td>" . $row["IFSCNo"] . "</td>";
                                                    }
                                                } else {
                                                    echo "<td>No shop found</td>";
                                                }
                                            
                                            ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col"></th>
                                            <?php
                                    $fullNameButtonId = isset($row['$fullName']) ? $row['$fullName'] : '';

                                    echo "<td>
                                        <button type='button' class='btn btn-primary edit' data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-whatever='@mdo' id='$fullNameButtonId'>edit</button>
                                        </td>";
                                    
                                ?>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- user data inser Form  (end) -->
                    <!-- ------------------------------------------------------------------------------------------------ -->

                    <!-- user data be update (Start) -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" class="d-flex flex-column mx-auto mt-5 mb-5">
                                        <input type="hidden" name="snoEdit" id="snoEdit">
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="fullNameedit" class="form-label">Full Name</label>
                                            <input type="text" id="fullNameedit" name="fullNameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $fullName; ?>">
                                            <div class="invalid-feedback">
                                                Please provide a Full name.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto my-3">
                                            <label for="shopnameedit" class="form-label">Shop Name</label>
                                            <input type="text" id="shopnameedit" name="shopnameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $shopname; ?>">
                                            <div class="invalid-feedback">
                                                Please provide a Shop name.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto">
                                            <label for="phonenoedit" class="form-label">Phone No</label>
                                            <input type="text" id="phonenoedit" name="phonenoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $phoneno; ?>">
                                            <div class="invalid-feedback">
                                                Please provide a Phone number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Emailedit" class="form-label">Email</label>
                                            <input type="text" id="Emailedit" name="Emailedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $Email; ?>">
                                            <div class="invalid-feedback">
                                                Please provide an Email.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Passwordedit" class="form-label">Password</label>
                                            <input type="password" id="Passwordedit" name="Passwordedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $Password; ?>">
                                            <div class="invalid-feedback">
                                                Please provide a password.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto my-3">
                                            <label for="Productedit" class="form-label">Which product to sell</label>
                                            <select class="border-1 border-success form-select form-select-md"
                                                id="Productedit" name="Productedit" required>
                                                <option value="" <?php if($Product == "") echo 'selected'; ?> disabled>
                                                </option>
                                                <option value="Man" <?php if($Product == "Man") echo 'selected'; ?>>Man
                                                </option>
                                                <option value="Women" <?php if($Product == "Women") echo 'selected'; ?>>
                                                    Women</option>
                                                <option value="Kids(Boy)"
                                                    <?php if($Product == "Kids(Boy)") echo 'selected'; ?>>Kids(Boy)
                                                </option>
                                                <option value="Kids(girl)"
                                                    <?php if($Product == "Kids(girl)") echo 'selected'; ?>>Kids(girl)
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid product.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Pannoedit" class="form-label">PAN NO</label>
                                            <input type="text" id="Pannoedit" name="Pannoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $Panno; ?>">
                                            <div class="invalid-feedback">
                                                Please provide a PAN number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="GSTnoedit" class="form-label">GST NO</label>
                                            <input type="text" id="GSTnoedit" name="GSTnoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $GSTno; ?>">
                                            <div class="invalid-feedback">
                                                Please provide a GST number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Accountholdernameedit" class="form-label">Account holder
                                                name</label>
                                            <input type="text" id="Accountholdernameedit" name="Accountholdernameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $Accountholdername; ?>">
                                            <div class="invalid-feedback">
                                                Please provide an Account holder name.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Accountnoedit" class="form-label">Account NO</label>
                                            <input type="number" id="Accountnoedit" name="Accountnoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $Accountno; ?>">
                                            <div class="invalid-feedback">
                                                Please provide an Account number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="IFSCnoedit" class="form-label">IFSC NO</label>
                                            <input type="text" id="IFSCnoedit" name="IFSCnoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required value="<?php echo $IFSCno; ?>">
                                            <div class="invalid-feedback">
                                                Please provide an IFSC number.
                                            </div>
                                        </div>

                                        <div class="col-6 mx-auto my-4 text-center">
                                            <button class="btn btn-warning px-4 py-2" type="submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


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
    // JavaScript code for fetching user details dynamically
    const userDetails = <?php echo json_encode($userDetails); ?>;
    if (userDetails) {
        // Populate form fields with user details
        document.getElementById('fullNameedit').value = userDetails.fullName;
        document.getElementById('shopnameedit').value = userDetails.shopno;
        document.getElementById('phonenoedit').value = userDetails.phoneno;
        document.getElementById('Emailedit').value = userDetails.Email;
        document.getElementById('Passwordedit').value = userDetails.Password;
        document.getElementById('Productedit').value = userDetails.Product;
        document.getElementById('Pannoedit').value = userDetails.Panno;
        document.getElementById('GSTnoedit').value = userDetails.GSTno;
        document.getElementById('Accountholdernameedit').value = userDetails.Accountholdername;
        document.getElementById('Accountnoedit').value = userDetails.Accountno;
        document.getElementById('IFSCnoedit').value = userDetails.IFSCno;
    } else {
        alert("User details not found!");
    }
    </script>




</body>

</html>