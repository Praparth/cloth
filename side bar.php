<?php
// Include navbar.php file
require 'navbar.php';

// Access user data from session
$fullName = $_SESSION['login_seller'];


// Your database connection code goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cloth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the image ID is present in the query parameters
if(isset($_GET['imageId'])) {
    // Retrieve the image ID from the query parameters
    $imageId = mysqli_real_escape_string($conn, $_GET['imageId']);

    // Store the image ID in the session
    $_SESSION['imageId'] = $imageId;

    // Fetch data or perform actions based on the image ID
    // You can perform further processing or database queries based on the image ID
    echo "Image ID: " . $imageId;
} else {
    // If image ID is not present in the query parameters, handle it accordingly
    echo "Image ID not found in the query parameters.";
    exit; // Stop further execution as imageId is required for filtering
}

// Initialize variables for filters
$priceFilter = "";
$colorFilter = "";
$sizeFilter = "";

// Check if any filter is applied
if (isset($_GET['price'])) {
    $priceFilter = mysqli_real_escape_string($conn, $_GET['price']);
}

if (isset($_GET['color'])) {
    $colorFilter = mysqli_real_escape_string($conn, $_GET['color']);
}

if (isset($_GET['size'])) {
    $sizeFilter = mysqli_real_escape_string($conn, $_GET['size']);
}

// Build the SQL query based on filters
$sql = "SELECT * FROM product WHERE product_name = '$imageId'";


if (!empty($priceFilter)) {
    $priceRange = explode('-', $priceFilter);
    if (count($priceRange) == 2) {
        $minPrice = $priceRange[0];
        $maxPrice = $priceRange[1];
        $sql .= " AND product_price BETWEEN $minPrice AND $maxPrice";
    }
}

if (!empty($colorFilter)) {
    $sql .= " AND product_color = '$colorFilter'";
}

if (!empty($sizeFilter)) {
    $sql .= " AND product_size = '$sizeFilter'";
}

$result = $conn->query($sql);

// Check if the Buy button is clicked and data is sent via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    // Check if the user is logged in
    if (isset($_SESSION['login_user'])) {
        // Retrieve product details from the POST data
        $user_name = $_SESSION['login_user']; // Retrieve the username from the session
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        // Check if the user has already bought the product
        $check_stmt = $conn->prepare("SELECT * FROM user_add_to_card WHERE user_name = ? AND product_name = ? AND product_price = ?");
        $check_stmt->bind_param("sss", $user_name, $product_name, $product_price);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Product has already been bought
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    You have already bought this product!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        } else {
            // Prepare and execute the insert query
            $stmt = $conn->prepare("INSERT INTO user_add_to_card (user_name, product_name, seller_name, product_price, product_image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $user_name, $product_name, $fullName,$product_price, $product_image);
            $stmt->execute();
            $stmt->close();

            // Product added to cart successfully
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Product added to cart successfully
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }

        $check_stmt->close();
    } else {
        // User is not logged in
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Error: You must be logged in to buy products
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
    .card {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-img-top {
            width: 100%;
            height: 200px; /* Set a fixed height for the image */
            /* object-fit: cover; Ensure the image covers the entire space */
        }

        .card-body {
            flex: 1;
        }
    </style>
</head>

<body>

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div class="bg-dark col-3 col-sm-5 col-md-3 col-lg-2 min-vh-100 d-flex flex-column justify-content-between">
                <div class="bg-dark p-2">

                    <!-- Price filter -->
                    <div class="price-filter text-bg-dark ">
                        <h6>Price:</h6>
                        <form id="priceFilterForm" action="" method="GET">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="under_250" name="price" value="0-250">
                                <label class="form-check-label" for="under_250">Under Rs250</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="250_to_500" name="price"
                                    value="250-500">
                                <label class="form-check-label" for="250_to_500">Rs250 - Rs500</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="500_to_1000" name="price"
                                    value="500-2000">
                                <label class="form-check-label" for="500_to_1000">Rs500 - Rs1000</label>
                            </div>

                            <!-- Include the search_query (imageId) in the form -->
                            <input type="hidden" name="search_query" value="<?php echo $imageId; ?>">
                            <input type="hidden" name="imageId" value="<?php echo $imageId; ?>">
                        </form>
                    </div>


                    <!-- Color filter -->
                    <div class="color-filter mt-3 text-bg-dark ">
                        <h6>Color:</h6>
                        <form action="" method="GET">
                            <input type="radio" id="red" name="color" value="red">
                            <label for="red">Red</label><br>
                            <input type="radio" id="blue" name="color" value="blue">
                            <label for="blue">Blue</label><br>
                            <input type="radio" id="green" name="color" value="green">
                            <label for="green">Green</label><br>

                            <!-- Include the search_query (product name) in the form -->
                            <input type="hidden" name="search_query" value="<?php echo $search_query; ?>">
                        </form>
                    </div>

                    <!-- Size filter -->
                    <div class="size-filter mt-3 text-bg-dark ">
                        <h6>Size:</h6>
                        <form action="" method="GET">
                            <input type="radio" id="s" name="size" value="s">
                            <label for="s">Small</label><br>
                            <input type="radio" id="m" name="size" value="m">
                            <label for="m">Medium</label><br>
                            <input type="radio" id="l" name="size" value="l">
                            <label for="l">Large</label><br>
                            <input type="radio" id="xl" name="size" value="xl">
                            <label for="xl">Extra Large</label><br>
                            <input type="radio" id="xxl" name="size" value="xxl">
                            <label for="xxl">Double Extra Large</label><br>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Display -->
            <div class="col-9 col-md-9 col-lg-10">
                <div class="container mt-5">
                    <h2>Product List</h2>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php
                        // Display all products based on the imageId
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col">
                            <div class="card">
                                <!-- Display product details -->
                                <img src="<?php echo $row['product_image']; ?>" class="card-img-top"
                                    alt="<?php echo $row['product_name']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                                    <p class="card-text"><?php echo $row['product_detail']; ?></p>
                                    <p class="card-text"><?php echo $row['product_price']; ?> Rs</p>

                                    <div class="card-buttons">
                                        <!-- Form to buy product -->
                                        <form method="post">
                                            <input type="hidden" name="product_name"
                                                value="<?php echo $row['product_name']; ?>">
                                            <input type="hidden" name="product_price"
                                                value="<?php echo $row['product_price']; ?>">
                                            <input type="hidden" name="product_image"
                                                value="<?php echo $row['product_image']; ?>">
                                            <button type="submit" class="btn btn-primary"
                                                name="buy_product">Buy</button>
                                            <a href="#" class="btn btn-success">Add to Wishlist</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo "0 results";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content end -->

        <?php require 'footer.php'; ?>

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

        <script>
        // Add event listeners to radio buttons
        document.querySelectorAll('input[name="price"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                // Submit form when radio button is clicked
                document.getElementById('priceFilterForm').submit();
            });
        });
        </script>

</body>

</html>