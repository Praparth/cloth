<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    // Access user data from session
    if (!isset($_SESSION['login_user'])) {
        header("Location: user_login_profile.php");
        exit();
    }


$servername = "localhost";
$username = "root";
$password = "";
$database = "cloth";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the values from the form fields
    $newName = isset($_POST['new_name']) ? $_POST['new_name'] : '';
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';

    // Query to update the user's password based on their username
    $updateQuery = "UPDATE profile SET Password = '$newPassword' WHERE First_name = '$newName'";
    
    if ($conn->query($updateQuery) === TRUE) {
        // Password updated successfully
        header("Location: index.php"); // Redirect to index.php
        exit(); // Terminate script execution after redirection
    } else {
        // Error occurred while updating the password
        echo "<div class='alert alert-danger' role='alert'>Error updating password: " . $conn->error . "</div>";
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
            <span class=" fw-medium fs-4">Sign </span>
            <span class="my-3 d-flex  flex-column ">
                <form id="myForm" action="" method="post">
                    <label for="new_name">New User Name</label>
                    <input type="text" class="form-control w-75" name="new_name" id="new_name" required>
                    <label for="new_password">New Password</label>
                    <div class="d-flex">
                        <input type="password" class="form-control w-75" name="new_password" id="new_password" required>
                    </div>
                    <span class="d-flex flex-column my-5 ">
                        <button type="submit" id="submit" name="submit" class="fw-bold btn btn-success">
                            Update Profile
                        </button>
                    </span>
                </form>
            </span>
        </span>
    </div>

    <?php require 'footer.php' ?>

    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

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
