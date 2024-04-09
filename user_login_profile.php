<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "cloth";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $admin_name = 'Parth';
    $admin_password = 'Parth123456';

    // Query to check if the entered username exists in the database
    $checkUserQuery = "SELECT * FROM profile WHERE First_name = '$name'";
    
    $resultUser = $conn->query($checkUserQuery);

    if($name == $admin_name && $password == $admin_password) {
        header("Location: admin_dashboard.php");


    } else{

        if ($resultUser->num_rows > 0) {
            // User with the entered username exists in the database
            $row = $resultUser->fetch_assoc();
            $storedPassword = $row['Password'];
            $fullName = $row['First_name']; // Retrieve full name from the database
            $userStatus = $row['user_status']; // Retrieve user status from the database
            
            // Check if the user status is active
            if ($userStatus == 'Active') {
                // Check if the entered password matches the stored password
                if ($password == $storedPassword) {
                    // Register $fullName, $password and redirect to file "user_profile.php"
                    // Start the session
                    session_start();
                    $_SESSION['login_user'] = $name;
                    // Passwords match, redirect to home page
                    header("Location: second_index.php");
                    exit(); // Stop further execution of PHP script
                } else {
                    // Passwords don't match, display alert message
                    echo "<div class='alert alert-danger' role='alert'>Incorrect password. Please try again.</div>";
                }
            } else {
                // User's account is not active, display alert message
                echo "<div class='alert alert-danger' role='alert'>Your account is not active. Please contact the administrator.</div>";
            }
        } else {
            // User with the entered username doesn't exist, display alert message
            echo "<div class='alert alert-danger' role='alert'>Username not found. Please enter a valid username.</div>";
        }
    } 
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP Cloth</title>
    <link rel="shortcut icon" type="x-icon" href="/image/icon1.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    

    <div class="col-12  container d-flex flex-sm-row  flex-column   " style="min-height: 55vh;  margin-top: 10%">
        <span class="col-sm-6 bg-light d-flex flex-column p-5   ">
            <span class="fw-bold fs-2  ">EXISTING <span class="fs-3 fw-light">CUSTOMERS</span></span>
            <span class=" fw-medium fs-4">Sign Into Next</span>
            <span class="my-3 d-flex  flex-column ">
                <form id="myForm" action="" method="post">
                    <label for="name">User Name</label>
                    <input type="text" class="form-control w-75" name="name" id="name" required>
                    <label for="password">YOUR PASSWORD</label>
                    <div class="d-flex">
                        <input type="password" class="form-control w-75" name="password" id="password" required>
                        <!-- <i class="bi bi-eye-slash border-1  border-warning bg-white p-1" id="togglePassword"></i> -->
                    </div>
                    <span class="d-flex flex-column ">
                        <a href="user_smtp_email.php" class="align-self-end my-3 text-success">Forgotten Password</a>
                        <button type="submit" id="submit" name="submit" class="fw-bold btn btn-success">
                            Sign In
                        </button>
                    </span>
                </form>
            </span>
        </span>

        <span class="col-sm-6 d-flex flex-column align-items-center my-4   ">
            <span class="fw-bold fs-2 ">NEW <span class="fw-normal">CUSTOMERS</span></span>
            <button class="btn btn-dark w-75 mt-3 "><a href="register.php" class="nav-link ">REGISTER NOW</a>
            </button>
        </span>
    </div>

    <?php require 'footer.php' ?>

    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute using getAttribute() method
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye');
        });
    </script>


</body>

</html>