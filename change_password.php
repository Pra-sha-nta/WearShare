<?php
session_start();
include 'config.php';

if (strlen($_SESSION['USER_LOGIN']) == 0) {
    header('location:index.php');
    exit();
} else {
    $user_id = $_SESSION['USER_ID'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);
        $error = "";

        if (empty($new_password) || empty($confirm_password)) {
            $error = "Both fields are required.";
        } elseif ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } elseif (strlen($new_password) < 8) {
            $error = "Password must be at least 8 characters long.";
        }

        if (empty($error)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE customer SET password='$hashed_password' WHERE id='$user_id'";
            if ($conn->query($update_sql) === TRUE) {
                echo "Password changed successfully.";
                header('location:profile.php');
            } else {
                echo "Error updating password: " . $conn->error;
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Change Password</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/dashboard.css">
        <script>
            function validateForm() {
                let newPassword = document.forms["changePasswordForm"]["new_password"].value;
                let confirmPassword = document.forms["changePasswordForm"]["confirm_password"].value;
                let error = "";

                if (newPassword == "" || confirmPassword == "") {
                    error = "Both fields are required.";
                } else if (newPassword !== confirmPassword) {
                    error = "Passwords do not match.";
                } else if (newPassword.length < 8) {
                    error = "Password must be at least 8 characters long.";
                }

                if (error) {
                    document.getElementById("error").innerText = error;
                    return false;
                }
                return true;
            }
        </script>
    </head>

    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="edit">
                <h1>Change Password</h1>
                <form name="changePasswordForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                    onsubmit="return validateForm()">
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" required>
                    </div>
                    <div>
                        <button type="submit" name="submit">Change Password</button>
                    </div>
                    <div id="error" class="error">
                        <?php if (!empty($error))
                            echo htmlspecialchars($error); ?>
                    </div>
                </form>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </body>

    </html>
    <?php
}
?>