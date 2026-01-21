<?php
session_start();
include "config.php";
if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
} else {
    if (isset($_POST['update'])) {
        $id = intval($_GET['id']);
        $name = trim($_POST['name']);
        $rent_price = floatval($_POST['rent_price']);
        $stock = intval($_POST['stock']);
        $cat_id = intval($_POST['cat_id']);
        $description = trim($_POST['description']);

        $name = mysqli_real_escape_string($conn, $name);
        $description = mysqli_real_escape_string($conn, $description);

        $errors = [];
        if (empty($name)) $errors[] = "Product name is required";
        if ($rent_price <= 0) $errors[] = "Valid rent price is required";
        if ($stock < 0) $errors[] = "Valid stock quantity is required";
        if ($cat_id <= 0) $errors[] = "Valid category is required";
        if (empty($description)) $errors[] = "Description is required";
       
        $image = $_FILES['image']['name'];
       
        if (!empty($image)) {
            $target = "images/" . basename($image);
            $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
            $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($imageFileType, $valid_extensions)) {
                $errors[] = "Valid image format is required (jpg, jpeg, png, gif)";
            } else {
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $errors[] = "Failed to upload image";
                }
            }
        }

        if (empty($errors)) {
            if (!empty($image)) {
                $sql = "UPDATE product SET name='$name', rent_price=$rent_price, stock=$stock, cat_id=$cat_id, description='$description', image='$image'  WHERE id=$id";
            } else {
                $sql = "UPDATE product SET name='$name', rent_price=$rent_price, stock=$stock, cat_id=$cat_id, description='$description' WHERE id=$id";
            }
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Product updated successfully');</script>";
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/addcss.css">
    <style>
        .update-button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .update-button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>
    <div>
        <h3>Update Product</h3>
    </div>
    <div class="container">
        <div>
            <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <?php
                $id = intval($_GET['id']);
                $sql = "SELECT * FROM product WHERE id=$id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                <div>
                    <label>Product Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                </div>
                <div>
                    <label>Rent Price</label>
                    <input type="text" name="rent_price" value="<?php echo htmlspecialchars($row['rent_price']); ?>" required>
                </div>
                <div>
                    <label>Product Quantity</label>
                    <input type="number" name="stock" value="<?php echo htmlspecialchars($row['stock']); ?>" required>
                </div>
                <div>
                    <label>Product Category</label>
                    <select name="cat_id" required>
                        <option value="">Select Category</option>
                        <?php
                        $sql_c = "SELECT * FROM category";
                        $result_c = $conn->query($sql_c);
                        if ($result_c->num_rows > 0) {
                            while ($row_c = $result_c->fetch_assoc()) {
                                echo '<option value="' . $row_c['id'] . '" ' . ($row_c['id'] == $row['cat_id'] ? 'selected' : '') . '>' . htmlspecialchars($row_c['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Current Image</label><br>
                    <img src="images/<?php echo $row['image']; ?>" width="100px" height="100px"><br>
                </div>
                <div>
                    <label>New Image</label><br>
                    <input type="file" name="image"><br>
                </div>
                <div>
                    <label>Product Description</label>
                    <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                </div>
                
                <div>
                    <button type="submit" name="update" class="update-button">Update Product</button>
                </div>
                <?php
                    }
                }
                ?>
            </form>
        </div>
    </div>
    <?php include "footer.php"; ?>
    <script>
        function validateForm() {
            let name = document.forms["productForm"]["name"].value;
            let rent_price = document.forms["productForm"]["rent_price"].value;
            let stock = document.forms["productForm"]["stock"].value;
            let cat_id = document.forms["productForm"]["cat_id"].value;
            let description = document.forms["productForm"]["description"].value;
          

            if (name == "" || rent_price == "" || stock == "" || cat_id == "" || description == "" ) {
                alert("All fields must be filled out");
                return false;
            }

            if (isNaN(rent_price) || rent_price <= 0) {
                alert("Rent Price must be a positive number");
                return false;
            }

            if (isNaN(stock) || stock < 0) {
                alert("Stock must be a non-negative number");
                return false;
            }
           

            return true;
        }
    </script>
</body>

</html>
<?php } ?>
