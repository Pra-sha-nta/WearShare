<?php
session_start();
include "config.php";
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
            $sql = "INSERT INTO admin (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Admin added successfully');</script>";
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
        <title>Add Admin</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/add_admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <?php include "header.php"; ?>
        <div class="container">
            <div>
                <h3>Add Admin</h3>
            </div>
            <div>
                <form method="post" onsubmit="return validateForm()">
                    <div>
                        <label>Full Name</label><br>
                        <input type="text" name="full_name" required placeholder="Enter Your Full Name">
                    </div>
                    <div>
                        <label>Email</label><br>
                        <input type="email" name="email" required placeholder="Enter Your Email">
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
                        <button type="submit" name="submit">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include "footer.php"; ?>
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
    </body>

    </html>
    <?php
}
?>