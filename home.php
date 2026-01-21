<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WearShare - Cloth Store Website</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header_style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include 'header.php'?>
       
    <section>
        <div class="main">
            <div class="main_tag">
                <h1>WELCOME TO<br><span>WearShare</span></h1>
                <p>
                    Welcome to WearShare, your one-stop platform for renting a variety of clothing items, including wedding,
                    party, cultural, religious, and engagement wear, at affordable prices. We also offer an option to sell
                    your unwanted clothes through our system. Enjoy fast delivery, 24/7 service, great deals, and secure
                    payment options with WearShare!
                </p>
                <a href="aboutus.php" class="main_btn">Learn More</a>
            </div>

            <div class="main_img">
                <img src="cultural.jpg" alt="Cultural Wear">
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <div class="about">
        <div class="about_image">
            <img src="wedding.jpg" alt="Wedding Wear">
        </div>
        <div class="about_tag">
            <h1>About Us</h1>
            <p>
                By facilitating the renting and resale of clothing, WearShare promotes affordability and sustainability within
                the community.
            </p>
            <p>
                Our mission is to empower individuals with access to diverse clothing options for various occasions. We strive
                to provide a platform that fosters affordability, style sharing, and a sense of connection.
            </p>
            <a href="aboutus.php" class="about_btn">Learn More</a>
        </div>
    </div>


    <div class="featured_cloths">
        <h1>Avaliable Clothes</h1>
        <div class="featured_cloths_box">
            <?php
                $sql = "SELECT * FROM product WHERE stock > 0  LIMIT 15";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="featured_cloths_card">';
                        echo '<div class="featured_cloths_img">';
                        echo '<img src="admin/images/' . $row['image'] . '" alt="' . $row['name'] . '">';
                        echo '</div>';
                        echo '<div class="featured_cloths_tag">';
                        echo '<h2>' . $row['name'] . '</h2>';
                        echo '<p class="cloths_price">NRs.' . $row['rent_price'] . '</p>';
                        echo '<a href="product_view.php?id=' . $row['id'] . '" class="f_btn">Learn More</a>';

                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No active products available.</p>';
                }
            ?>
        </div>
    </div>

    <div class="arrivals">
        <h1>New Arrivals</h1>
        <div class="arrivals_box">
            <?php
                $sqli = "SELECT * FROM product WHERE stock > 0 ORDER BY id DESC LIMIT 10";
                $resulti = $conn->query($sqli);
                if ($resulti->num_rows > 0) {
                    while ($rowi = $resulti->fetch_assoc()) {
                        echo '<div class="arrivals_card">';
                        echo '<div class="arrivals_image">';
                        echo '<img src="admin/images/' . $rowi['image'] . '" alt="' . $rowi['name'] . '">';
                        echo '</div>';
                        echo '<div class="arrivals_tag">';
                        echo '<p>' . $rowi['name'] . '</p>';
                        echo '<a href="product_view.php?id=' . $rowi['id'] . '" class="arrivals_btn">Learn More</a>';

                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No new arrivals available.</p>';
                }
            ?>
        </div>
    </div>

    
</body>
<?php include 'footer.php';?>

</html>
