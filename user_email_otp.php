<?php
session_start();

    // Access user data from session
    if (!isset($_SESSION['login_user'])) {
        header("Location: user_login_profile.php");
        exit();
    }


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the OTP entered by the user
    $entered_otp = isset($_POST['otp']) ? $_POST['otp'] : '';

    // Get the OTP stored in the session
    $stored_otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : '';

    // Compare the entered OTP with the stored OTP
    if ($entered_otp === $stored_otp) {
        // OTPs match, redirect to another page
        header("Location: user_forget_password.php");
        exit();
    } else {
        // OTPs do not match, show an error message or take appropriate action
        echo "Invalid OTP. Please try again.";
    }
}
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
            <span class=" fw-medium fs-4"> Reset Password </span>
            <span class="my-3 d-flex  flex-column ">
                <form id="myForm" method="post">
                    <label for="otp">Enter Your OTP</label>
                    <input type="text" class="form-control w-75" name="otp" id="otp" required>
                    <span class="d-flex flex-column my-5 ">
                        <button type="submit" id="submit" name="password_reset_link" class="fw-bold btn btn-success">
                            Reset Password
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
</body>
</html>
