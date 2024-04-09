<?php
session_start();

$_SESSION['email'] = 'user_email';

$page_title = "Password Reset Form";

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email']; // Assuming email is submitted through the form
    
    // Query to check if the email exists in the database
    $checkQuery = "SELECT Email FROM `profile` WHERE Email = '$email'";
    
    // Execute the query
    $result = $conn->query($checkQuery);
    
    if ($result->num_rows > 0) {
        // Email exists in the database
        header("Location: user_forget_password.php"); // Redirect to index_second.php
        exit(); // Terminate script execution after redirection
    } else {
        // Email does not exist in the database
        echo "<div class='alert alert-danger' role='alert'>Email not found.</div>";
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


<div class="col-12 container d-flex flex-sm-row flex-column" style="min-height: 55vh; margin-top: 10%">
    <span class="col-sm-6 bg-light d-flex flex-column p-5">
        <span class="fw-medium fs-4">Reset Password</span>
        <span class="my-3 d-flex flex-column">
            <form id="myForm" method="post">
                <label for="email">Enter Your email</label>
                <input type="email" class="form-control w-75" name="email" id="email" required>
                <span class="d-flex flex-column my-5">
                    <button type="button" id="submit" name="password_rest_link" class="fw-bold btn btn-success">
                        Send password Link
                    </button>
                </span>
            </form>
            <div id="error-message" style="color: red; display: none;"></div>
        </span>
    </span>
</div>

<script>
document.getElementById('submit').addEventListener('click', function () {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'user_password_reset_code.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.responseText;
            if (response === 'Sent') {
                // Redirect to another page upon successful email sending
                window.location.href = 'user_email_otp.php';
            } else {
                // Display error message
                document.getElementById('error-message').innerText = 'Error: ' + response;
                document.getElementById('error-message').style.display = 'block';
            }
        }
    };
    xhr.send('email=' + encodeURIComponent(document.getElementById('email').value));
});
</script>

</body>
</html>
