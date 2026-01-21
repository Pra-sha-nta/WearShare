<?php
session_start();
include "config.php";
if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Admin Dashboard</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/dashboard.css">


    </head>

    <body>

        <?php include "header.php"; ?>

        <main>
            <div class="dash_head">
                <h2>ADMIN DASHBOARD</h2>
            </div>
            <div class="dashboard">
                <div class="cloths_listed">
                    <a href="manage_product.php">
                        <div>
                            <?php
                            $sql_p = "SELECT * from product";
                            $result_p = $conn->query($sql_p);
                            $listedcloths = $result_p->num_rows;
                            ?>
                            <img src="images/producticon.png"height="300px" width="200px" alt="cloths">
                            <h3><?php echo htmlentities($listedcloths) ?></h3>
                            <p>Clothes Listed</p>
                        </div>
                    </a>
                </div>
                <div class="category_lised">
                    <a href="manage_category.php">
                        <div>
                            <?php
                            $sql_c = "SELECT * from category";
                            $result_c = $conn->query($sql_c);
                            $listedcategories = $result_c->num_rows;
                            ?>
                            <img src="images/categoryicon1.png" alt="Categories">
                            <h3><?php echo htmlentities($listedcategories) ?></h3>
                            <p>Categories Listed</p>
                        </div>
                    </a>
                </div>
                <div class="order_listed">
                    <a href="order.php">
                        <div>
                            <?php
                            $sql_o = "SELECT * from order_details";
                            $result_o = $conn->query($sql_o);
                            $listedorders = $result_o->num_rows;
                            ?>
                            <img src="images/ordericon.png" alt="Orders">
                            <h3><?php echo htmlentities($listedorders) ?></h3>
                            <p>Orders Listed</p>
                        </div>
                    </a>
                </div>
                <div class="cloths_notreturned">
                    <a href="order.php">
                        <div class="return">
                            <?php
                            $sql_or = "SELECT * from order_details where (return_status=0|| return_status is null)";
                            $result_o = $conn->query($sql_or);
                            $listedorders = $result_o->num_rows;
                            ?>
                            <img src="images/returnicon.png" alt="Return">
                            <h3><?php echo htmlentities($listedorders) ?></h3>
                            <p>Clothes Not Returned Yet</p>
                        </div>
                    </a>
                </div>
                <div class="customer_listed">
                    <a href="customer.php">
                        <div>
                            <?php
                            $sql_cust = "SELECT * from customer";
                            $result_cust = $conn->query($sql_cust);
                            $listedcustomers = $result_cust->num_rows;
                            ?>
                            <img src="images/customericon.png" alt="Customers">
                            <h3><?php echo htmlentities($listedcustomers) ?></h3>
                            <p>Customers Listed</p>
                        </div>
                </div>
                <div class="purchase_req_listed">
                    <a href="purchase.php">
                        <div>
                            <?php
                            $sql_cust = "SELECT * from purchase";
                            $result_cust = $conn->query($sql_cust);
                            $listedpurchase = $result_cust->num_rows;
                            ?>
                            <img src="images/purchaseicon.png" alt="Purchase">
                            <h3><?php echo htmlentities($listedpurchase) ?></h3>
                            <p>Purchase Requests Listed</p>
                        </div>
                </div>
            </div>
        </main>

        <?php include "footer.php"; ?>

    </body>

    </html>
<?php } ?>