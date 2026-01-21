<?php
session_start();
include "config.php";
if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {
    if (isset($_GET['did'])) {
        $id = $_GET['did'];
        $sql = "DELETE FROM category WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Category deleted successfully');</script>";
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
        <title>Manage Category</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/category_manage.css">
    </head>

    <body>
        <?php include "header.php"; ?>
        <div>
            <h3>MANAGE CATEGORY</h3>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * from category ORDER BY id asc";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td>
                                    <a href="edit_category.php?id=<?php echo $row['id'] ?>"><button class="edit">Edit</button></a>
                                    <a href="manage_category.php?did=<?php echo $row['id'] ?>"
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