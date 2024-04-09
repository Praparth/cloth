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

    // Display user details
    echo "Welcome, " . $fullName . "!<br>";


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

    // Now you can use $conn to perform database operations if needed

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['snoEdit'])){
            // update the record
            
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

            //sql query to be executed
            $sql = "UPDATE `seller_register` SET `fullname`='$fullName', `shopno`='$shopno', `phoneno`='$phoneno', `Email`='$Email', `Password`='$Password', `Product`='$Product', `Panno`='$Panno', `GSTno`='$GSTno', `Accountholdername`='$Accountholdername', `Accountno`='$Accountno', `IFSCno`='$IFSCno' WHERE `fullname`='$fullName'";
                $result = mysqli_query($conn , $sql);

            if($result){
                // echo "the record has been update successfully <br>";
                // $update = true;
            }
            else{
                echo "the record has been update successfully because of this error ".mysqli_error($conn);   
            }

        }
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
                <?php require 'admin_side_bar.php'?>
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
                                        <tr>
                                            <th>...</th>
                                            <th>///</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <th scope="col">fullname</th>
                                            <?php 
                                    echo "<td>" . $fullName. "</td>";

                                ?>
                                        </tr>
                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">shop Name</th>
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
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                    
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="" method="post" class="d-flex  flex-column mx-auto mt-5  mb-5">
                                        <input type="hidden" name="snoEdit" id="snoEdit">
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="fullNameedit" class="form-label">Full Name</label>
                                            <input type="text" id="fullNameedit" name="fullNameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a Full name.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto my-3">
                                            <label for="shopnameedit" class="form-label">Shop Name</label>
                                            <input type="text" id="shopnameedit" name="shopnameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a Shop name.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto">
                                            <label for="phonenoedit" class="form-label">Phone No</label>
                                            <input type="text" id="phonenoedit" name="phonenoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a Phone number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Emailedit" class="form-label">Email</label>
                                            <input type="text" id="Emailedit" name="Emailedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a Email .
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Passwordedit" class="form-label">Password</label>
                                            <input type="password" id="Passwordedit" name="Passwordedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a password.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto my-3">
                                            <label for="Productedit" class="form-label">Which product to sell</label>
                                            <select class="border-1 border-success form-select form-select-md"
                                                id="Productedit" name="Productedit" required>
                                                <option selected disabled value=""></option>
                                                <option value="Man">Man</option>
                                                <option value="Women">Women</option>
                                                <option value="Kids(Boy)">Kids(Boy)</option>
                                                <option value="Kids(girl)">Kids(girl)</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid state.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Pannoedit" class="form-label">PAN NO</label>
                                            <input type="text" id="Pannoedit" name="Pannoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a PAN number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="GSTnoedit" class="form-label">GST NO</label>
                                            <input type="text" id="GSTnoedit" name="GSTnoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a GST number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Accountholdernameedit" class="form-label">Account holder name
                                                NO</label>
                                            <input type="text" id="Accountholdernameedit" name="Accountholdernameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a Account holder name number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="Accountnoedit" class="form-label">Account NO</label>
                                            <input type="number" id="Accountnoedit" name="Accountnoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a Account number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="IFSCnoedit" class="form-label">IFSC NO</label>
                                            <input type="text" id="IFSCnoedit" name="IFSCnoedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a IFSC number.
                                            </div>
                                        </div>

                                        <div class="col-6 mx-auto my-4 text-center  ">
                                            <button class="btn btn-warning px-4 py-2 " type="submit">update</button>
                                        </div>



                                </div>
                            </div>

                            </form>
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
     //----------------------------------- update ---------------------------------------
     edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            tr = e.target.parentNode.parentNode;

                // Adjust the index based on the column order
                fullName = tr.getElementsByTagName("td")[0].innerText;
                shopname = tr.getElementsByTagName("td")[1].innerText;
                phoneno = tr.getElementsByTagName("td")[2].innerText;
                Email = tr.getElementsByTagName("td")[3].innerText;
                Password = tr.getElementsByTagName("td")[4].innerText;
                Product = tr.getElementsByTagName("td")[5].innerText;

                // Assigning correct value to Pannoedit
                Panno = tr.getElementsByTagName("td")[6].innerText;
                GSTno = tr.getElementsByTagName("td")[7].innerText;
                Accountholdername = tr.getElementsByTagName("td")[8].innerText;
                Accountno = tr.getElementsByTagName("td")[9].innerText;
                IFSCNo = tr.getElementsByTagName("td")[10].innerText;

                console.log(fullName, Password, Email);

                // Assign values to form fields
                fullNameedit.value = fullName;
                shopnameedit.value = shopname;
                phonenoedit.value = phoneno;
                Emailedit.value = Email;
                Passwordedit.value = Password;
                Productedit.value = Product;
                Pannoedit.value = Panno; // Corrected variable name
                GSTnoedit.value = GSTno;
                Accountholdernameedit.value = Accountholdername;
                Accountnoedit.value = Accountno;
                IFSCnoedit.value = IFSCNo;
                snoEdit.value = e.target.id;

                console.log(e.target.id);
                $('#editModal').modal('toggle');
            })
        })

</script>




</body>

</html>