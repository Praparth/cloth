<?php
    $insert = false;
    $update = false;
    $delete = false;

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "cloth";
    $conn = mysqli_connect($server, $username, $password, $database);

   

    if (!$conn) {
        die("Error: " . mysqli_connect_error());
    }
    
    // delete the record
    if(isset($_GET['delete'])) {
        $sno = $_GET['delete'];
        // $delete = true;
            $sql = "DELETE FROM `seller_register` WHERE `sno`=$sno";
            $result = mysqli_query($conn , $sql);

    }


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
                    $status = $_POST["seller_status"];

    
                    //sql query to be executed
                    $sql = "UPDATE `seller_register` SET `fullname`='$fullName', `shopno`='$shopno', `phoneno`='$phoneno', `Email`='$Email', `Password`='$Password', `Product`='$Product', `Panno`='$Panno', `GSTno`='$GSTno', `Accountholdername`='$Accountholdername', `Accountno`='$Accountno', `IFSCno`='$IFSCno', `seller_status`='$status' WHERE `sno`='$sno'";
                    $result = mysqli_query($conn , $sql);
    
                    if($result){
                        // echo "the record has been update successfully <br>";
                        // $update = true;
                    }
                    else{
                        echo "the record has been update successfully because of this error ".mysqli_error($conn);   
                    }
    
                }
    

        else{
            $fullName = $_POST["fullName"];
            $shopno = $_POST["shopname"];
            $phoneno = $_POST["phoneno"];
            $Email = $_POST["Email"];
            $Password = $_POST["Password"];
            $Product = isset($_POST["Product"]) ? $_POST["Product"] : ''; // Check if Product key exists
            $Panno = $_POST["Panno"];
            $GSTno = $_POST["GSTno"];
            $Accountholdername = $_POST["Accountholdername"];
            $Accountno = $_POST["Accountno"];
            $IFSCno = $_POST["IFSCno"];

            if(empty($fullName) || empty($shopno) || empty($phoneno) || empty($Email) || empty($Password) || empty($Product) || empty($Panno) || empty($GSTno) || empty($Accountholdername) || empty($Accountno) || empty($IFSCno)) {
                // Display an error message if any field is empty
                echo "<div class='alert alert-danger' role='alert'>Please fill in all fields.</div>";
            } else {
                // Proceed with database insertion
                $sql = "INSERT INTO `seller_register`(`fullname`, `shopno`, `phoneno`, `Email`, `Password`, `Product`, `Panno`, `GSTno`, `Accountholdername`, `Accountno`, `IFSCno`) 
                VALUES ('$fullName','$shopno','$phoneno','$Email','$Password','$Product','$Panno','$GSTno','$Accountholdername','$Accountno','$IFSCno')";
        
                // Execute the query
                $result = mysqli_query($conn, $sql);
        
                // Check if the query executed successfully
                if ($result) {
                    // Record inserted successfully
                    $insert = true;
                } else {
                    // Display error message if the query failed
                    echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
                }
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
                    <!-- ---------------------------------------------------------------------------------------- -->

                    <!-- user data inser Form  (start) -->
                    <div class="container mx-auto">
                        <form id="sellerForm"
                            class="d-flex flex-column mx-auto mb-5 col-12 py-5 col-lg-8 needs-validation" novalidate
                            action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <input type="text" id="fullName" name="fullName"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide a Full name.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shopname" class="form-label">Shop Name</label>
                                        <input type="text" id="shopname" name="shopname"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide a Shop name.</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add similar row for other form fields -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phoneno" class="form-label">Phone No</label>
                                        <input type="text" id="phoneno" name="phoneno"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide a Phone number.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">Email</label>
                                        <input type="text" id="Email" name="Email"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide a Email.</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add similar row for other form fields -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Password" class="form-label">Password</label>
                                        <input type="password" id="Password" name="Password"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide a password.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Product" class="form-label">Which product to sell</label>
                                        <select class="border-1 border-success form-select form-select-md" id="Product"
                                            name="Product" required>
                                            <option selected disabled value=""></option>
                                            <option value="Man">Man</option>
                                            <option value="Women">Women</option>
                                            <option value="Kids(Boy)">Kids(Boy)</option>
                                            <option value="Kids(girl)">Kids(girl)</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a product.</div>
                                    </div>
                                </div>

                            </div>
                            <!-- Add similar row for other form fields -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Panno" class="form-label">PAN NO</label>
                                        <input type="text" id="Panno" name="Panno"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide a PAN number.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="GSTno" class="form-label">GST NO</label>
                                        <input type="text" id="GSTno" name="GSTno"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide a GST number.</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add similar row for other form fields -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Accountholdername" class="form-label">Account holder name NO</label>
                                        <input type="text" id="Accountholdername" name="Accountholdername"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide an account holder name.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Accountno" class="form-label">Account NO</label>
                                        <input type="text" id="Accountno" name="Accountno"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide an account number.</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add similar row for other form fields -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="IFSCno" class="form-label">IFSC NO</label>
                                        <input type="text" id="IFSCno" name="IFSCno"
                                            class="form-control form-control-md rounded border-1 border-success"
                                            required>
                                        <div class="invalid-feedback">Please provide an IFSC number.</div>
                                    </div>
                                </div>
                                <!-- Add another column here if needed -->
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3 my-4">
                                    <div class="form-group text-center">
                                        <button class="btn btn-dark px-4 py-2" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>



                    <!-- user data inser Form  (end) -->

                    <!-- ---------------------------------------------------------------------------------------- -->

                    <!-- user data be update (Start) -->
                    <!---------------------------------------- update ------------------------------------------------>
                    <!-- Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                        aria-hidden="true">
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
                                            <label for="Accountholdernameedit" class="form-label">Account holder
                                                name</label>
                                            <input type="text" id="Accountholdernameedit" name="Accountholdernameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide an Account holder name.
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
                                        <div class="col-6 mx-auto mt-3">
                                            <select class="border-1 border-success form-select form-select-md"
                                                id="statusedit" name="seller_status" required>
                                                <option selected disabled value=""></option>
                                                <option value="Active">Active</option>
                                                <option value="unActive">unActive</option>
                                            </select>
                                        </div>

                                        <div class="col-6 mx-auto my-4 text-center  ">
                                            <button class="btn btn-warning px-4 py-2 " type="submit">update</button>
                                        </div>



                                </div>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>


                <!-- user data be update (End) -->

                <!-- ---------------------------------------------------------------------------------------- -->

                <!-- user data be so on screen (start) -->
                <div class="table-responsive  mx-auto col-11" style="max-height: 90vh; overflow-y: auto;">
                    <style>
                    .table-responsive::-webkit-scrollbar {
                        width: 0;
                    }
                    </style>
                    <table id="Table" class="table table-striped ">
                        <thead>
                            <tr>
                                <th scope="col">sno</th>
                                <th scope="col">fullname</th>
                                <th scope="col">shopno</th>
                                <th scope="col">phoneno</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">Product</th>
                                <th scope="col">Panno</th>
                                <th scope="col">GSTno</th>
                                <th scope="col">Accountholdername</th>
                                <th scope="col">Accountno</th>
                                <th scope="col">IFSCno</th>
                                <th scope="col">Actions</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
    $sql = "SELECT * FROM `seller_register`";
    $result = mysqli_query($conn, $sql);
    $sno = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $sno = $sno + 1;
        echo "
            <tr>
                <th scope='row'>" . $sno . "</th>
                <td>" . $row['fullname'] . "</td>
                <td>" . $row['shopno'] . "</td>
                <td>" . $row['phoneno'] . "</td>
                <td>" . $row['Email'] . "</td>
                <td>" . $row['Password'] . "</td>
                <td>" . $row['Product'] . "</td>
                <td>" . $row['Panno'] . "</td>
                <td>" . $row['GSTno'] . "</td>
                <td>" . $row['Accountholdername'] . "</td>
                <td>" . $row['Accountno'] . "</td>
                <td>" . $row['IFSCno'] . "</td>
                <td class=\"";
                                        
        // Define default color class
        $colorClass = '';
                                        
        // Set color class based on seller status
        $sellerStatus = $row['seller_status'];
        if ($sellerStatus == "Active") {
            echo "text-success"; // Green color for active status
        } elseif ($sellerStatus == "unActive") {
            echo "text-danger"; // Red color for inactive status
        }
                                        
        echo "\">" . $sellerStatus . "</td>
        <td>
            <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> 
        </td>
    </tr>";
    }
?>

                        </tbody>
                    </table>
                </div>


                <!-- user data be so on screen (end) -->

                <!-- ---------------------------------------------------------------------------------------- -->

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

    <script>
    //----------------------------------- update ---------------------------------------
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            tr = e.target.parentNode.parentNode;

            // Extracting data from table cells
            fullName = tr.getElementsByTagName("td")[0].innerText;
            shopname = tr.getElementsByTagName("td")[1].innerText;
            phoneno = tr.getElementsByTagName("td")[2].innerText;
            Email = tr.getElementsByTagName("td")[3].innerText;
            Password = tr.getElementsByTagName("td")[4].innerText;
            Product = tr.getElementsByTagName("td")[5].innerText;
            Panno = tr.getElementsByTagName("td")[6].innerText;
            GSTno = tr.getElementsByTagName("td")[7].innerText;
            Accountholdername = tr.getElementsByTagName("td")[8].innerText;
            Accountno = tr.getElementsByTagName("td")[9].innerText;
            IFSCno = tr.getElementsByTagName("td")[10].innerText;
            status = tr.getElementsByTagName("td")[11].innerText;

            console.log(fullName, Password, Email);

            // Assign values to form fields
            fullNameedit.value = fullName;
            shopnameedit.value = shopname;
            phonenoedit.value = phoneno;
            Emailedit.value = Email;
            Passwordedit.value = Password;
            Productedit.value = Product;
            Pannoedit.value = Panno;
            GSTnoedit.value = GSTno;
            Accountholdernameedit.value = Accountholdername;
            Accountnoedit.value = Accountno;
            IFSCnoedit.value = IFSCno;
            statusedit.value = status;
            snoEdit.value = e.target.id;

            console.log(e.target.id);
            $('#editModal').modal('toggle');
        })
    })




    //-----------------------------------delete  ---------------------------------------
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("delete ");
            sno = e.target.id.substr(1, );


            if (confirm("press a Button")) {
                console.log("yes");
                window.location = `admin_seller_login.php?delete=${sno}`; // chage the path
                // TODP : create a form  and use post request to submit a form
            } else {
                console.log("No");
            }

        })
    })
    </script>

    <script>
    // Disable right-click
    window.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    }, false);
    </script>



</body>

</html>