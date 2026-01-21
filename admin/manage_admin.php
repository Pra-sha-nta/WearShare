<?php
session_start();
include "config.php";
if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {
    if (isset($_GET['did'])) {
        $id = $_GET['did'];
        $sql = "DELETE from admin where id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert(Record deleted successfully);</script>";
            header("location: manage_admin.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage admin</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/category_manage.css">
    </head>

    <body>
        <?php include "header.php"; ?>
        <div>
            <h3>Manage Admin</h3>
        </div>
        <div>
            <table border="1px">
                <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>Admin Name</th>
                        <th>Admin Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * from admin";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['full_name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td>
                                    <a href="edit_admin.php?id=<?php echo $row['id'] ?>"><button class="edit">Update</button></a>
                                    <a href="manage_admin.php?did=<?php echo $row['id'] ?>"
                                        onclick="return confirm('Are you sure you want to delete?')"><button
                                            class="delete">Delete</button></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
            </table>
        </div>
        <?php include "footer.php"; ?>
    </body>

    </html>
<?php } ?>