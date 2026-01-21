<?php
session_start();
include 'config.php';

if (!isset($_GET['order_id'])) {
    header('Location: home.php');
    exit();
}

$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="css/thank_you_style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="thank_you">
            <h1>Thank You!</h1>
            <p>Your order has been placed successfully.</p>
            <p>Your Order ID is: <?php echo htmlspecialchars($order_id); ?></p>
            <p>We appreciate your business and hope you enjoy your products.</p>
            <br>
            <button style="background-color:rgb(70, 163, 240);" class="btn" onclick="window.location.href='home.php'">Continue Shopping</button>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>