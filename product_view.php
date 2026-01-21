<?php
session_start();
include 'config.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM product WHERE id = '$product_id'";
    $result = mysqli_query($conn, $sql);

    if ($product = mysqli_fetch_assoc($result)) {
        $stock = $product['stock'];
        $description = $product['description'];
        $image = $product['image'];
        $name = $product['name'];
        $price = $product['rent_price'];
        $id = $product['id'];
    } else {
        echo "<h2>Product not found.</h2>";
        exit;
    }
} else {
    echo "<h2>Invalid product ID.</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WearShare - Product Details</title>

    <link rel="stylesheet" href="css/product_view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <main class="container">
        <div class="product_image">
            <img src="admin/images/<?php echo htmlspecialchars($image); ?>" alt="Product Image">
        </div>

        <div class="product_details">
            <h2><?php echo htmlspecialchars($name); ?></h2>
            <p class="price">Price: NRs.<?php echo htmlspecialchars($price); ?></p>
            <p class="stock">Stock: <?php echo htmlspecialchars($stock); ?> left</p>
            <p>Description: <?php echo (htmlspecialchars($description)); ?></p>
            <?php echo '<a href="cart.php?id=' . $id . '" class="product_btn">Add to cart</a>';?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
<script src="cart.js"></script>
</html>
