<?php
session_start();
include 'config.php';

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/product_style.css">
        
    </head>

    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="product">
                <h1>Our Products</h1>
                <div class="product_box">
                    <?php
 
                    $sql = "SELECT * FROM product";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="product_card">';
                            echo '<div class="product_image">';
                            echo '<a href="product_view.php?id=' . $row['id'] . '" class="arrivals_btn"><img src="admin/images/' . $row['image'] . '"></a>';
                            echo '</div>';
                            echo '<div class="product_tag">';
                            echo '<h4>' . $row['name'] . '</h4>';
                            echo '<p class="product_price">NRs.' . $row['rent_price'] . '</p>';
                            if ($row['stock'] > 0) {
                                echo '<p class="product_stock">Stock:'.$row['stock']. '</p>';
                                echo '<a href="cart.php?id=' . $row['id'] . '" class="product_btn">Add to cart</a>';
                            } else {
                                echo '<p class="product_stock">Out of Stock</p>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </main>

        <?php include 'footer.php'; ?>
    </body>
    <script src="cart.js"></script>

    </html>
    <?php

?>
