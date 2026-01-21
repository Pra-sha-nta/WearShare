<?php
include 'config.php';


$sql = "SELECT * FROM category";
$category_result = mysqli_query($conn, $sql);
$categories = [];
if ($category_result) {
    while ($row = mysqli_fetch_assoc($category_result)) {
        $categories[] = $row;
    }
}

$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : null;
$selected_subcategory = isset($_POST['subcategory']) ? $_POST['subcategory'] : null;
$subcategories = [];

if ($cat_id) {
    $sql = "SELECT DISTINCT subcategory FROM product WHERE cat_id = $cat_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $subcategories[] = $row['subcategory'];
        }
    }
}

if ($cat_id && $selected_subcategory) {
    $sql = "SELECT * FROM product WHERE cat_id = $cat_id AND subcategory = '$selected_subcategory'";
    $product_result = mysqli_query($conn, $sql);
} else {
    $product_result = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="css/product_style.css">
<link rel="stylesheet" href="css/category_style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="product">
            <h1>Choose Category and Subcategory</h1>
            <div>
            <form method="GET">
                <select name="cat_id" onchange="this.form.submit()">
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>" <?= ($category['id'] == $cat_id) ? 'selected' : '' ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if ($cat_id): ?>

                <form method="POST">
                    <select name="subcategory" onchange="this.form.submit()">
                        <option value="">Select Gender </option>
                        <?php foreach ($subcategories as $subcategory) : ?>
                            <option value="<?= $subcategory ?>" <?= ($subcategory == $selected_subcategory) ? 'selected' : '' ?>>
                                <?= $subcategory ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            <?php endif; ?>
            </div>

          

            <?php
            if ($selected_subcategory) {
                if ($product_result && mysqli_num_rows($product_result) > 0) {
                    echo "<h2>Products in '$selected_subcategory' Subcategory</h2>";
                    echo "<div class='product_box'>";
                    while ($row = mysqli_fetch_assoc($product_result)) {
                        
                        
                        echo '<div class="product_card">';
                        echo '<div class="product_image">';
                        echo '<img src="admin/images/' . $row['image'] . '">';
                        echo '</div>';
                        echo '<div class="product_tag">';
                        echo '<h4>' . $row['name'] . '</h4>';
                        echo '<p class="product_price">NRs.' . $row['rent_price'] . '</p>';
                        if ($row['stock'] > 0) {
                            echo '<p class="product_stock">Stock:'.$row['stock']. '</p>';
                            echo '<a href="cart.php?id=' . $row['id'] . '" class="product_btn">Add to cart</a>';
                        } else {
                            echo '<p class="product_stock">Out of Stock</p>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                    echo "</div>";
                } else {
                    echo '<p>No products found in this subcategory.</p>';
                }
            } else {
                echo '<p>Please select a subcategory to view products.</p>';
            }
            ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
<script src="cart.js"></script>
</html>
