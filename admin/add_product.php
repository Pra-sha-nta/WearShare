<?php
session_start();
include "config.php";

if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {
    if (isset($_POST['submit'])) {
        $product_name = trim($_POST['product_name']);
        $category = intval($_POST['category']);
        $subcategory = trim($_POST['subcategory']);
        $rent_price = floatval($_POST['rent_price']);
        $quantity = intval($_POST['quantity']);
        $description = trim($_POST['description']);
        $image = $_FILES['image']['name'];
        $target = "images/" . basename($image);
        
        $product_name = mysqli_real_escape_string($conn, $product_name);
        $description = mysqli_real_escape_string($conn, $description);
        $subcategory = mysqli_real_escape_string($conn, $subcategory);

        $errors = [];

        if (empty($product_name)) {
            $errors[] = "Product name is required.";
        }
        if ($category <= 0) {
            $errors[] = "Valid category is required.";
        } else {
            $category_query = "SELECT id FROM category WHERE id = $category";
            $category_result = $conn->query($category_query);
            if ($category_result->num_rows == 0) {
                $errors[] = "Selected category does not exist.";
            }
        }
        if (empty($subcategory)) {
            $errors[] = "Subcategory is required.";
        }
        if ($rent_price <= 0) {
            $errors[] = "Valid rent price is required.";
        }
        if ($quantity <= 0) {
            $errors[] = "Valid quantity is required.";
        }
        if (empty($description)) {
            $errors[] = "Description is required.";
        }
        if (empty($image)) {
            $errors[] = "Image is required.";
        } elseif (!in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
            $errors[] = "Valid image format is required (jpg, jpeg, png, gif).";
        }

        if (empty($errors)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $sql = "INSERT INTO product (name, cat_id, subcategory, rent_price, stock, description, image) 
                    VALUES ('$product_name', $category, '$subcategory', $rent_price, $quantity, '$description', '$image')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Product added successfully');</script>";
                header("Location: manage_product.php");
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
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/addcss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container">
        <h3>ADD PRODUCT</h3>
        <form name="productForm" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <label>Product Name</label>
            <input type="text" name="product_name" required>

            <label>Category</label>
            <select name="category" required>
                <option value="">Select Category</option>
                <?php
                $sql = "SELECT * FROM category";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                }
                ?>
            </select>

            <label for="subcategory">Gender</label>
            <select id="subcategory" name="subcategory" required>
                <option value="">Select Gender</option>
                <option value="gents">GENTS</option>
                <option value="ladies">LADIES</option>
            </select>

            <label>Rent Price</label>
            <input type="text" name="rent_price" required>

            <label>Image</label>
            <input type="file" name="image" required>

            <label>Product Quantity</label>
            <input type="number" name="quantity" required>

            <label>Product Description</label>
            <textarea name="description" required></textarea>


            <button type="submit" name="submit">Add Product</button>
        </form>
    </div>
    <?php include "footer.php"; ?>
</body>
<script>
    function validateForm() {
        let product_name = document.forms["productForm"]["product_name"].value;
        let category = document.forms["productForm"]["category"].value;
        let subcategory = document.forms["productForm"]["subcategory"].value;
        let rent_price = document.forms["productForm"]["rent_price"].value;
        let quantity = document.forms["productForm"]["quantity"].value;
        let description = document.forms["productForm"]["description"].value;
        let image = document.forms["productForm"]["image"].value;
        
        if (
            product_name == "" ||
            category == "" ||
            subcategory == "" ||
            rent_price == "" ||
            quantity == "" ||
            description == "" ||
            image == "" 
        ) {
            alert("All fields must be filled out");
            return false;
        }

        if (isNaN(rent_price)) {
            alert("Rent Price must be a number");
            return false;
        }

        if (isNaN(quantity) || quantity <= 0) {
            alert("Quantity must be a positive number");
            return false;
        }

        if (rent_price < 0) {
            alert("Rent Price cannot be negative");
            return false;
        }
       
        return true;
    }
</script>

</html>
<?php
}
?>
