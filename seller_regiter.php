<!-- if ($result->num_rows > 0) {
        // At least one field already exists, add an error message and mark conflicting input fields
        

        // Mark conflicting input fields by adding them to the $errors array
        while ($row = $result->fetch_assoc()) {
            if ($row['fullname'] == $fullName) {
                $errors['fullName'] = "A record with this Full Name already exists.";
            }
            if ($row['shopno'] == $shopName) {
                $errors['shopname'] = "A record with this Shop Name already exists.";
            }
            if ($row['phoneno'] == $phoneNo) {
                $errors['phoneno'] = "A record with this Phone Number already exists.";
            }
            if ($row['Email'] == $email) {
                $errors['Email'] = "A record with this Email already exists.";
            }
            if ($row['Password'] == $password) {
                $errors['Password'] = "A record with this Password already exists.";
            }
           
            if ($row['Panno'] == $panno) {
                $errors['Panno'] = "A record with this PAN Number already exists.";
            }
            if ($row['GSTno'] == $GSTno) {
                $errors['GSTno'] = "A record with this GST Number already exists.";
            }
            if ($row['Accountholdername'] == $accountholdername) {
                $errors['Accountholdername'] = "A record with this Account Holder Name already exists.";
            }
            if ($row['Accountno'] == $accountno) {
                $errors['Accountno'] = "A record with this Account Number already exists.";
            }
            if ($row['IFSCno'] == $IFSCno) {
                $errors['IFSCno'] = "A record with this IFSC Number already exists.";
            }
        }
    } -->

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

$errors = array();
$success_message = ""; // Initialize the success message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullName = $_POST['fullName'];
    $shopName = $_POST['shopname'];
    $phoneNo = $_POST['phoneno'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $productToSell = $_POST['Product'];
    $panno = $_POST['Panno'];
    $GSTno = $_POST['GSTno'];
    $accountholdername = $_POST['Accountholdername'];
    $accountno = $_POST['Accountno'];
    $IFSCno = $_POST['IFSCno'];
    $seller_status = "Active";

    // Prepare SQL statement using prepared statement
    // Check if any field already exists in the database
    $checkStmt = $conn->prepare("SELECT * FROM seller_register WHERE fullname = ? OR shopno = ? OR phoneno = ? OR Email = ?");
    $checkStmt->bind_param("ssss", $fullName, $shopName, $phoneNo, $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // At least one field already exists, add an error message
        $errors['duplicate'] = "A record with some of this information already exists.";
        
    } else {
        // Proceed with insertion
        $sql = "INSERT INTO `seller_register`(`fullname`, `shopno`, `phoneno`, `Email`, `Password`, `Product`, `Panno`, `GSTno`, `Accountholdername`, `Accountno`, `IFSCno`,`seller_status`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssss", $fullName, $shopName, $phoneNo, $email, $password, $productToSell, $panno, $GSTno, $accountholdername, $accountno, $IFSCno, $seller_status);
    
        if ($stmt->execute()) {
            $success_message = "Data inserted successfully!";
            // Redirect to sellerhome.php
            header("Location: sellerhome.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            $errors['database'] = "Error inserting data into database: " . $conn->error;
        }
        $stmt->close();
    }
    

    // Close check statement
    $checkStmt->close();
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

<body class="p-3 m-0 border-0 bd-example m-0 border-0">

    

    <!-- Display success message -->
    <?php if ($success_message !== "") : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors['duplicate'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['duplicate']; ?>
            </div>
        <?php endif; ?>

        

    <div class="container mx-auto">
        <form id="sellerForm" class="col-12 needs-validation" novalidate action="" method="post">
            <div class="col-6 mx-auto mt-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" id="fullName" name="fullName"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['fullName']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['fullName'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['fullName']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto my-3">
                <label for="shopname" class="form-label">Shop Name</label>
                <input type="text" id="shopname" name="shopname"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['shopname']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['shopname'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['shopname']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="phoneno" class="form-label">Phone No</label>
                <input type="text" id="phoneno" name="phoneno"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['phoneno']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['phoneno'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['phoneno']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="Email" class="form-label">Email</label>
                <input type="text" id="Email" name="Email"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['Email']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['Email'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['Email']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="Password" class="form-label">Password</label>
                <input type="Password" id="Password" name="Password"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['Password']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['Password'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['Password']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="Product" class="form-label">Which product to sell</label>
                <select id="Product" name="Product" required class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['Product']) ? 'is-invalid' : ''; ?>">
                    <option selected disabled value=""></option>
                    <option value="Man">Man</option>
                    <option value="Women">Women</option>
                    <option value="Kids(Boy)">Kids(Boy)</option>
                    <option value="Kids(girl)">Kids(girl)</option>
                </select>
                <?php if (isset($errors['Product'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['Product']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="Panno" class="form-label">PAN NO</label>
                <input type="text" id="Panno" name="Panno"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['Panno']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['Panno'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['Panno']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="GSTno" class="form-label">GST NO</label>
                <input type="text" id="GSTno" name="GSTno"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['GSTno']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['GSTno'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['GSTno']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="Accountholdername" class="form-label">Account holder name NO</label>
                <input type="text" id="Accountholdername" name="Accountholdername"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['Accountholdername']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['Accountholdername'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['Accountholdername']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="Accountno" class="form-label">Account NO</label>
                <input type="number" id="Accountno" name="Accountno"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['Accountno']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['Accountno'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['Accountno']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-6 mx-auto">
                <label for="IFSCno" class="form-label">IFSC NO</label>
                <input type="text" id="IFSCno" name="IFSCno"
                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['IFSCno']) ? 'is-invalid' : ''; ?>"
                    required>
                <?php if (isset($errors['IFSCno'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['IFSCno']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Rest of the form fields -->

            <div class="col-6 mx-auto my-4 text-center  ">
                <button class="btn btn-dark px-4 py-2" type="submit" onclick="validateAndProceed()">Submit</button>

            </div>
        </form>
        
    </div>

    <?php require 'footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

<script>
        function validateAndProceed() {
            var form = document.getElementById('sellerForm');

            if (form.checkValidity()) {
                // Custom validation logic
                var fullName = document.getElementById('fullName').value.trim();
                var shopName = document.getElementById('shopname').value.trim();
                var phoneNo = document.getElementById('phoneno').value.trim();
                var Email = document.getElementById('Email').value.trim();
                var Password = document.getElementById('Password').value.trim();
                var productToSell = document.getElementById('Product').value;
                var Panno = document.getElementById('Panno').value.trim();
                var GSTno = document.getElementById('GSTno').value.trim();
                var Accountholdername = document.getElementById('Accountholdername').value.trim();
                var Accountno = document.getElementById('Accountno').value.trim();
                var IFSCno = document.getElementById('IFSCno').value.trim();

                if (fullName === '' || shopName === '' || phoneNo === '' || productToSell === '' || Panno === '' ||
                    GSTno === '' || Accountholdername === '' || Accountno === '' || IFSCno === '' || Email === '' ||
                    Password === '') {
                    // Display an error message if any field is empty
                    alert('Please fill in all the required fields.');
                } else {
                    // Proceed to the next page
                    window.location.href = 'admin_seller_for_seller_login.php';
                }
            } else {
                // Bootstrap validation will display error messages for empty required fields
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
            }
        }
    </script>


</body>

</html>
