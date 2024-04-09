<?php
session_start(); // Start or resume a session

require('config.php');

// Retrieve total price from session
if(isset($_SESSION['total_price'])) {
    $totalPrice = $_SESSION['total_price'];

    echo "Total Price: $" . $totalPrice; // Display total price for debugging purposes

    if(isset($_POST['stripeToken'])){
        \Stripe\Stripe::setVerifySslCerts(false);

        $token = $_POST['stripeToken'];

        // Convert total price to the smallest currency unit expected by Stripe (e.g., cents for USD)
        $stripeAmount = $totalPrice * 100;

        $data = \Stripe\Charge::create(array(
            "amount" => $stripeAmount,
            "currency" => "inr", // Adjust currency according to your needs
            "description" => "Cloth selling",
            "source" => $token,
        ));

        // Check if payment was successful
        if($data->status == 'succeeded') {
            // Redirect to another file
            header("Location: user_profile.php");
            exit; // Stop further execution
        } else {
            // Payment failed, handle the failure scenario here
            echo "Payment failed.";
        }
    }
} else {
    // Total price not found in session, handle this case accordingly
    echo "Total price not found in session.";
}
?>
