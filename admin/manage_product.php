<?php
session_start();
include "config.php";

if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {
    if (isset($_GET['did'])) {
        $id = $_GET['did'];
        $sql = "DELETE FROM product WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product deleted successfully');</script>";
            header("location: manage_product.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Product</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/category_manage.css">

    </head>

    <body>
        <?php include "header.php"; ?>
        <div>
            <h3>Manage Product</h3>
        </div>
        <div>
            <table border="1px">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Rent Price</th>
                        <th>Product Quantity</th>
                        <th>Product Category</th>
                        <th>Gender</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th> Action</th>
    
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM product";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['rent_price'] ?></td>
                                <td><?php echo $row['stock'] ?></td>
                                <td>
                                    <?php
                                    $cat_id = $row['cat_id'];
                                    $sql_c = "SELECT name FROM category WHERE id=$cat_id";
                                    $result_c = $conn->query($sql_c);
                                    $row_c = $result_c->fetch_assoc();
                                    echo $row_c['name'];
                                    ?>
                                </td>
                                <td><?php echo $row['subcategory']; ?></td>
                                <td>
                                    <img src="images/<?php echo $row['image'] ?>" width="100px" height="100px">
                                </td>
                                <td><?php echo $row['description'] ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $row['id'] ?>"><button class="edit">Edit</button></a>
                                    <a href="manage_product.php?did=<?php echo $row['id'] ?>"
                                        onclick="return confirm('Are you sure you want to delete?')"><button
                                            class="delete">Delete</button></a>
                                </td>
                               
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php include "footer.php"; ?>
    </body>

    </html>
<?php } ?>
