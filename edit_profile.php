<?php
session_start();
include 'config.php';

if (strlen($_SESSION['USER_LOGIN']) == 0) {
    header('location:index.php');
    exit();
} else {
    $user_id = $_SESSION['USER_ID'];
    $sql = "SELECT * FROM customer WHERE id='$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No user found.";
        exit();
    }

    $nameErr = $emailErr = $mobileErr = $addressErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $isValid = true;
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);
        $address = trim($_POST['address']);

 
        if (empty($full_name)) {
            $nameErr = "Full name is required.";
            $isValid = false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format.";
            $isValid = false;
        }
        if (empty($mobile) || !preg_match('/^[0-9]{10}$/', $mobile)) {
            $mobileErr = "Valid 10-digit mobile number is required.";
            $isValid = false;
        }
        if (empty($address)) {
            $addressErr = "Address is required.";
            $isValid = false;
        }

        if ($isValid) {
            $update_sql = "UPDATE customer SET full_name='$full_name', email='$email', contact='$mobile', address='$address' WHERE id='$user_id'";
            if ($conn->query($update_sql) === TRUE) {
                echo "Profile updated successfully.";
                $_SESSION['USER_NAME'] = $full_name;
                $_SESSION['USER_EMAIL'] = $email;
                $_SESSION['USER_MOBILE'] = $mobile;
                $_SESSION['USER_ADDRESS'] = $address;
            } else {
                echo "Error updating profile: " . $conn->error;
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Profile</title>
        <link rel="stylesheet" href="css/edit_profile.css">
        
        <script>
            function validateForm() {
                let isValid = true;
                let name = document.forms["profileForm"]["full_name"].value;
                let email = document.forms["profileForm"]["email"].value;
                let mobile = document.forms["profileForm"]["mobile"].value;
                let address = document.forms["profileForm"]["address"].value;
                let nameErr = emailErr = mobileErr = addressErr = "";

                if (name == "") {
                    nameErr = "Full name is required.";
                    isValid = false;
                }
                let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(email)) {
                    emailErr = "Invalid email format.";
                    isValid = false;
                }
                let mobilePattern = /^[0-9]{10}$/;
                if (!mobilePattern.test(mobile)) {
                    mobileErr = "Valid 10-digit mobile number is required.";
                    isValid = false;
                }
                if (address == "") {
                    addressErr = "Address is required.";
                    isValid = false;
                }

                document.getElementById("nameErr").innerText = nameErr;
                document.getElementById("emailErr").innerText = emailErr;
                document.getElementById("mobileErr").innerText = mobileErr;
                document.getElementById("addressErr").innerText = addressErr;

                return isValid;
            }
        </script>
    </head>

    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="profile">
                <h1>Edit Profile</h1>
                <div class="profile_form">
                    <form name="profileForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        onsubmit="return validateForm()">
                        <div>
                            <label>Full Name:</label>
                            <input type="text" name="full_name" value="<?php echo htmlspecialchars($row['full_name']); ?>"
                                required>
                            <span id="nameErr" class="error"><?php echo $nameErr; ?></span>
                        </div>
                        <div>
                            <label>Email:    </label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required
                                readonly>
                            <span id="emailErr" class="error"><?php echo $emailErr; ?></span>
                        </div>
                        <div>
                            <label>Mobile:</label>
                            <input type="text" name="mobile" value="<?php echo htmlspecialchars($row['contact']); ?>"
                                required>
                            <span id="mobileErr" class="error"><?php echo $mobileErr; ?></span>
                        </div>
                        <div>
                            <label>Address:</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($row['address']); ?>"
                                required>
                            <span id="addressErr" class="error"><?php echo $addressErr; ?></span>
                        </div>
                        <br>
                        <div>
                            <button type="submit" name="submit">Update</button>
                        </div>
                        <br>
                        
                        <div>
                            <button><a href="change_password.php">Change Password </a></button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </body>

    </html>
    <?php
}
?>

