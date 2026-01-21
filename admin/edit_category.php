<?php
session_start();
include "config.php";
if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {
    if (isset($_POST['update'])) {
        $category = $_POST['category'];
        $id = intval($_GET['id']);
        $sql = "UPDATE category set name='$category' where id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Category updated successfully')</script>";
            header("location: manage_category.php");
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
        <title>Document</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/addcss.css">
    </head>

    <body>
        <?php include "header.php"; ?>
        <div>
            <h3>
                Update CATEGORY
            </h3>
        </div>
        <div class="container">
            <div>
                <form method="post">
                    <?php
                    $id = intval($_GET['id']);
                    $sql = "SELECT * from category where id=$id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div>
                                <label>Category Name</label>
                                <input type="text" name="category" value="<?php echo $row['name'] ?>" required>
                            </div>
                            <div>
                                <button type="submit" name="update">Update Category</button>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
        <?php include "footer.php"; ?>
    </body>

    </html>
<?php } ?>