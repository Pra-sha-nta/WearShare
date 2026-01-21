<?php
session_start();
include 'config.php';

$error_message = '';

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['ADMIN_LOGIN'] = 'yes';
            $_SESSION['ADMIN_ID'] = $row['id'];
            $_SESSION['ADMIN_NAME'] = $row['full_name'];
            header('location: dashboard.php');
            exit();
        } else {
            $error_message = "Invalid login details";
        }
    } else {
        $error_message = "Invalid login details";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <h1>Admin Login</h1>
        <?php if ($error_message): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <div class="form-container">
            <form action="" method="post">
                <div>
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <button type="submit" name="submit">Login</button><br><br>
                    <button type="button" name="submit" onclick="window.location.href='index.php' "  >User Login</button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>