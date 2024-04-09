<?php
// Include navbar.php file
require 'navbar.php';

    // Access user data from session
    if (!isset($_SESSION['login_user'])) {
        header("Location: user_login_profile.php");
        exit();
    }



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
    // echo "Image ID: " . $imageId;
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

// $sql = "SELECT * FROM product WHERE product_name = '$imageId'";
$sql = "SELECT sno, product_name, seller_name, product_detail, product_price,product_qty, product_image, product_color, product_size FROM product WHERE product_name = '$imageId'";



if (!empty($priceFilter)) {
    // Split the price filter to get min and max values
    list($minPrice, $maxPrice) = explode("-", $priceFilter);
    // Add price filter condition to the SQL query
    // $sql .= " OR product_name = '$imageId'  product_price >= $minPrice AND product_price <= $maxPrice";
    $sql = "SELECT sno, product_name, seller_name, product_detail, product_price,product_qty, product_image, product_color, product_size 
            FROM product 
            WHERE product_name = '$imageId' 
            AND product_price >= $minPrice 
            AND product_price <= $maxPrice";

}

if (!empty($colorFilter)) {
    // Add color filter condition to the SQL query
    // $sql .= " AND product_color = '$colorFilter'";
    $sql = "SELECT sno, product_name, seller_name, product_detail, product_price,product_qty, product_image, product_color, product_size 
        FROM product 
        WHERE (product_name LIKE '$imageId' AND product_color = '$colorFilter')";

}

if (!empty($sizeFilter)) {
    // Add size filter condition to the SQL query
    // $sql .= " AND product_size = '$sizeFilter'";
    $sql = "SELECT sno, product_name, seller_name, product_detail, product_price,product_qty, product_image, product_color, product_size 
        FROM product 
        WHERE (product_name LIKE '$imageId' AND product_size = '$sizeFilter')";

}
// Execute the query to get the seller name
$result_seller = $conn->query($sql);

// Check if the result contains any rows
if ($result_seller->num_rows > 0) {
    // Fetch the seller name
    $row_seller = $result_seller->fetch_assoc();
    $seller_name = $row_seller['seller_name'];

    // Proceed with the insert query
    // Handle Buy logic
// Check if the Buy button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buyButton'])) {
    // Check if the user is logged in
    if (isset($_SESSION['login_user'])) {
        // Retrieve product details from the POST data
        $user_name = $_SESSION['login_user']; // Retrieve the username from the session
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $quantity = $_POST['quantity']; // Retrieve the quantity from the form

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
            $stmt = $conn->prepare("INSERT INTO user_add_to_card (user_name, seller_name, product_name, qty, product_price, product_image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssis", $user_name, $seller_name, $product_name, $quantity, $product_price, $product_image);
            $stmt->execute();
            $stmt->close();

            // Product added to cart successfully
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Product added to cart successfully
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
    } else {
        // User is not logged in
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Error: You must be logged in to buy products
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}

    

    // Check if the Add to Wishlist form is submitted
    if (isset($_POST['wishlistButton'])) {
        // Handle Add to Wishlist logic
        // Check if the user is logged in
        if (isset($_SESSION['login_user'])) {
            // Retrieve product details from the POST data
            $user_name = $_SESSION['login_user']; // Retrieve the username from the session
            $productId = $_POST['productId'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $quantity = $_POST['quantity']; // Retrieve quantity from the POST data
    
            // Check if the product already exists in the wishlist for the user
            $check_stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_name = ? AND product_name = ? AND product_price = ?");
            $check_stmt->bind_param("sss", $user_name, $product_name, $product_price);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
    
            if ($check_result->num_rows > 0) {
                // Product already exists in the wishlist
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        Product already exists in the wishlist!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            } else {
                // Insert product into wishlist
                $insert_stmt = $conn->prepare("INSERT INTO wishlist (user_name, seller_name, product_name, qty, product_price, product_image) VALUES (?, ?, ?, ?, ?, ?)");
                $insert_stmt->bind_param("ssssss", $user_name, $seller_name, $product_name, $quantity, $product_price, $product_image);
                $insert_stmt->execute();
    
                if ($insert_stmt->affected_rows > 0) {
                    // Product added to wishlist successfully
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Product added to wishlist successfully
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                } else {
                    // Error adding product to wishlist
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            Error: Unable to add product to wishlist
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                }
            }
        } else {
            // User is not logged in
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Error: You must be logged in to add products to wishlist
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
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
        height: 200px;
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
                            <input type="hidden" name="search_query" value="<?php echo htmlspecialchars($imageId); ?>">
                            <input type="hidden" name="imageId" value="<?php echo htmlspecialchars($imageId); ?>">
                        </form>
                    </div>


                    <!-- Color filter -->
                    <div class="color-filter mt-3 text-bg-dark ">
                        <h6>Color:</h6>
                        <form id="colorFilterForm" action="" method="GET">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="red" name="color" value="red">
                                <label for="red">Red</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="blue" name="color" value="blue">
                                <label for="blue">Blue</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="green" name="color" value="green">
                                <label for="green">Green</label><br>
                            </div>
                            <!-- Include the search_query (imageId) in the form -->
                            <input type="hidden" name="search_query" value="<?php echo htmlspecialchars($imageId); ?>">
                            <input type="hidden" name="imageId" value="<?php echo htmlspecialchars($imageId); ?>">
                        </form>
                    </div>

                    <!-- Size filter -->
                    <div class="size-filter mt-3 text-bg-dark ">
                        <h6>Size:</h6>
                        <form id="sizeFilterForm" action="" method="GET">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="s" name="size" value="s">
                                <label for="s">Small</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="m" name="size" value="m">
                                <label for="m">Medium</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="l" name="size" value="l">
                                <label for="l">Large</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="xl" name="size" value="xl">
                                <label for="xl">Extra Large</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="xxl" name="size" value="xxl">
                                <label for="xxl">Double Extra Large</label><br>
                            </div>
                            <!-- Include the search_query (imageId) in the form -->
                            <input type="hidden" name="search_query" value="<?php echo htmlspecialchars($imageId); ?>">
                            <input type="hidden" name="imageId" value="<?php echo htmlspecialchars($imageId); ?>">
                        </form>
                    </div>


                </div>
            </div>

            <!-- Product Display -->
           <!-- Product Display -->
<div class="col-9 col-md-9 col-lg-10"  >
    <div class="container ">
        <h2 calss="">Product List</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4 mt-3" style="overflow-y: auto; max-height: 90vh; -ms-overflow-style: none; scrollbar-width: none;">
    
        <?php
// Display all products based on the imageId
if ($result_seller && $result_seller->num_rows > 0) {
    while ($row = $result_seller->fetch_assoc()) {
        ?>
        <div class="col">
            <div class="card">
                <!-- Display product details -->
                <img src="<?php echo htmlspecialchars($row['product_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['product_name']); ?>">

                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['product_detail']); ?></p>
                    <p class="card-text"><?php echo htmlspecialchars($row['product_price']); ?> Rs</p>
                    <span class="d-flex ">
                            <p class="card-text me-5">Color: <?php echo htmlspecialchars($row['product_color']); ?></p>
                            <p class="card-text">Size: <?php echo htmlspecialchars($row['product_size']); ?></p>
                        </span>
                    <!-- Add quantity input -->
                    <form method="post">
                        <input type="hidden" name="product_name"
                               value="<?php echo htmlspecialchars($row['product_name']); ?>">
                        <input type="hidden" name="product_price"
                               value="<?php echo htmlspecialchars($row['product_price']); ?>">
                        <input type="hidden" name="product_image"
                               value="<?php echo htmlspecialchars($row['product_image']); ?>">
                        <input type="hidden" name="product_color"
                               value="<?php echo htmlspecialchars($row['product_color']); ?>">
                        <input type="hidden" name="product_size"
                               value="<?php echo htmlspecialchars($row['product_size']); ?>">
                        <!-- Include product size -->
                        <label for="quantity_<?php echo $row['sno']; ?>">Quantity:</label>
                        <?php
                        $max_quantity = isset($row['product_qty']) ? $row['product_qty'] : 0; // Check if 'product_qty' exists in the $row array
                        $disabled = ($max_quantity == 0) ? 'disabled' : ''; // Disable the input if quantity is 0
                        ?>
                        <input type="number" id="quantity_<?php echo $row['sno']; ?>" name="quantity" value="1" min="1" max="<?php echo $max_quantity; ?>" <?php echo $disabled; ?>>
                        <br>
                        <?php if ($max_quantity == 0) {
                            echo "<p class='text-danger'>This product is not available.</p>";
                            echo "<div class='btn-group mt-0' role='group' aria-label='Add to Cart or Wishlist'>";
                            echo "<button type='submit' class='btn btn-primary btn-sm me-2' name='buyButton' disabled>Add to Cart</button>";
                            echo "<input type='hidden' name='productId' value='" . htmlspecialchars($row['sno']) . "'>";
                            echo "<button type='submit' class='btn btn-success btn-sm' name='wishlistButton' disabled>Add to Wishlist</button>";
                            echo "</div>";
                        } else { ?>
                            <div class="btn-group mt-4" role="group" aria-label="Add to Cart or Wishlist">
                                <button type="submit" class="btn btn-primary btn-sm me-2" name="buyButton">Add to Cart</button>
                                <input type="hidden" name="productId" value="<?php echo htmlspecialchars($row['sno']); ?>">
                                <button type="submit" class="btn btn-success btn-sm" name="wishlistButton">Add to Wishlist</button>
                            </div>
                        <?php } ?>

                    </form>
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
        <script>
        // Add event listeners to color radio buttons
        document.querySelectorAll('input[name="color"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                // Submit form when color radio button is clicked
                document.getElementById('colorFilterForm').submit();
            });
        });

        // Add event listeners to size radio buttons
        document.querySelectorAll('input[name="size"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                // Submit form when size radio button is clicked
                document.getElementById('sizeFilterForm').submit();
            });
        });
        </script>

</body>

</html>
