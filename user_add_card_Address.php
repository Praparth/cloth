<?php
session_start();

    // Access user data from session
    if (!isset($_SESSION['login_user'])) {
        header("Location: user_login_profile.php");
        exit();
    }


// Access user data from session
$fullName = $_SESSION['login_user'];


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['message']; // Corrected typo
    $country = $_POST['country'];
    $state = $_POST['state'];
    $order_notes = $_POST['notes'];

    // Store form data in session variables
    $_SESSION['shipping_info'] = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'country' => $country,
        'state' => $state,
        'order_notes' => $order_notes
    );

    // Redirect to the confirmation page
    header("Location: user_add_card_confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>pp Cloth</title>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h4>CHECKOUT</h4>
            <h5>Ecommerce / Checkout</h5>
        </div>

        <div class="d-flex col-12">
            <div class="d-flex flex-column col-md-3 mt-5">
                <div class="box p-3  bg-primary  text-center text-white mx-2 ">
                    <a href="user_add_card_Address.php" class="text-decoration-none text-dark">
                        <i class="fas fa-truck-fast fa-3x"></i>
                        <p>Shipping Info</p>
                    </a>
                </div>
                <div class="box p-3 bg-light text-center mx-2 my-5">
                    <a href="user_add_card_confirmation.php" class="text-decoration-none text-dark">
                        <i class="fas fa-square-check fa-3x"></i>
                        <p>Confirmation</p>
                    </a>
                </div>
                <div class="box p-3 bg-light text-center mx-2 ">
                    <a href="user_add_card_payment.php" class="text-decoration-none text-dark">
                        <i class="fas fa-money-bill fa-3x"></i>
                        <p>Payment Info</p>
                    </a>
                </div>
            </div>


            <div class="p-3 bg-light col-9"
                style="overflow-y: auto; max-height: 90vh; -ms-overflow-style: none; scrollbar-width: none;">

                <h3>Shipping information</h3>
                <h4>Fill All Information below</h4>
                <form action="#" method="post">
                    <!-- Update action to point to the same page and method to "post" -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="fname" class="form-label">Name</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="fname" name="fname"
                                placeholder="Enter your name" value="<?php echo $fullName ?>" readonly required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="email" class="form-label">Email Address</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your Email" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="phone" class="form-label">Phone</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Enter your phone no">
                            <div id="phoneError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="message" class="form-label">Address</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" id="message" name="message" rows="5"
                                placeholder="Enter your Address" required></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="country" class="form-label">Country</label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-select" id="country" name="country" required>
                                <option value="">Select your country</option>
                                <option value="India">India</option>
                                <option value="Usa">USA</option>
                                <option value="Japan">Japan</option>
                                <option value="Canada">Canada</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="state" class="form-label">States</label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-select" id="state" name="state" required>
                                <option value="">Select your state</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Odisa">Odisa</option>
                                <option value="Rajasthan">Rajasthan</option>
                                <option value="Goa">Goa</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="notes" class="form-label">Order notes:</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" id="notes" name="notes" rows="5"
                                placeholder="Write your notes" required></textarea>
                        </div>
                    </div>

                    <div class="row mt-3 d-flex">
                        <div class="col-md-9 offset-md-3 justify-content-center">
                            <a href="user_add_to_card.php" class="text-decoration-none me-2">Back to shopping cart</a>
                            <button type="submit" class="btn btn-primary">Proceed to Shipping</button>
                        </div>
                    </div>
                </form>

                
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var phoneInput = document.getElementById('phone');
        var phoneError = document.getElementById('phoneError');

        phoneInput.addEventListener('input', function(event) {
            var phoneNumber = event.target.value.trim();
            var isValid = /^[1-9][0-9]{0,9}$/.test(phoneNumber);

            if (!isValid) {
                phoneError.textContent =
                    'Phone number must contain only digits, not start with 0, and be between 1 and 10 digits long';
                phoneInput.classList.add('is-invalid');
            } else {
                phoneError.textContent = '';
                phoneInput.classList.remove('is-invalid');
            }
        });
    });
    </script>
</body>

</html>