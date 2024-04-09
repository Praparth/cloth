<?php 
    session_start();
    
    // Access user data from session
    if (!isset($_SESSION['login_user'])) {
        header("Location: user_login_profile.php");
        exit();
    }

   

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

    // Fetch user data from database
    $fullName = $_SESSION['login_user'];
    $sql = "SELECT * FROM profile WHERE First_name = '$fullName'";
    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("Error: User not found");
    }

    // Fetch user details
    $row = mysqli_fetch_assoc($result);
    $Password = $row['Password'];
    $Email = $row['Email'];
    $State = $row['State'];
    $City = $row['City'];
    $Zip = $row['Zip'];

      // Set email in session
      $_SESSION['email'] = $Email;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['snoEdit'])) {
            // update the record
            $fullName = $_POST["fullNameedit"];
            $Password = $_POST["Passwordedit"];
            $Email = $_POST["Emailedit"];
            $State = $_POST["Stateedit"];
            $City = $_POST["Cityedit"];
            $Zip = $_POST["Zipedit"];
            
            //sql query to be executed
            $sql = "UPDATE `profile` SET `Password`='$Password' , `Email`='$Email' , `State`='$State' , `City`='$City' , `Zip`='$Zip' WHERE `First_name`='$fullName'";
            $result = mysqli_query($conn , $sql);

            if ($result) {
                echo "The record has been updated successfully<br>";
            } else {
                echo "The record could not be updated due to this error: " . mysqli_error($conn);   
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
                <div class="p-3">

                    <!-- -------------------------------------- -->
                    <div class="col-9 col-md-9 col-lg-10">

                        <!-- ----------------------------------------------------------------------------------------- -->
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
                                        <!-- Update form -->
                                        <form action="" method="post" class="d-flex  flex-column mx-auto mt-5  mb-5">
                                            <input type="hidden" name="snoEdit" id="snoEdit">

                                            <!-- Full Name -->
                                            <div class="col-6 mx-auto mt-3">
                                                <label for="fullNameedit" class="form-label">Full Name</label>
                                                <input type="text" id="fullNameedit" name="fullNameedit"
                                                    class="form-control form-control-md rounded border-1 border-success"
                                                    required placeholder='' value="<?php echo $fullName ?>">
                                                <div class="invalid-feedback">
                                                    Please provide a Full name.
                                                </div>
                                            </div>

                                            <!-- Password -->
                                            <div class="col-6 mx-auto mt-3">
                                                <label for="Passwordedit" class="form-label">Password</label>
                                                <input type="text" id="Passwordedit" name="Passwordedit"
                                                    class="form-control form-control-md rounded border-1 border-success"
                                                    required value="<?php echo $Password ?>">
                                                <div class="invalid-feedback">
                                                    Please provide a Password.
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-6 mx-auto mt-3">
                                                <label for="Emailedit" class="form-label">Email</label>
                                                <input type="text" id="Emailedit" name="Emailedit"
                                                    class="form-control form-control-md rounded border-1 border-success"
                                                    required value="<?php echo $Email ?>">
                                                <div class="invalid-feedback">
                                                    Please provide an Email.
                                                </div>
                                            </div>

                                            <!-- State -->
                                            <div class="col-6 mx-auto mt-3">
                                                <label for="Stateedit" class="form-label">State</label>
                                                <input type="text" id="Stateedit" name="Stateedit"
                                                    class="form-control form-control-md rounded border-1 border-success"
                                                    required value="<?php echo $State ?>">
                                                <div class="invalid-feedback">
                                                    Please provide a State.
                                                </div>
                                            </div>

                                            <!-- City -->
                                            <div class="col-6 mx-auto mt-3">
                                                <label for="Cityedit" class="form-label">City</label>
                                                <input type="text" id="Cityedit" name="Cityedit"
                                                    class="form-control form-control-md rounded border-1 border-success"
                                                    required value="<?php echo $City ?>">
                                                <div class="invalid-feedback">
                                                    Please provide a City.
                                                </div>
                                            </div>

                                            <!-- Zip -->
                                            <div class="col-6 mx-auto mt-3">
                                                <label for="Zipedit" class="form-label">Zip</label>
                                                <input type="text" id="Zipedit" name="Zipedit"
                                                    class="form-control form-control-md rounded border-1 border-success"
                                                    required value="<?php echo $Zip ?>">
                                                <div class="invalid-feedback">
                                                    Please provide a Zip.
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="col-6 mx-auto my-4 text-center">
                                                <button class="btn btn-warning px-4 py-2" type="submit">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                </form>
                            </div>

                        </div>

                        <!-- ----------------------------------------------------------------------------------------- -->
                        <div class="col-auto col-md-9 col-lg-12 w-75">
                            <div class="table-responsive">
                                <table id="Table" class="table table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th colspan="2">Profile</th>
                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                        <tr class="">
                                            <th scope="col">FullName</th>
                                            <?php 
                                    echo "<td>" . $fullName. "</td>";

                                ?>
                                        </tr>
                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Password</th>
                                            <?php

                                    $sql = "SELECT Password FROM profile WHERE First_name = '$fullName'";
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
                                            <th scope="col">Email</th>
                                            <?php

                                    $sql = "SELECT Email FROM profile WHERE First_name = '$fullName'";
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
                                            <th scope="col">State</th>
                                            <?php

                                    $sql = "SELECT State FROM profile WHERE First_name = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["State"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                    
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">City</th>
                                            <?php

                                    $sql = "SELECT City FROM profile WHERE First_name = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["City"] . "</td>";
                                        }
                                    } else {
                                        echo "<td>No shop found</td>";
                                    }
                                
                                    
                                ?>
                                        </tr>

                                        <!-- --------------------------------------------------- -->
                                        <tr class="">
                                            <th scope="col">Zip</th>
                                            <?php

                                    $sql = "SELECT Zip FROM profile WHERE First_name = '$fullName'";
                                    $result = mysqli_query($conn, $sql);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<td>" . $row["Zip"] . "</td>";
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
                                    $fullNameButtonId = isset($row['$First_name']) ? $row['$First_name'] : '';

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
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>



        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>

        <script>
        //----------------------------------- update ---------------------------------------

        const editButtons = document.querySelectorAll('.edit');

        editButtons.forEach((button) => {
            button.addEventListener("click", (event) => {
                console.log("Edit button clicked");
                const tr = event.target.closest('tr'); // Find the closest parent <tr> element

                // Extracting data from table cells
                const fullName = tr.cells[0].innerText.trim();
                const Password = tr.cells[1].innerText.trim();
                const Email = tr.cells[2].innerText.trim();
                const State = tr.cells[3].innerText.trim();
                const City = tr.cells[4].innerText.trim();
                const Zip = tr.cells[5].innerText.trim();

                // Assigning values to form fields
                document.getElementById('fullNameedit').value = fullName;
                document.getElementById('Passwordedit').value = Password;
                document.getElementById('Emailedit').value = Email;
                document.getElementById('Stateedit').value = State;
                document.getElementById('Cityedit').value = City;
                document.getElementById('Zipedit').value = Zip;

                // Assigning ID to hidden input field
                document.document.getElementById('snoEdit').value = button.id;;

                // Show the modal
                $('#exampleModal').modal('show');
            });
        });
        </script>




</body>

</html>