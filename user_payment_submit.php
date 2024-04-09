<!-- <script async
  src="https://js.stripe.com/v3/buy-button.js">
</script>

<stripe-buy-button
  buy-button-id="buy_btn_1Orh8dBoD2gwUI9qn4GzCn2X"
  publishable-key="pk_test_51Orax2BoD2gwUI9qHK9be5gtjcmsaDwNhr9g28kdFWCN1XiWW3hZgZZDQaMBsuzE7cp3gCsXlWDSoaPYoKtA7xEc007RT13Kvp"
>
</stripe-buy-button> -->

<?php
session_start(); // Start or resume a session

// Retrieve user email from session
if(isset($_SESSION['email'])) {
    $Email = $_SESSION['email'];
} else {
    // Redirect or handle error if user email is not found in session
    // header("Location: user_login_profile.php");
    // exit;
}

// Retrieve total price from session
if(isset($_SESSION['total_price'])) {
    $totalPrice = $_SESSION['total_price'];
    $totalPrice *= 100; // Convert to cents for Stripe
    // Now you can use $totalPrice as needed
    echo "Total Price: $" . $totalPrice;
} else {
    // Total price not found in session, handle this case accordingly
    echo "Total price not found in session.";
}
?>

<?php
require('user_payment_config.php');
?>

<form action="submit.php" method="post">
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?php echo $publishableKey ?>"
        data-amount="<?php echo $totalPrice ?>"
        data-name="Pp Cloth"
        data-description="Cloth selling"
        data-image=""
        data-currency="inr"
        data-email="<?php echo $Email ?>"
    >
    </script>
</form>

