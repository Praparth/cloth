<?php
    $insert = false;
    $update = false;
    $delete = false;

    $server = "localhost";
    $username = "root";
    $product_size = "";
    $database = "cloth";
    $conn = mysqli_connect($server, $username, $product_size, $database);

   

    if (!$conn) {
        die("Error: " . mysqli_connect_error());
    }
    
    // delete the record
    if(isset($_GET['delete'])) {
        $sno = $_GET['delete'];
        // $delete = true;
            $sql = "DELETE FROM `product` WHERE `sno`=$sno";
            $result = mysqli_query($conn , $sql);

    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['snoEdit'])){
            // Update the record
            $sno = $_POST['snoEdit'];
            $seller_name = $_POST['seller_nameedit'];
            $product_name = $_POST['product_nameedit'];
            $product_price = $_POST['product_priceedit'];
            $product_detail = $_POST['product_detailedit'];
            $product_type = $_POST['product_typeedit'];
            $product_size = $_POST['product_sizeedit'];
            $product_color = $_POST['product_coloredit'];
            $product_image = $_POST['product_imageedit'];
            
            // Handle image upload if a new image is provided
            if (isset($_FILES['product_imageedit']) && $_FILES['product_imageedit']['error'] === UPLOAD_ERR_OK) {
                // Handle file upload
                $product_image = $_FILES['product_imageedit']['name'];
                $target_dir = "uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $target_file = $target_dir . uniqid() . '_' . basename($_FILES["product_imageedit"]["name"]);
                if (move_uploaded_file($_FILES["product_imageedit"]["tmp_name"], $target_file)) {
                    $product_image = $target_file;
                } else {
                    echo "Error uploading image.";
                    exit(); // Exit script if image upload fails
                }
            } else {
                // If no new image is provided, retain the existing image
                // $product_image = $_POST['current_product_image']; // Assuming you have a hidden field containing the current image path
            }
        
            // SQL query to update the record
            $sql = "UPDATE `product` SET `seller_name`='$seller_name', `product_name`='$product_name', `product_price`='$product_price', `product_detail`='$product_detail', `product_size`='$product_size', `product_type`='$product_type', `product_color`='$product_color', `product_image`='$product_image' WHERE `sno`='$sno'";
            $result = mysqli_query($conn, $sql);
        
            if($result){
                echo "The record has been updated successfully.";
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
        
    
    

                else {
                    // All fields are present, proceed with inserting the product details
                    $seller_name = $_POST['seller_name'];
                    $product_name = $_POST['product_name'];
                    $product_price = $_POST['product_price'];
                    $product_detail = $_POST['product_detail'];
                    $product_image = $_FILES['product_image']['name'];
                    $product_type = $_POST['product_type'];
                    $product_size = $_POST['product_size'];
                    $product_color = $_POST['product_color'];
                
                    // Prepare and bind the SQL statement
                    $stmt = $conn->prepare("INSERT INTO product (seller_name, product_name, product_price, product_detail, product_image, product_type, product_size, product_color) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    if (!$stmt) {
                        die("Error: " . $conn->error);
                    }
                
                    $stmt->bind_param("ssdsssss", $seller_name, $product_name, $product_price, $product_detail, $product_image, $product_type, $product_size, $product_color);
                
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
                }
    }     
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
            <div class="bg-dark col-4 col-sm-3  col-md-3 col-lg-3 vh-100 d-flex flex-column justify-content-between">
                <?php require 'admin_side_bar.php'?>
            </div>
            <!-- start  -->
            <div class="col-8 col-sm-9">
                <div class="p-3">
                    <!-- ---------------------------------------------------------------------------------------- -->

                    <!-- user data inser Form  (start) -->
                    <div class="col-8 col-sm-9">
                        <div class="p-3">
                            <div class="col-12 col-md-9 col-lg-10 py-3">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="seller_name" class="form-label">Seller Name:</label>
                                        <input type="text" id="seller_name" name="seller_name" class="form-control"
                                            value="">

                                    </div>
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name:</label>
                                        <input type="text" id="product_name" name="product_name" class="form-control"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_price" class="form-label">Product Price:</label>
                                        <input type="number" id="product_price" name="product_price"
                                            class="form-control" min="0" step="0.01" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_detail" class="form-label">Product Detail:</label>
                                        <textarea id="product_detail" name="product_detail" class="form-control"
                                            rows="4" required></textarea>
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


                    <!-- user data inser Form  (end) -->

                    <!-- ---------------------------------------------------------------------------------------- -->

                    <!-- user data be update (Start) -->
                    <!---------------------------------------- update ------------------------------------------------>
                    <!-- Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="" method="post" class="d-flex  flex-column mx-auto mt-5  mb-5">
                                        <input type="hidden" name="snoEdit" id="snoEdit">
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="seller_nameedit" class="form-label">seller_name</label>
                                            <input type="text" id="seller_nameedit" name="seller_nameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a seller_name.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto my-3">
                                            <label for="product_nameedit" class="form-label">product_name</label>
                                            <input type="text" id="product_nameedit" name="product_nameedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a Shop name.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto">
                                            <label for="product_priceedit" class="form-label">product_price</label>
                                            <input type="text" id="product_priceedit" name="product_priceedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a Phone number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="product_detailedit" class="form-label">product_detail</label>
                                            <input type="text" id="product_detailedit" name="product_detailedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a product_detail .
                                            </div>
                                        </div>

                                        <div class="col-6 mx-auto my-3">
                                            <label for="product_typeedit" class="form-label">Which product to
                                                sell</label>
                                            <select class="border-1 border-success form-select form-select-md"
                                                id="product_typeedit" name="product_typeedit" required>
                                                <option selected disabled value=""></option>
                                                <option value="Man">Man</option>
                                                <option value="Women">Women</option>
                                                <option value="Kids(Boy)">Kids(Boy)</option>
                                                <option value="Kids(girl)">Kids(girl)</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid state.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="product_sizeedit" class="form-label">product_size</label>
                                            <input type="product_size" id="product_sizeedit" name="product_sizeedit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a product_size.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="product_coloredit" class="form-label">product_color</label>
                                            <input type="text" id="product_coloredit" name="product_coloredit"
                                                class="form-control form-control-md rounded border-1 border-success"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a PAN number.
                                            </div>
                                        </div>
                                        <div class="col-6 mx-auto mt-3">
                                            <label for="product_imageedit" class="form-label">Product Image:</label>
                                            <input type="text" id="product_imageedit" name="product_imageedit"
                                                class="form-control" accept="image/*" required>
                                            <div class="invalid-feedback">Please provide a product image.</div>
                                        </div>




                                        <div class="col-6 mx-auto my-4 text-center  ">
                                            <button class="btn btn-warning px-4 py-2 " type="submit">update</button>
                                        </div>



                                </div>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>


                <!-- user data be update (End) -->

                <!-- ---------------------------------------------------------------------------------------- -->

                <!-- user data be so on screen (start) -->
                <div class="table-responsive  mx-auto col-11">
                    <table id="Table" class="table table-striped ">
                        <thead>
                            <tr>
                                <th scope="col">sno</th>
                                <th scope="col">seller_name</th>
                                <th scope="col">product_name</th>
                                <th scope="col">product_price</th>
                                <th scope="col">product_detail</th>
                                <th scope="col">Product_type</th>
                                <th scope="col">product_size</th>
                                <th scope="col">product_color</th>
                                <th scope="col">product_image</th>

                                <th scope="col">Actions</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $sql = "SELECT * FROM `product`";
                                    $result = mysqli_query($conn, $sql);
                                    $sno = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $sno = $sno + 1;
                                        echo "
                                            <tr>
                                                    <th scope='row'>" . $sno . "</th>
                                                    <td>" . $row['seller_name'] . "</td>
                                                    <td>" . $row['product_name'] . "</td>
                                                    <td>" . $row['product_price'] . "</td>
                                                    <td>" . $row['product_detail'] . "</td>
                                                    <td>" . $row['product_type'] . "</td>
                                                    <td>" . $row['product_size'] . "</td>
                                                    <td>" . $row['product_color'] . "</td>
                                                    <td>" . $row['product_image'] . "</td>
                                                    <td>
                                                    <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> 
                                                    </td>
                                                    <td>
                                                    <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button>  
                                                    </td>

                                            </tr>
                                        ";
                                    }
                                    
                                ?>
                        </tbody>
                    </table>
                </div>


                <!-- user data be so on screen (end) -->

                <!-- ---------------------------------------------------------------------------------------- -->

            </div>
        </div>

        <!-- end -->
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#Table').DataTable();
    });
    </script>

    <script>
    //----------------------------------- update ---------------------------------------
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            tr = e.target.parentNode.parentNode;

            // Adjust the index based on the column order
            seller_name = tr.getElementsByTagName("td")[0].innerText;
            product_name = tr.getElementsByTagName("td")[1].innerText;
            product_price = tr.getElementsByTagName("td")[2].innerText;
            product_detail = tr.getElementsByTagName("td")[3].innerText;
            product_type = tr.getElementsByTagName("td")[4].innerText;
            product_size = tr.getElementsByTagName("td")[5].innerText;

            // Assigning correct value to product_coloredit
            product_color = tr.getElementsByTagName("td")[6].innerText;
            product_image = tr.getElementsByTagName("td")[7].innerText;

            console.log(seller_name, product_size, product_detail);

            // Assign values to form fields
            seller_nameedit.value = seller_name;
            product_nameedit.value = product_name;
            product_priceedit.value = product_price;
            product_detailedit.value = product_detail;
            product_typeedit.value = product_type;
            product_sizeedit.value = product_size;
            product_coloredit.value = product_color; // Corrected variable name
            product_imageedit.value = product_image;

            snoEdit.value = e.target.id;

            console.log(e.target.id);
            $('#editModal').modal('toggle');
        })
    })



    //-----------------------------------delete  ---------------------------------------
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("delete ");
            sno = e.target.id.substr(1, );


            if (confirm("press a Button")) {
                console.log("yes");
                window.location = `admin_seller_product.php?delete=${sno}`; // chage the path
                // TODP : create a form  and use post request to submit a form
            } else {
                console.log("No");
            }

        })
    })
    </script>

    <script>
    // Disable right-click
    window.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    }, false);
    </script>



</body>

</html>