<?php
session_start();

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
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `profile` WHERE `sno`=$sno";
    $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['form_submitted'])) {
        unset($_SESSION['form_submitted']);
    } else {
        if (isset($_POST['snoEdit'])) {
            // update the record
            $sno = $_POST["snoEdit"];
            $First_name = $_POST["First_nameedit"];
            $Password = $_POST["Passwordedit"];
            $Email = $_POST["Emailedit"];
            $State = $_POST["Stateedit"];
            $City = $_POST["Cityedit"];
            $Zip = $_POST["Zipedit"];
            $status = $_POST["user_status"];

            // SQL query to be executed
            $sql = "UPDATE `profile` SET `First_name`='$First_name', `Password`='$Password', `Email`='$Email', `State`='$State', `City`='$City', `Zip`='$Zip', `user_status`='$status' WHERE `sno`='$sno'";

             $result = mysqli_query($conn, $sql);

            if ($result) {
                $update = true;
            } else {
                echo "The record was not updated successfully because of this error " . mysqli_error($conn);
            }
        } else {
            $First_name = $_POST["First_name"];
            $Password = $_POST["Password"];
            $Email = $_POST["Email"];
            $State = $_POST["State"];
            $City = $_POST["City"];
            $Zip = $_POST["Zip"];

            $sql = "INSERT INTO `profile`(`First_name`, `Password`, `Email`, `State`, `City`, `Zip`) VALUES ('$First_name', '$Password', '$Email', '$State', '$City', '$Zip')";

            // Execute the query
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $insert = true;
            } else {
                echo "The record was not inserted successfully because of this error " . mysqli_error($conn);
            }
        }
        $_SESSION['form_submitted'] = true;
        // Redirect to prevent resubmission on refresh
        header("Location: admin_user_login.php");
        exit();
    }
}

// Check if data was inserted or updated
if ($insert) {
    $_SESSION['inserted'] = true;
}

if ($update) {
    $_SESSION['updated'] = true;
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
                    <?php
                    if($insert){
                      echo  "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong> You Notes are Inserted Successfully.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                    }
                    if($update){
                        echo  "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                          <strong>Success!</strong> You Notes are Update Successfully.
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                      }
                    if($delete){
                        echo  "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                          <strong>Success!</strong> You Notes are Delete Successfully.
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                      }  
                ?>

                    <!-- user data inser Form  (start) -->
                    <form action="" method="post"
                        class="d-flex flex-column flex-sm-row flex-wrap mx-auto mb-5 col-12 py-5">
                        <div class="col-sm-5 mx-auto my-3 ">
                            <label for="First_name" class="form-label">First name</label>
                            <input type="text" class="form-control" id="First_name" name="First_name" required="">
                        </div>
                        <div class="col-sm-5 mx-auto my-3 ">
                            <label for="Password" class="form-label">Password</label>
                            <input type="Password" class="form-control" id="Password" name="Password" required="">
                        </div>
                        <div class="col-sm-5 mx-auto my-3 ">
                            <label for="Email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                <input type="Email" class="form-control" id="Email" name="Email"
                                    aria-describedby="inputGroupPrepend2" required="">
                            </div>
                        </div>
                        <div class="col-sm-5 mx-auto my-3 ">
                            <label for="State" class="form-label">State</label>
                            <input type="text" class="form-control" id="State" name="State" required="">
                        </div>
                        <div class="col-sm-5 mx-auto my-3 ">
                            <label for="City" class="form-label">City</label>
                            <input type="text" class="form-control" id="City" name="City" required="">
                        </div>
                        <div class="col-sm-5 mx-auto my-3 ">
                            <label for="Zip" class="form-label">Zip</label>
                            <input type="text" class="form-control" id="Zip" name="Zip" required="">
                        </div>
                        <div class="col-sm-12 mx-auto my-3 d-flex justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required="">
                                <label class="form-check-label" for="invalidCheck2">Agree to terms and
                                    conditions</label>
                            </div>
                        </div>
                        <div class="col-sm-11 mx-auto my-3 ">
                            <button class="btn btn-success" type="submit">Submit form</button>
                        </div>
                    </form>
                    <!-- user data inser Form  (end) -->

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
                                        <div class="col-sm-6 mx-auto my-3">
                                            <label for="First_nameedit" class="form-label">First name</label>
                                            <input type="text" class="form-control" id="First_nameedit"
                                                name="First_nameedit" required="">
                                        </div>
                                        <div class="col-sm-6 mx-auto">
                                            <label for="Passwordedit" class="form-label">Passwordedit</label>
                                            <input type="Passwordedit" class="form-control" id="Passwordedit"
                                                name="Passwordedit" required="">
                                        </div>
                                        <div class="col-sm-6 mx-auto my-3">
                                            <label for="Emailedit" class="form-label">Emailedit</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                                <input type="Emailedit" class="form-control" id="Emailedit"
                                                    name="Emailedit" aria-describedby="inputGroupPrepend2" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mx-auto">
                                            <label for="Stateedit" class="form-label">Stateedit</label>
                                            <input type="text" class="form-control" id="Stateedit" name="Stateedit"
                                                required="">
                                        </div>
                                        <div class="col-sm-6 mx-auto my-3">
                                            <label for="Cityedit" class="form-label">Cityedit</label>
                                            <input type="text" class="form-control" id="Cityedit" name="Cityedit"
                                                required="">
                                        </div>
                                        <div class="col-sm-6 mx-auto">
                                            <label for="Zipedit" class="form-label">Zipedit</label>
                                            <input type="text" class="form-control" id="Zipedit" name="Zipedit"
                                                required="">
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <select class="border-1 border-success form-select form-select-md"
                                                id="statusedit" name="user_status" required>
                                                <option selected disabled value=""></option>
                                                <option value="Active">Active</option>
                                                <option value="unActive">unActive</option>
                                            </select>
                                        </div>



                                        <button type="submit"
                                            class="col-sm-6 mx-auto my-4 btn btn-warning">Update</button>


                                </div>
                            </div>
                           
                            </form>
                        </div>
                    </div>
                    <!-- user data be update (End) -->

                    <!-- user data be so on screen (start) -->
                    <div class="table-container col-12" style=" overflow-y: auto;">
                        <style>
                        .table-container::-webkit-scrollbar {
                            width: 0;
                        }
                        </style>
                        <div class="row">
                            <div class="col-md-12 table-responsive ">
                                <table id="Table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">sno</th>
                                            <th scope="col">First_name</th>
                                            <th scope="col">password</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">State</th>
                                            <th scope="col">City</th>
                                            <th scope="col">Zip</th>
                                            <th scope="col">Actions</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `profile`";
                                        $result = mysqli_query($conn, $sql);
                                        $sno = 0;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $sno = $sno + 1;
                                            echo "
                                                <tr>
                                                    <th scope='row'>" . $sno . "</th>
                                                    <td>" . $row['First_name'] . "</td>
                                                    <td>" . $row['Password'] . "</td>
                                                    <td>" . $row['Email'] . "</td>
                                                    <td>" . $row['State'] . "</td>
                                                    <td>" . $row['City'] . "</td>
                                                    <td>" . $row['Zip'] . "</td>
                                                    <td class=\"";
                                        
                                                    // Define default color class
                                                    $colorClass = '';
                                                                                    
                                                    // Set color class based on seller status
                                                    $sellerStatus = $row['user_status'];
                                                    if ($sellerStatus == "Active") {
                                                        echo "text-success"; // Green color for active status
                                                    } elseif ($sellerStatus == "unActive") {
                                                        echo "text-danger"; // Red color for inactive status
                                                    }
                                                                                    
                                                    echo "\">" . $sellerStatus . "</td>
                                                    <td>
                                                        <button class='edit btn btn-sm btn-primary ' id=".$row['sno'].">Edit</button> 
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <!-- Your search bar HTML goes here -->
                            </div>
                        </div>
                    </div>


                    <!-- user data be so on screen (end) -->


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

            First_name = tr.getElementsByTagName("td")[0]
            .innerText; // Adjust the index based on the column order
            Password = tr.getElementsByTagName("td")[1].innerText;
            Email = tr.getElementsByTagName("td")[2].innerText;
            State = tr.getElementsByTagName("td")[3].innerText;
            City = tr.getElementsByTagName("td")[4].innerText;
            Zip = tr.getElementsByTagName("td")[5].innerText;
            status = tr.getElementsByTagName("td")[6].innerText;


            console.log(First_name, Password, Email);

            First_nameedit.value = First_name;
            Passwordedit.value = Password;
            Emailedit.value = Email;
            Stateedit.value = State;
            Cityedit.value = City;
            Zipedit.value = Zip;
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
                window.location = `admin_user_login.php?delete=${sno}`; // chage the path
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