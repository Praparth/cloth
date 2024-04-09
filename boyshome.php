<!-- <!DOCTYPE html> -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP Cloth</title>
    <link rel="shortcut icon" type="x-icon" href="/image/icon1.jpg">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .heding {
            font-family: Christian Robertson;
        }
    </style>

</head>

<body>

    <?php require  'navbar.php' ?>
    <!-- start the write the code for MEN HOME PAge -->

    <div class="heding fs-3 fw-light d-flex justify-content-center  my-3 mt-5  "> THE BOYS' SHOP </div>

    <!-- // trending Product Detail -->
    <div class="bg-light  container">
        <div class="fs-5">Trending now </div>
        <div class="col-12 d-flex flex-row row-cols-2  flex-wrap " > 
            <span class="d-flex flex-column align-items-center fw-light fs-6 col-6 col-md-4 col-lg-2 " id="New Arrivals">
                <img src="https://www.next.us/nxtcms/resource/blob/5792214/4843ef4dccf6954cb7b723d82d3ca47f/new-arrivals-taxo-data.jpg"
                alt="" class="rounded-circle w-sm-75 w-50 imageClick">
                <a href="#" class="nav-link d-flex  flex-column imageClick">
                    <span>New Arrivals</span>
                </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-6 col-6 col-md-4 col-lg-2 " id="Character Shop">
                <img src="https://www.next.us/nxtcms/resource/image/5799274/portrait_ratio1x1/179/179/e1fa50cc45b8dcc493b045c80fa3726d/569A4FD4378849B30896DFF9A6BF7506/651-858.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 imageClick">
                     <a href="#" class="nav-link d-flex  flex-column imageClick">
                        <span>Character Shop</span>
                    </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-6 col-6 col-md-4 col-lg-2 " id="Long sleeve tops">
                <img src="https://www.next.us/nxtcms/resource/blob/5792208/30a1e2da70b696c165590278acfcb1bc/long-sleeve-tops-taxo-data.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 imageClick">
                     <a href="#" class="nav-link d-flex  flex-column imageClick">
                        <span>Long sleeve tops</span>
                        <a href="#" class="nav-link d-flex  flex-column ">
                            </a>
                        </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-6 col-6 col-md-4 col-lg-2 " id="Occasion and Party">
                <img src="https://www.next.us/nxtcms/resource/blob/5792218/31b11fa694168cd5647cd8b4eb0d8956/occasion-and-party-taxo-data.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 imageClick">
                     <a href="#" class="nav-link d-flex  flex-column imageClick">
                        <span>Occasion and Party</span>
                    </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-6 col-6 col-md-4 col-lg-2 " id="Cardigans">
                <img src="https://www.next.us/nxtcms/resource/blob/5792206/050a7ce8c7004ef2bb820412924358b7/cardigans-taxo-data.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 imageClick">
                     <a href="#" class="nav-link d-flex  flex-column imageClick">
                        <span>Cardigans</span>
                    </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-6 col-6 col-md-4 col-lg-2 " id="sports kids">
                <img src="https://www.next.us/nxtcms/resource/blob/5792222/6ea7b22fd411ad37cda6d839471cfdfa/sports-taxo-data.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 imageClick">
                     <a href="#" class="nav-link d-flex  flex-column imageClick">
                        <span>sports</span>
                    </a>
            </span>


        </div>
    </div>

    <!-- show the image header -->
    <div class="col-12 d-flex fw-medium fs-3 flex-row row-cols-2 flex-wrap my-5">
        <!-- First image and text -->
        <div class="col-6 col-md-3 position-relative">
            <a href="#">
                <img src="https://www.next.us/nxtcms/resource/blob/5804378/ab19000c7c6ecfc3b3172c743afe2b73/tops-data.jpg"
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
                <img src="https://www.next.us/nxtcms/resource/blob/5804412/6ce0b9e0e28d776460c514272c0e92dd/knitwear-data.jpg"
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
                <img src="https://www.next.us/nxtcms/resource/blob/5804414/7361b875b28bce218e7755b46dba55d5/sets-and-outfits-data.jpg"
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
                <img src="https://www.next.us/nxtcms/resource/image/5807320/portrait_ratio5x7/400/560/f1f5a5ad79464aeac492151bb606fa6d/177B77F2DFF1A3C95927D863EFBEFD26/boys-pjs.jpg"
                    alt="" class="w-100">
            </a>
            <span class="position-absolute top-50 start-50 translate-middle text-white text-uppercase"
                style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                PYJAMAS & Nightwear
            </span>
        </div>
    </div>
    


    <!-- Footware & Accessories -->
    <div class="bg-light  container">
        <div class="fs-5">Trending now </div>
        <div class="col-12 d-flex flex-row row-cols-2  flex-wrap  ">
            <span class="d-flex flex-column align-items-center fw-light fs-5 col-6 col-md-4 col-lg-2 ">
                <img src="https://www.next.us/nxtcms/resource/image/5811388/portrait_ratio1x1/179/179/a015955222f1d32e3781936900de82fc/1DC842823180D4288D1F9B026DA00CEA/u08877.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 ">
                    <a href="#" class="nav-link d-flex  flex-column ">
                        <span>Snekers</span>
                    </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-5 col-6 col-md-4 col-lg-2 ">
                <img src="https://www.next.us/nxtcms/resource/image/5456652/portrait_ratio1x1/179/179/103b418d78c4ad76dc32439306686ca3/361CCA96D0F9939878BC2E2025ACD795/accs.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 ">
                    <a href="#" class="nav-link d-flex  flex-column ">
                        <span>Accessories</span>
                    </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-5 col-6 col-md-4 col-lg-2 ">
                <img src="https://www.next.us/nxtcms/resource/image/5456658/portrait_ratio1x1/179/179/dbdbe7e705f15e9e03ecb3c21fcf4051/28BF715DDDFD823BDEB62F7F39136044/vests.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 ">
                    <a href="#" class="nav-link d-flex  flex-column ">
                        <span>Vests</span>
                    </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-5 col-6 col-md-4 col-lg-2 ">
                <img src="https://www.next.us/nxtcms/resource/image/5456654/portrait_ratio1x1/179/179/25e4ea5ed5e37e737f2bf562b07d6121/B86F4EA9DEEFFB7B9FDC7F062523A267/socks.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 ">
                    <a href="#" class="nav-link d-flex  flex-column ">
                        <span>Socks</span>
                    </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-5 col-6 col-md-4 col-lg-2 ">
                <img src="https://www.next.us/nxtcms/resource/image/5456630/portrait_ratio1x1/179/179/426ace22b221f8026b02ee5c787eadb5/0521AFC0AEB08C8ACE39439DB1C9FE76/sandals.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 ">
                    <a href="#" class="nav-link d-flex  flex-column ">
                        <span>Sandals</span>
                    </a>
            </span>
            <span class="d-flex flex-column align-items-center fw-light fs-5 col-6 col-md-4 col-lg-2 ">
                <img src="https://www.next.us/nxtcms/resource/image/5456656/portrait_ratio1x1/179/179/b669875bdd5957a5d6525eec1f5ddcd8/F7E1C69BF5FC640D043996198C3F028B/underwear.jpg"
                    alt="" class="rounded-circle w-sm-75 w-50 ">
                    <a href="#" class="nav-link d-flex  flex-column ">
                        <span>underwear</span>
                    </a>
            </span>


        </div>
    </div>


    <div class="col-12 d-flex fw-medium fs-3 flex-row row-cols-2 flex-wrap my-5">
        <!-- First image and text -->
        <div class="col-6 col-md-3 position-relative">
            <a href="<YOUR_LINK_HERE>">
                <img src="https://www.next.us/nxtcms/resource/blob/5804442/9bb475d0cab832d030edcb6c7147fda3/sweatshirts-data.jpg"
                    alt="" class="w-100">
            </a>
            <span class="position-absolute top-50 start-50 translate-middle text-white"
                style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                SWEATSHIRTS
            </span>
        </div>
    
        <!-- Second image and text -->
        <div class="col-6 col-md-3 position-relative">
            <a href="<YOUR_LINK_HERE>">
                <img src="https://www.next.us/nxtcms/resource/blob/5804510/fb770e3233aea7f985ad2584bcc408dd/pants-and-chinos-data.jpg"
                    alt="" class="w-100">
            </a>
            <span class="position-absolute top-50 start-50 translate-middle text-white"
                style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                PANTS & CHINOS
            </span>
        </div>
    
        <!-- Third image and text -->
        <div class="col-6 col-md-3 position-relative">
            <a href="<YOUR_LINK_HERE>">
                <img src="https://www.next.us/nxtcms/resource/blob/5804550/c3f1fdb378b4a71427b5522abdfe5d1e/multipacks-new-data.jpg"
                    alt="" class="w-100">
            </a>
            <span class="position-absolute top-50 start-50 translate-middle text-white"
                style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                Multipacks
            </span>
        </div>
    
        <!-- Fourth image and text -->
        <div class="col-6 col-md-3 position-relative">
            <a href="<YOUR_LINK_HERE>">
                <img src="https://www.next.us/nxtcms/resource/blob/5804584/56aa30aed56c83636b3cf11ae5a7538a/jeans-data.jpg"
                    alt="" class="w-100">
            </a>
            <span class="position-absolute top-50 start-50 translate-middle text-white"
                style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                Jeans
            </span>
        </div>
    </div>
    



    <!-- end the write the code for MEN HOME Page-->
    <?php require  'footer.php' ?>


    <script>
        document.querySelectorAll(".imageClick").forEach(function(element) {
            element.addEventListener("click", function() {
                // Get the ID of the clicked image
                var imageId = element.parentNode.id;

                // Construct the URL with the image ID as a query parameter
                //var url = "user_product.php?imageId=" + encodeURIComponent(imageId);
                var url = "user_product.php?imageId=" + encodeURIComponent(imageId);

                // Redirect to another page with the image ID in the URL
                window.location.href = url;
            });
        });
    </script>


    <!-- <script src="index.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

</body>

</html>