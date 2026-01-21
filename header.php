<link rel="stylesheet" href="css/header_style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<header>
    <nav>

        <div class="logo">
            <a href=home.php><img src="logo.png"></a>
            <p class="tagline">From Our Closet To Yours</p>
        </div>

        <div class="navitems">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="product.php">Clothes</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="sell.php">Sell Clothes</a></li>
        </ul>
        </div>

        <div class="social_icon">
            <a href="cart.php"><i class="fa-solid fa-shopping-cart"></i></a>
            <?php
            if (empty($_SESSION['USER_LOGIN'])) {
                echo '<a href="index.php"><i class="fa fa-user" aria-hidden="true"></i></a>';
            }
            else{
                echo '<a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i></a>';
                echo '<a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>';
            }
            ?>
            

        </div>

    </nav>
</header>