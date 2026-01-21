<?php
session_start();
include "config.php";
if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {


    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $sql = "INSERT INTO category (name) VALUES ('$category')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Category added successfully');</script>";
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
        <title>Add Category</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/addcss.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <?php include "header.php"; ?>
        <div class="container">
            <div>
                <h3>ADD CATEGORY</h3>
            </div>
            <div>
                <form method="post">
                    <div>
                        <label>Category Name</label>
                        <input type="text" name="category" required>
                    </div>
                    
                        <button type="submit" name="submit">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include "footer.php"; ?>
    </body>

    </html>
<?php } ?>