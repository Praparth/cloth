<?php 
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['login_seller'])) {
        // Redirect to login page if user is not logged in
        header("Location: seller.php");
        exit();
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form data
        processForm();
        // Redirect to prevent form resubmission
        header("Location: ".$_SERVER['REQUEST_URI']);
        exit();
    }

    // Function to process form data
    function processForm() {
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

            // Check if all required fields are filled
            if (isset($_POST['seller_name'], $_POST['product_name'], $_POST['product_price'], $_POST['product_detail'], $_FILES['product_image'], $_POST['product_type'], $_POST['product_size'], $_POST['product_color'])) {
                // Prepare and bind the SQL statement
                $stmt = $conn->prepare("INSERT INTO product (seller_name, product_name, product_price, product_qty, product_detail, product_type, product_size, product_color, product_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if (!$stmt) {
                    die("Error: " . $conn->error);
                }

                $stmt->bind_param("ssdssssss", $seller_name, $product_name, $product_price, $product_qty, $product_detail, $product_type, $product_size, $product_color, $product_image);

                // Set parameters
                $seller_name = $_POST['seller_name'];
                $product_name = $_POST['product_name'];
                $product_price = $_POST['product_price'];
                $product_qty = $_POST['product_qty'];
                $product_detail = $_POST['product_detail'];
                $product_image = $_FILES['product_image']['name'];
                $product_type = $_POST['product_type'];
                $product_size = $_POST['product_size'];
                $product_color = $_POST['product_color'];
            // Handle image upload
            $target_dir = "uploads/";

            // Create the directory if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Generate a unique filename to prevent overwriting existing files
            $target_file = $target_dir . uniqid() . '_' . basename($_FILES["product_image"]["name"]);

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $product_image = $target_file;
                // Execute the statement
                if ($stmt->execute()) {
                    echo '<div class="alert alert-success" role="alert">Product added successfully</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Error uploading image.</div>';
            }
            
            // Close statement
            $stmt->close();
        } else {
            echo '<div class="alert alert-danger" role="alert">All fields are required.</div>';
        }

        // Close connection
        $conn->close();
    }

    // Access user data from session
    $fullName = $_SESSION['login_seller'];

    // Display user details
    // echo "Welcome, " . $fullName . "!<br>";
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
            <div
                class="bg-dark col-4 col-sm-3  col-md-3 col-lg-3 max-vh-100 d-flex flex-column justify-content-between">
                <?php require 'seller_side_bar.php'?>
            </div>
            <!-- ------------------------------------------------------------------------------------ -->
            <div class="col-8 col-sm-9">
                <div class="p-3">
                    <div class="col-12 col-md-9 col-lg-10 py-3 mt-3"
                        style="overflow-y: auto; max-height: 90vh; -ms-overflow-style: none; scrollbar-width: none;">

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="seller_name" class="form-label">Seller Name:</label>
                                <input type="text" id="seller_name" name="seller_name" class="form-control"
                                    value="<?php echo $fullName?>" readonly>

                            </div>
                            <div class="mb-3">
                                <label for="product_name" class="form-label">Product Name:</label>
                                <input type="text" id="product_name" name="product_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="product_price" class="form-label">Product Price:</label>
                                <input type="number" id="product_price" name="product_price" class="form-control"
                                    min="0" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="product_qty" class="form-label">Product Quantity:</label>
                                <input type="number" id="product_qty" name="product_qty" class="form-control" min="1"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="product_detail" class="form-label">Product Detail:</label>
                                <textarea id="product_detail" name="product_detail" class="form-control" rows="4"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="product_image" class="form-label">Product Image:</label>
                                <input type="file" id="product_image" name="product_image" class="form-control"
                                    accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="product_type" class="form-label">Product type:</label>

                                <select id="product_type" name="product_type" required
                                    class="form-control form-control-md rounded border-1 border-success <?php echo isset($errors['product_type']) ? 'is-invalid' : ''; ?>">
                                    <option selected disabled value=""></option>
                                    <option value="Man">Man</option>
                                    <option value="Women">Women</option>
                                    <option value="Kids(Boy)">Kids(Boy)</option>
                                    <option value="Kids(girl)">Kids(girl)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Size:</label><br>
                                <span class="fs-5">
                                    <input type="radio" id="size_s" name="product_size" value="S">
                                    <label for="size_s" class="me-4">S</label>
                                    <input type="radio" id="size_m" name="product_size" value="M">
                                    <label for="size_m" class="me-4">M</label>
                                    <input type="radio" id="size_l" name="product_size" value="L">
                                    <label for="size_l" class="me-4">L</label>
                                    <input type="radio" id="size_xl" name="product_size" value="XL">
                                    <label for="size_xl" class="me-4">XL</label>
                                    <input type="radio" id="size_xxl" name="product_size" value="XXL">
                                    <label for="size_xxl" class="me-4">XXL</label>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Product Color:</label><br>
                                <span class="fs-5">
                                    <input type="radio" id="color_red" name="product_color" value="Red">
                                    <label for="color_red" class="me-4 text-danger">Red</label>
                                    <input type="radio" id="color_blue" name="product_color" value="Blue">
                                    <label for="color_blue" class="me-4 text-primary">Blue</label>
                                    <input type="radio" id="color_green" name="product_color" value="Green">
                                    <label for="color_green" class="me-4 text-success">Green</label>
                                    <input type="radio" id="color_yellow" name="product_color" value="Yellow">
                                    <label for="color_yellow" class="me-4 text-warning">Yellow</label>
                                </span>
                            </div>


                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>