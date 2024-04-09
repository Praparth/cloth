<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP Cloth</title>
    <link rel="shortcut icon" type="x-icon" href="/image/icon1.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .brand-type a span{
            border: 0px solid #252525;
            background-color: #252525;
            color: aliceblue;
        }
         /* Odd-numbered child elements */
    .brand-type a:nth-child(odd) span:hover {
        background-color: green;
        color: aliceblue;
    }

    /* Even-numbered child elements */
    .brand-type a:nth-child(even) span:hover {
        background-color: yellow;
        color: black;
    }

    .first-a:hover{
        text-decoration: underline;
    }
    </style>

</head>
<body>
    
    <?php require  'navbar.php' ?>
     <!-- start the write the code for  Page -->
        
        <div class="fs-3 fw-medium  d-flex justify-content-center my-3 font-monospace "> THE BRANDS SHOP </div>
        <div class="container fw-bold   d-flex justify-content-center my-3 text-wrap "> Explore the latest styles from all of your favourite brands. </div>
        <div class="brand-type container d-flex flex-wrap justify-content-around   my-5 ">
            <a href="" class="nav-link m-3 "> <span class="border rounded-pill  p-2 px-4"  > A-Z Brands </span></a>
            <a href="" class="nav-link m-3"><span class="border rounded-pill  p-2 px-4">Women's</span></a>
            <a href="" class="nav-link m-3"><span class="border rounded-pill  p-2 px-4">Men's</span></a>
            <a href="" class="nav-link m-3"><span class="border rounded-pill  p-2 px-4">Children's</span></a>
            <a href="" class="nav-link m-3"><span class="border rounded-pill  p-2 px-4">Sports</span></a>
        </div>
        <div class="d-flex justify-content-center fs-4 my-2 ">Shop our best selling brands</div>

        <!------------------------------ first heder brand image ----------------------------------->
        <div class="container col-12 d-flex fw-medium fs-5 flex-row row-cols-2 flex-wrap my-5 row-cols-4  ">
            <!-- First image and text -->
            <div class="col-6 col-md-3 position-relative d-flex flex-column ">
                <a href="#">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860040/f20233fe18f0ddaac380f2053978d459/lipsy-jp-hk-tw-us-kz-data.jpg"
                        alt="" class="w-100">
                </a>
                <a href="" class="nav-link  first-a "> lipsy </a>
            </div>
        
            <!-- Second image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="#">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860032/26c91ae2403b1a1eac6768e0e983c828/baker-us-ua-data.jpg"
                        alt="" class="w-100">
                </a>
                <a href="" class="nav-link  first-a "> baker </a>
            </div>
        
            <!-- Third image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="#">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860046/5a3b189d4070e95935a82e0f051757ce/love-roses-us-data.jpg"
                        alt="" class="w-100">
                </a>
                <a href="" class="nav-link  first-a "> Love & Rose </a>
            </div>
        
            <!-- Fourth image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="#">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860054/5287960ed8318ceadb6a5190bdd5ad8a/reiss-us-data.jpg"
                        alt="" class="w-100">
                </a>
                <a href="" class="nav-link  first-a ">  Relss </a>
            </div>
        </div>    

        <!------------------- Second heder images -------------------------------------->

        <div class="col-12 container d-flex fw-medium fs-3 flex-row row-cols-2 flex-wrap my-5">
            <!-- First image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="#">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860110/e903cbcc8d70e6c691a3e0ff167d6bbb/boys-jp-us-kz-hk-tw-data.jpg"
                        alt="" class="w-100">
                </a>
                <span class="position-absolute top-50 start-50 translate-middle text-white"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                    TOPS & T-SHIRTS
                </span>
            </div>
        
            <!-- Second image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="#">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860114/3076dbf8addf5bc25bbfcd4c46b9652b/girls-jp-us-hk-tw-data.jpg"
                        alt="" class="w-100">
                </a>
                <span class="position-absolute top-50 start-50 translate-middle text-uppercase text-white"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                    knitwear
                </span>
            </div>
        
            <!-- Third image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="#">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860134/a70637c7ac78ebece813602a6b0bae31/women-s-us-kz-data.jpg"
                        alt="" class="w-100">
                </a>
                <span class="position-absolute top-50 start-50 translate-middle text-white"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                    Sets & Outfits
                </span>
            </div>
        
            <!-- Fourth image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="#">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860122/7b958bf69673e9478dbba70460473c82/men-s-jp-us-hk-tw-data.jpg"
                        alt="" class="w-100">
                </a>
                <span class="position-absolute top-50 start-50 translate-middle text-white text-uppercase"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                    PYJAMAS & Nightwear
                </span>
            </div>
        </div>


        <!----------------------- Brand show  ------------------------------->
        
        <div class="d-flex justify-content-center fs-4 fw-medium ">Shop By Brand</div>

        <div class="container-fluid   d-flex flex-wrap  justify-content-around flex-row row-cols-auto ">
            <a href="#" class="nav-link"  >
                <img src="https://www.next.us/nxtcms/resource/blob/5712156/2e13d3c62b60ac5051525ddfa961fb6a/lipsy-london-data.jpg" alt="" class="rounded-circle" width="150vw">
            </a>
            <a href="#" class="nav-link">
                <img src="https://www.next.us/nxtcms/resource/blob/5712162/47626210baa5fbc5b0a1ab8526bb9520/baker-by-tb-data.jpg" alt="" class="rounded-circle" width="150vw">
            </a>
            <a href="#" class="nav-link">
                <img src="https://www.next.us/nxtcms/resource/blob/5688490/6ffdebaa091436429f906b0d02517597/love-roses-data.jpg" alt="" class="rounded-circle" width="150vw">
            </a>
            <a href="#" class="nav-link">
                <img src="https://www.next.us/nxtcms/resource/blob/5712158/e4b617c10e9d14855d93925dcfa0bc74/reiss-data.jpg" alt="" class="rounded-circle" width="150vw">
            </a>
            <a href="#" class="nav-link">
                <img src="https://www.next.us/nxtcms/resource/blob/5712180/8e0eaa8f958187fb04237859e49738c9/boden-data.jpg" alt="" class="rounded-circle" width="150vw">
            </a>
            <a href="#" class="nav-link">
                <img src="https://www.next.us/nxtcms/resource/blob/5712752/16d3f16fa4a53338909421c193d412be/angel-rocket-data.jpg" alt="" class="rounded-circle" width="150vw">
            </a>
            <a href="#" class="nav-link">
                <img src="https://www.next.us/nxtcms/resource/blob/5712754/bdd6afff8937b041de9f1dbbcdd5ef9c/little-bird-data.jpg" alt="" class="rounded-circle" width="150vw">
            </a>
            <a href="#" class="nav-link">
                <img src="https://www.next.us/nxtcms/resource/blob/5712366/1c4f0803de89ef5b744da04b175701ff/adidas-data.jpg" alt="" class="rounded-circle" width="150vw">
            </a>
        </div>

        <!----------------------------- Children Brand  ----------------------------------------->
        <div class="d-flex justify-content-center fs-4 fw-medium mt-5 mb-4">Children's brands we love </div>

        <div class="container col-12 d-flex fw-medium fs-5 flex-row row-cols-2 flex-wrap my-5 row-cols-4  ">
            <!-- First image and text -->
            <div class="col-6 col-md-3 position-relative d-flex flex-column ">
                <a href="" class="nav-link">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860076/ae3277641d09ca4c56c849021d8082c9/baker-by-ted-us-data.jpg" alt="" class="img-fluid" width="275px">
                </a>
            </div>
        
            <!-- Second image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="" class="nav-link">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860090/377cbc0042379207128bcc02699dc33a/lipsy-girl-us-data.jpg" alt="" class="img-fluid" width="275px">
                </a>
            </div>
        
            <!-- Third image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="" class="nav-link">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860072/d3ece80e6d88b53aa0df6033f973435a/angle-rocket-us-data.jpg" alt="" class="img-fluid" width="275px">
                </a>
            </div>
        
            <!-- Fourth image and text -->
            <div class="col-6 col-md-3 position-relative">
                <a href="" class="nav-link">
                    <img src="https://www.next.us/nxtcms/resource/blob/5860092/6537638934f9beec6b9bd20447c6a683/little-bird-us-data.jpg" alt="" class="img-fluid" width="275px">
                </a>
            </div>
        </div>    


       

     <!-- end the write the code for  Page-->
    <?php require  'footer.php' ?>


    <script>
        // Use fetch to load the content from navbar.php
        fetch('bar/navbar.php')
            .then(response => response.text())
            .then(data => {
                // Insert the content into the navbar-container
                document.getElementById('navbar-container').innerHTML = data;
            })
            .catch(error => console.error('Error fetching navbar:', error));

        fetch('bar/footer.php')
            .then(response => response.text())
            .then(data => {
                // Insert the content into the navbar-container
                document.getElementById('footer-container').innerHTML = data;
            })
            .catch(error => console.error('Error fetching navbar:', error));    
    </script>


        <script>
            const togglePassword = document
                .querySelector('#togglePassword');
            const password = document.querySelector('#password');
            togglePassword.addEventListener('click', () => {
                // Toggle the type attribute using
                // getAttribure() method
                const type = password
                    .getAttribute('type') === 'password' ?
                    'text' : 'password';
                password.setAttribute('type', type);
                // Toggle the eye and bi-eye icon
                this.classList.toggle('bi-eye');
            });
        </script>



    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>
</html>