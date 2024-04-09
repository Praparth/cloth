<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP Cloth</title>
    <link rel="shortcut icon" type="x-icon" href="/image/icon1.jpg">
</head>

<body>



    <div class=" first-brand col-12 d-flex justify-content-around flex-wrap w-100 my-5">
        <span class="col-sm-4 d-flex justify-content-center" id = "">
            <img src="https://www.next.us/nxtcms/resource/image/5887552/portrait_ratio4x5/560/700/d49ffeaa5f6baa95ccdb3b737075fe94/F2BB08C5A41DA4593698ACA67524DC5F/girls-winter-dresses-us.jpg"
                alt="" width="90%" height="100%" class="imageClick">
        </span>
        <span class="col-sm-4 d-flex justify-content-center my-4 my-sm-0 ">
            <img src="https://www.next.us/nxtcms/resource/image/5887540/portrait_ratio4x5/560/700/141ab670483240ddf0be31deb5dfb9ea/AA1766EABBA1A42C2B5704D9D22850E9/boys-smarter-styles.jpg"
                alt="" width="90%" height="100%" class="imageClick">
        </span>
        <span class="col-sm-4 d-flex justify-content-center ">
            <img src="https://www.next.us/nxtcms/resource/image/5887594/portrait_ratio4x5/560/700/619ac1d49b0126937499a76b6100c67/B8FEEB2964320A95178B72A2B886BDC0/womens-winter-dresses.jpg"
                alt="" width="90%" height="100%" class="imageClick">
        </span>
    </div>


    <div class="shop col-12 d-flex flex-sm-row flex-column text-dark">
        <span class="d-flex flex-column justify-content-around p pb-3">
            <span class="fs-3 d-flex justify-content-center">Dress the part</span>
            <span class="p-5">Celebrate the next occasion with our extra special styles that are sure to impress.</span>
            <button class="w-50 rounded-pill align-self-center btn btn-light">Shop now</button>
        </span>
        <span>
            <img id="image1"
                src="https://www.next.us/nxtcms/resource/image/5901216/landscape_ratio7x3/960/411/f611f9a58e60f53936fdef69985a8e21/912A12E80E91041676DCAACC922847E3/winter-occasionwear-image.jpg"
                alt="" class="w-100 h-100 align-content-end">
        </span>
    </div>

    <div class="col-12 second-brand d-flex w-100 justify-content-around pt-5 flex-column flex-sm-row">
        <span id="image2" class="col-sm-3 second-brand-1 d-flex justify-content-center flex-column">
            <img src="https://www.next.us/nxtcms/resource/image/5817910/portrait_ratio4x5/560/700/74538ea21b5f5eec6253cddf716c4805/B24D6D5DA86E93B212EE406400AFCA60/lipsy-us.jpg"
                alt="" class="w-100 imageClick">
            <span class="mx-auto">
                <span>Explore Lipsy</span>
                <span><a href="" class="nav-link text-decoration-underline">Shop Now</a></span>
            </span>
        </span>
        <span id="image3" class="col-sm-3 second-brand-2 d-flex justify-content-center flex-column">
            <img src="https://www.next.us/nxtcms/resource/image/5887570/portrait_ratio4x5/560/700/1a3423885c3339fa72806f932413ab74/1D39F338E907804174C7F301C1B23861/mens-knitwear-row.jpg"
                alt="" class="w-100 imageClick">
            <span class="mx-auto">
                <span>Mens's knitwear picks</span>
                <span><a href="" class="nav-link text-decoration-underline">Shop Now</a></span>
            </span>
        </span>
        <span id="image4" class="col-sm-3 second-brand-3 d-flex justify-content-center flex-column">
            <img src="https://www.next.us/nxtcms/resource/image/5875070/portrait_ratio4x5/560/700/f64a31ff85b3d9efa856b06ae02029e/E750FFA1AFB098A20B0708C33B652B65/love-roses-2.jpg"
                alt="" class="w-100 imageClick">
            <span class="mx-auto">
                <span>Elevate the everyday with Love & Ross</span>
                <span><a href="" class="nav-link text-decoration-underline imageClick">Shop Now</a></span>
            </span>
        </span>
    </div>

    <div class="payment my-5">
        <img src="https://www.next.us/nxtcms/resource/blob/5782198/ccc2dc2ff957e8142665e37412980284/dt-usa-payment-banner-klarna-added-data.jpg"
            alt="" class="w-100">
    </div>









    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <!-- <script>
    document.querySelectorAll(".imageClick").forEach(function(element) {
        element.addEventListener("click", function() {
            // Get the ID of the clicked image
            var imageId = element.parentNode.id;

            // Construct the URL with the image ID as a query parameter
            var url = "user_product.php?imageId=" + encodeURIComponent(imageId);

            // Redirect to another page with the image ID in the URL
            window.location.href = url;
        });
    });
    </script> -->
</body>

</html>