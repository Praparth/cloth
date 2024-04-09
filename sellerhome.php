<?php
session_start();

include("register_connection.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Open the database connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check if the database connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the form data
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']); // Escape user input to prevent SQL injection
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Escape user input to prevent SQL injection

    // Prepare SQL statement with a SELECT query including the seller_status condition
    $sql = "SELECT sno, fullname, seller_status FROM `seller_register` WHERE fullname = '$fullName' AND Password = '$password'";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result && mysqli_num_rows($result) == 1) {
        // Fetch the result
        $row = mysqli_fetch_assoc($result);

        // Check if the seller_status is "Active"
        if ($row['seller_status'] == "Active") {
            // Register the user in the session
            $_SESSION['login_seller'] = $row['fullname'];
            $_SESSION['sno'] = $row['sno']; // Optionally, you can store other details in the session

            // Close the database connection
            mysqli_close($conn);

            // Redirect the user to the profile page
            header("location: seller_profile.php");
            exit();
        } else {
            // If seller_status is "unActive", display an alert
            $error = "Your account is currently inactive. Please contact the administrator.";
        }
    } else {
        // If result does not match the username and password, display an error message
        $error = "Your Login Name or Password is invalid";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>








<!-- Your HTML code continues from here -->

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

    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    .top-baner {
        background-image: url(https://static-assets-web.flixcart.com/fk-sp-static/images/prelogin/banner/Banner_Desktop_1280x545_1.webp);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 545px;
        /* You can adjust the height as needed */
        display: flex;
        align-items: center;
    }

    .top-baner .fs-1 {
        margin-left: 20px;
        /* Adjust the margin as needed for left spacing */
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><span class="fs-2 d-flex d-flex justify-content-around">
                    <span class="fw-bolder text-success ">P</span><span class="fw-bold text-warning ">p</span>
                </span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-6 fw-medium ">
                    <!-- sell online -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Sell Online
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Create Account</a></li>
                            <li><a class="dropdown-item" href="#">List Products</a></li>
                            <li><a class="dropdown-item" href="#">Storage & Shipping</a></li>
                            <li><a class="dropdown-item" href="#">Recieve Payments</a></li>
                            <li><a class="dropdown-item" href="#">Grow Faster</a></li>
                            <li><a class="dropdown-item" href="#">Seller App</a></li>
                            <li><a class="dropdown-item" href="#">Help & Support</a></li>
                        </ul>
                    </li>
                    <!-- fees and commission  -->
                    <li class="nav-item dropdown mx-sm-2 ">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Fees and Commission
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"> Payment Cycle</a></li>
                            <li><a class="dropdown-item" href="#">Fee Type</a></li>
                            <li><a class="dropdown-item" href="#">Calculate Gross Margin</a></li>
                        </ul>
                    </li>
                    <!-- Grow -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Grow
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">FAssured badge</a></li>
                            <li><a class="dropdown-item" href="#">Insights & Tools</a></li>
                            <li><a class="dropdown-item" href="#">Flipkart Ads</a></li>
                            <li><a class="dropdown-item" href="#">Flipkart Value Services</a></li>
                            <li><a class="dropdown-item" href="#">Shopping Festivals</a></li>
                            <li><a class="dropdown-item" href="#">Service Partners</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search">


                    <button type="button" class="border-0 px-5 py-3 fs-5 bg-light" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Login</button>


                    <button class="border-0  bg-warning p-2 py-3 fs-5 px-3">
                        <a href="seller_regiter.php" class="nav-link">
                            Start Selling </a>
                    </button>

                </form>
            </div>
        </div>
    </nav>
    <!-- start the write the code for  Page -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Login Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>
                <form id="sellerForm" class="col-12 needs-validation" novalidate action="" method="post">
                    <div class="col-10 mx-auto mt-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" id="fullName" name="fullName" class="form-control form-control-md rounded border-1 border-success" required>
                        <div class="invalid-feedback">
                            Please provide a Full name.
                        </div>
                    </div>
                    <div class="col-10 mx-auto mt-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-md rounded border-1 border-success" required>
                        <div class="invalid-feedback">
                            Please provide a Password.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="border-0 px-5 py-3 fs-5 bg-light" onclick="validateAndProceed()" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
            </div>
        </div>
    </div>
</div>

    <!-- ----------------------------------------------------------------------------------------- -->


    <!-- ------------------------------------------------------------------------------>

    <div class="container-fluid w-100 mb-5 ">
        <div class="row">
            <div class="col-lg-12 top-baner d-flex flex-column  text-left">
                <span class="col-12 d-flex flex-column fs-1 h-75 mb-0 mt-5 ">
                    <span class="fw-medium"> Become a Pp Seller </span>
                    <span> and sell to 45+Crore Customers</span>
                </span>

                <span class="d-flex col-12 text-center bg-light rounded mt-3 flex-wrap  row-cols-4 ">
                    <span class="col-sm-3 d-flex flex-column ">
                        <span class="text-primary fs-3 fw-medium">14 Lakh+</span>
                        <span class="">Seller community</span>
                    </span>
                    <span class="col-sm-3 d-flex flex-column border-start border-primary ">
                        <span class="text-primary fs-3 fw-medium">24x7</span>
                        <span class="">Online Business</span>
                    </span>
                    <span class="col-sm-3 d-flex flex-column border-start border-primary ">
                        <span class="text-primary fs-3 fw-medium">7</span>
                        <span class="">days* payment</span>
                    </span>
                    <span class="col-sm-3 d-flex flex-column border-start border-primary ">
                        <span class="text-primary fs-3 fw-medium">19000+</span>
                        <span class="">Pincodes served</span>
                    </span>
                </span>

            </div>
        </div>
    </div>

    <span class="d-flex flex-column mx-5">
        <span class="fs-1 fw-bold ">
            <span class="">Why do</span> <span class="text-primary"> sellers love selling on ️Flipkart? </span>
        </span>
        <span class="w-50 fw-light  fs-6">
            45 crore+ customers across India trust Flipkart.com to be their number 1 online shopping destination. It is
            no
            surprise that more than a million sellers trust their products to be made available 24x7 on Flipkart.
        </span>
    </span>


    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 d-flex flex-column flex-sm-row">
                <div class="m-4">
                    <div class="d-flex flex-column m-4 mb-5 my-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                        <div class="mb-3">
                            <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/prelogin/icons/__Opportunity.svg"
                                alt="" class="img-fluid" width="70px">
                            <span class="fw-bold fs-6"> Opportunity </span>
                        </div>
                        <div class="fs-6">45 crore+ of customers across 19000+ pincodes, and access to shopping
                            festivals like The Big Billion Days, and more.</div>
                    </div>
                    <div class="d-flex flex-column m-4 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                        <div class="mb-3">
                            <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/prelogin/icons/__Growth.svg"
                                alt="" class="img-fluid" width="70px">
                            <span class="fw-bold fs-6"> Growth </span>
                        </div>
                        <div class="fs-6">Sellers see an average 2.8X spike in growth, 2.3X more visibility, and
                            up to 5X growth in The Big Billion Days Sale.</div>
                    </div>
                </div>
                <div class="m-4">
                    <div class="d-flex flex-column m-4 my-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                        <div class="fw-bold fs-6 mb-3">
                            <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/prelogin/icons/__Ease.svg"
                                alt="" class="img-fluid" width="70px">
                            <span class=""> Ease of Doing Business </span>
                        </div>
                        <div class="fs-6">Create your Flipkart seller account in under 10 minutes with just 1
                            product and a valid GSTIN number.</div>
                    </div>
                    <div class="d-flex flex-column m-4 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                        <div class="fw-bold fs-6 mb-3">
                            <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/prelogin/icons/__Support.svg"
                                alt="" class="img-fluid" width="70px">
                            <span class=""> Additional Support </span>
                        </div>
                        <div class="fs-6">Account management services, exclusive training programs, business
                            insights, catalogue/photoshoot support, and more.</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 mx-auto text-center d-md-block d-none ">
                <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/prelogin/images/shopsy_1_1.webp"
                    alt="" class="img-fluid my-4" style="max-width: 70%;">
            </div>
        </div>
    </div>

    <div class="container my-5">
        <span class="d-flex flex-column ">
            <span class="fs-1 fw-bold "> <span class="text-primary">Your Journey </span> on Flipkart </span>
            <span class="fs-5 fw-light">
                Starting your online business with Flipkart is easy. 14 lakh+ sellers trust Flipkart with their business
            </span>
        </span>

        <div class="d-flex flex-sm-row row-cols-5  flex-column justify-content-around align-content-center ">
            <span class="d-flex flex-column col-10 mx-auto  col-sm-2 mx-sm-2 ">
                <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/create-icon.svg" alt="" width="">
                <span class="">Create</span>
                <span class="">Register in just 10 mins with valid GST, address, & bank details</span>
            </span>
            <span class="d-flex flex-column col-10 mx-auto  col-sm-2 mx-sm-2 ">
                <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/prelogin/icons/Group_2_1.svg"
                    alt="" width="">
                <span class="">Create</span>
                <span class="">Register in just 10 mins with valid GST, address, & bank details</span>
            </span>
            <span class="d-flex flex-column col-10 mx-auto  col-sm-2 mx-sm-2 ">
                <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/orders-icon.svg" alt="" width="">
                <span class="">Create</span>
                <span class="">Register in just 10 mins with valid GST, address, & bank details</span>
            </span>
            <span class="d-flex flex-column col-10 mx-auto  col-sm-2 mx-sm-2 ">
                <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/shipment-icon.svg" alt="" width="">
                <span class="">Create</span>
                <span class="">Register in just 10 mins with valid GST, address, & bank details</span>
            </span>
            <span class="d-flex flex-column col-10 mx-auto  col-sm-2 mx-sm-2 ">
                <img src="https://static-assets-web.flixcart.com/fk-sp-static/images/payment-icon.svg" alt="" width="">
                <span class="">Create</span>
                <span class="">Register in just 10 mins with valid GST, address, & bank details</span>
            </span>
        </div>


    </div>


    <!-- end the write the code for  Page-->
    <footer class="my-3 container-fluid" style="background-color: #504d4d; color: seashell; ">
        <div class="d-flex justify-content-center  fs-3 py-3  "> Popular categories to sell across India</div>
        <div class="col-12 d-flex flex-sm-row  flex-column  ">
            <span class="col-sm-3 d-flex flex-column my-4 mx-  shadow rounded">
                <span class="fs-4  mx-auto   ">Product Catager</span>
                <span class="d-flex flex-column mx-3 my-2">
                    <span class="">Sell Men's</span>
                    <span class="">Sell Women</span>
                    <span class="">Sell Kid's</span>
                    <span class="">Sell TopBrand</span>
                </span>
            </span>
            <span class="col-sm-3 d-flex flex-column my-4 mx- shadow rounded">
                <span class="fs-4  mx-auto">Sell Online</span>
                <span class="d-flex flex-column mx-3 my-2">
                    <span class="">Create Account</span>
                    <span class="">List Products</span>
                    <span class="">Storage & Shipping</span>
                    <span class="">Fees & Commission</span>
                    <span class="">Help & Support</span>
                </span>
            </span>
            <span class="col-sm-3 d-flex flex-column my-4 mx- shadow rounded">
                <span class="fs-4  mx-auto">Grow Your Business</span>
                <span class="d-flex flex-column mx-3 my-2">
                    <span class="">Insights & Tools</span>
                    <span class="">Flipkart Ads</span>
                    <span class="">Flipkart Value Services</span>
                    <span class="">Shopping Festivals</span>
                </span>
            </span>
            <span class="col-sm-3 d-flex flex-column my-4 mx- shadow rounded">
                <span class="fs-4  mx-auto">Learn More</span>
                <span class="d-flex flex-column mx-3 my-2">
                    <span class="">FAQs</span>
                    <span class="">Seller Success Stories</span>
                    <span class="">Seller Blogs</span>
                </span>
            </span>
        </div>
    </footer>

    <script>
    function validateAndProceed() {
        var form = document.getElementById('sellerForm');

        if (form.checkValidity()) {
            var fullName = document.getElementById('fullName').value.trim();
            var password = document.getElementById('password').value.trim();

            if (fullName === '' || password === '') {
                alert('Please fill in all the required fields.');
            } else {
                form.submit(); // Submit the form after validation
            }
        } else {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
        }
    }
    </script>


    <!-- // window.location.href = 'seller_profile.php'; -->



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>