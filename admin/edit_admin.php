<?php
session_start();
include 'config.php';
if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {
    if (isset($_POST['submit'])) {
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        $errors = [];
        if (empty($full_name))
            $errors[] = "Full name is required";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = "Valid email is required";
        if (empty($password))
            $errors[] = "Password is required";
        if ($password !== $confirm_password)
            $errors[] = "Passwords do not match";

        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $full_name = mysqli_real_escape_string($conn, $full_name);
            $email = mysqli_real_escape_string($conn, $email);

            $sql = "UPDATE admin SET full_name='$full_name', password='$hashed_password' WHERE email='$email'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Admin Updated successfully');</script>";
                header("Location: manage_admin.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            foreach ($errors as $error) {
                echo "<script>alert('$error');</script>";
            }
        }
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Admin</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/add_admin.css">
    </head>

    <body>
        <?php include 'header.php'; ?>
        <div>
            <h3>Edit Admin</h3>
        </div>
        <div class="container">
            <div>
                <form method="post" onsubmit="return validateForm()">
                    <?php
                    $id = intval($_GET['id']);
                    $sql = "SELECT * FROM admin WHERE id=$id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div>
                                <label>Full Name</label><br>
                                <input type="text" name="full_name" value="<?php echo $row['full_name']; ?>" required>
                            </div>
                            <div>
                                <label>Email</label><br>
                                <input type="email" name="email" value="<?php echo $row['email']; ?>" required readonly>
                            </div>
                            <div>
                                <label>Password</label><br>
                                <input type="password" name="password" required>
                            </div>
                            <div>
                                <label>Confirm Password</label><br>
                                <input type="password" name="confirm_password" required>
                            </div>
                            <div>
                                <button type="submit" name="submit">Update Admin</button>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </form>

            </div>
        </div>
        <?php include 'footer.php'; ?>

    </body>
    <script>
        function validateForm() {
            let password = document.forms[0]["password"].value;
            let confirm_password = document.forms[0]["confirm_password"].value;

            if (password !== confirm_password) {
                alert("Passwords do not match");
                return false;
            }
            return true;
        }
    </script>

    </html>
<?php } ?>