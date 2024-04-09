<?php
    // Start the session
    session_start();
    include ("register_connection.php");

    // Check if the user is logged in
    $logged_in = isset($_SESSION['login_user']);
    $username = $logged_in ? $_SESSION['login_user'] : 'Guest';

    
// Get the count of products in the user's shopping cart
$query = "SELECT COUNT(*) AS total_products FROM user_add_to_card WHERE user_name = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_products = $row['total_products'];
    

// Get the count of wishlist in the user's shopping cart
$query = "SELECT COUNT(*) AS total_wishlist FROM wishlist  WHERE user_name = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_wishlist = $row['total_wishlist'];
 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    /* Custom CSS for the shopping bag link */
    .shopping-bag-link {
        text-decoration: none;
        color: #000;
        /* Set link color */
    }

    .shopping-bag-icon {
        font-size: 1.5rem;
        /* Adjust icon size */
    }

    .shopping-bag-badge {
        background-color: #f90;
        /* Set badge background color */
        color: #fff;
        /* Set badge text color */
        border-radius: 50%;
        /* Make badge circular */
        padding: 0.3rem 0.6rem;
        /* Adjust badge padding */
        font-size: 0.8rem;
        /* Adjust badge font size */
    }
    </style>
</head>

<body>
    <div class="mt-2 container-fluid d-flex flex-column flex-sm-row bg-transparent">
        <span class="col-sm-1 col-12 d-flex justify-content-around ">
            <span class="fs-2    ">
                <span class="d-flex d-flex justify-content-around"> <a href="second_index.php" class="nav-link"> <span
                            class="fw-bolder text-success ">P</span><span class="fw-bold text-warning ">p</span></a>
                </span>
            </span>
            <img id="hide" src="./image/stack.png" alt="" width="25rem" height="25rem"
                class="d-sm-none align-self-center">
        </span>
        <span id="product-item" class="col-sm-5 d-none d-sm-flex justify-content-around align-self-sm-center">
            <a href="menhome.php" class="nav-link">MEN</a>
            <a href="womenhome.php" class="nav-link">WOMEN</a>
            <div class="dropdown">
                <button class="border-0 bg-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    KIDS
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="boyshome.php">BOYS'</a></li>
                    <li><a class="dropdown-item" href="girlshome.php">GIRLS</a></li>
                </ul>
            </div>
            <a href="topbrandhome.php" class="nav-link">TOP BRAND</a>
        </span>
        <span id="search-item" class="search d-none d-sm-block col-sm-3  mx-sm-0 mx-3 align-self-center  "
            style=" height: fit-content; ">
            <form id="searchForm" class="d-flex ms-auto border  rounded-pill " method="GET"
                action="user_search_results.php">
                <input id="searchInput" class="form-control btn btn-outline-none " name="search_query" type="search"
                    placeholder="Search" aria-label="Search" name="query">
            </form>

        </span>
        <span id="profile-item" class="col-sm-3 d-none d-sm-flex flex-row justify-content-around align-self-center">
            <span class="d-flex flex-column text-center ">
                <i class="bi bi-person"></i>
                <a href="user_profile.php" class="nav-link"><?php echo $username; ?></a>
            </span>
            <span class="text-center px-2">
                
                <a href="user_Wishlist.php" class="shopping-bag-link">
                    <i class="bi bi-heart shopping-bag-icon"></i> wishlist
                    <?php if($total_wishlist > 0): ?>
                    <span class="shopping-bag-badge"><?php echo $total_wishlist; ?></span>
                    <?php endif; ?>
                </a>
            </span>
            <span class="text-center">  
                <a href="user_add_to_card.php" class="shopping-bag-link">
                    <i class="bi bi-bag shopping-bag-icon"></i> Bag
                    <?php if($total_products > 0): ?>
                    <span class="shopping-bag-badge"><?php echo $total_products; ?></span>
                    <?php endif; ?>
                </a>

            </span>
        </span>
    </div>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        let current = "show";
        let product = document.querySelector("#product-item");
        let search = document.querySelector("#search-item");
        let profile = document.querySelector("#profile-item");
        let hide = document.getElementById("hide");

        hide.addEventListener("click", () => {
            if (current === "show") {
                console.log("show");
                current = "hide";
                product.classList.add("d-flex");
                product.classList.remove("d-none");

                search.classList.add("d-block");
                search.classList.remove("d-none");

                profile.classList.add("d-flex");
                profile.classList.remove("d-none");
            } else {
                console.log("hide");
                current = "show";
                product.classList.add("d-none");
                product.classList.remove("d-flex");

                search.classList.add("d-none");
                search.classList.remove("d-block");

                profile.classList.add("d-none");
                profile.classList.remove("d-flex");
            }
        });
    });
    </script>

    <!-- search  -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get reference to the search form and input
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');

        // Add event listener to the search input
        searchInput.addEventListener('keypress', function(event) {
            // Check if Enter key is pressed (key code 13)
            if (event.keyCode === 13) {
                // Prevent default form submission
                event.preventDefault();

                // Submit the form
                searchForm.submit();
            }
        });
    });
    </script>





</body>

</html>