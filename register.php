<?php
session_start();
include 'config.php';

$name = $email = $contact = $address = "";
$errors = [];

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($name)) $errors[] = "Full name is required";
    elseif (!preg_match('/^[A-Za-z\s]+$/', $name)) $errors[] = "Name can only contain letters and spaces.";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";

    if (!preg_match('/^(98|97|96)\d{8}$/', $contact)) $errors[] = "Contact must be 10 digits and start with 98, 97, or 96 and cannot contain letters";

    if (empty($address)) $errors[] = "Address is required";

    if (strlen($password) < 8) $errors[] = "Password length must be at least 8 characters";

    if ($password !== $confirm_password) $errors[] = "Passwords do not match";

    $stmt = $conn->prepare("SELECT id FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) $errors[] = "Email already exists.";


    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO customer (full_name, email, contact, address, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $contact, $address, $hashed_password);
        if ($stmt->execute()) {
            echo "<script>alert('Customer added successfully!'); window.location.href='index.php';</script>";
            exit();
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p style="color:red;">* <?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" onsubmit="return validateForm()">
            <div>
                <label>Full Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div>
                <label>Contact</label>
                <input type="text" name="contact" value="<?= htmlspecialchars($contact) ?>" required>
            </div>
            <div>
                <label>Address</label>
                <input type="text" name="address" value="<?= htmlspecialchars($address) ?>" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            <div>
                <button type="submit" name="submit">Register</button>
            </div>
        </form>
    </div>

<script>
    function validateForm() {
        let contact = document.forms[0]["contact"].value;
        let password = document.forms[0]["password"].value;
        let confirm_password = document.forms[0]["confirm_password"].value;

        let contactPattern = /^(98|97|96)\d{8}$/;
        if (!contactPattern.test(contact)) {
            alert("Contact must be 10 digits and start with 98, 97, or 96 and cannot contain letters");
            return false;
        }

        if (password !== confirm_password) {
            alert("Passwords do not match");
            return false;
        }

        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            return false;
        }

        return true;
    }
</script>
</body>
</html>
