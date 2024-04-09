<?php
require('stripe-php-master/init.php');

$publishableKey="pk_test_51Orax2BoD2gwUI9qHK9be5gtjcmsaDwNhr9g28kdFWCN1XiWW3hZgZZDQaMBsuzE7cp3gCsXlWDSoaPYoKtA7xEc007RT13Kvp";

$secretKey="sk_test_51Orax2BoD2gwUI9qucjfWtO6QtVcFuTkujBjx5HQyxleAPU7u7FdTSoCtS4qT6KhYAfAKAUpRJv16CFvM5505NwU00eig6ELad";

\Stripe\Stripe::setApiKey($secretKey);
?>