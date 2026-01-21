<?php
session_start();
include 'config.php';

$error_message = '';
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $email = mysqli_real_escape_string($conn, $email);
    $sql = "SELECT * from customer where email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['USER_LOGIN'] = 'yes';
            $_SESSION['USER_ID'] = $row['id'];
            $_SESSION['USER_NAME'] = $row['name'];
            $_SESSION['USER_EMAIL'] = $row['email'];
            header('location: home.php');
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
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
        
    <div class="container">
        <div class="logo">
            <a href=home.php><img src="logo.png" alt="Browse"></a>
            <p class="tagline">From Our Closet To Yours</p>
        </div>
        <h1>User Login</h1>
        <?php if ($error_message): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <div class="form-container">
            <form action="" method="post">
                <div>
                    <label>Email</label>
                    <input type="text" name="email" required>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <button type="submit" name="submit">Login</button>
                </div>
            </form>
            <div class="extra-buttons">
                <a href="register.php"><button>Register</button></a>
                <a href="admin/login.php"><button>Admin Login</button></a>
            </div>
        </div>
    </div>
</body>

</html>