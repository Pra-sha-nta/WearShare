<?php
session_start();
include 'config.php';

if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN'] != 'yes') {
    header('location:index.php');
    exit();
} else {
    $customer_id = $_SESSION['USER_ID']; 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_name = $_POST['product_name'];
        $req_price = $_POST['req_price'];
        $description = $_POST['description'];
        $contact = $_POST['contact'];
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name']; 
        $image_folder = "admin/images/" . basename($image);

        if (move_uploaded_file($image_tmp, $image_folder)) {
            
            
            $sql = "INSERT INTO purchase (customer_id, req_price, description, image, product_name, contact) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissss", $customer_id, $req_price, $description, $image_folder, $product_name, $contact);
            
            if ($stmt->execute()) {
                echo "<script>alert('Product listed successfully!'); window.location.href='sell.php';</script>";
            } else {
                echo "<script>alert('Error: Unable to list product.');</script>";
            }
            
            $stmt->close();
            closeConnection($conn);
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Clothes - WearShare</title>
    <link rel="stylesheet" href="css/sell_style.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php';?>
    <h2>Sell Your Unused Clothes</h2>
   <form name="SellForm" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label>Product Name:</label>
        <input type="text" name="product_name" required><br>
        
        <label>Requested Price:</label>
        <input type="number" name="req_price" required><br>
        
        <label>Description:</label>
        <textarea name="description" required></textarea><br>

        <label> Contact No: </label>
        <input type="text" name="contact" required><br>
        
        <label>Upload Image:</label>
        <input type="file" name="image" accept="image/*" required><br>
        
        <button type="submit">Sell Now</button>
    </form>
<?php include 'footer.php';?>
<script>

    function validateForm() {
        var req_price = document.forms["SellForm"]["req_price"].value;
        
        var contact = document.forms["SellForm"]["contact"].value.trim();
        if (req_price < 0) {
            alert("Requested price cannot be negative.");
            return false;
        }
        let contactPattern = /^(98|97|96)\d{8}$/;
        if (!contactPattern.test(contact)) {
            alert("Contact must be 10 digits and start with 98, 97, or 96 and cannot contain letters");
            return false;
        }
        return true;
    }
</script>
</body>

</html>

