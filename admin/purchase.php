<?php
session_start();
include '../config.php';

if (!isset($_SESSION['ADMIN_LOGIN']) || $_SESSION['ADMIN_LOGIN'] != 'yes') {
    header('location:../index.php');
    exit();
}


$sql = "SELECT * FROM purchase";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $purchase_id = $_POST['purchase_id'];
    $status = $_POST['status'];


    $update_sql = "UPDATE purchase SET status = ? WHERE purchase_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $purchase_id);

    if ($stmt->execute()) {
        echo "<script>alert('Status updated successfully!'); window.location.href='purchase.php';</script>";
    } else {
        echo "<script>alert('Failed to update status');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Requests - Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel ="stylesheet" href ="css/purchase_style.css">
    
</head>
<body>
<?php include "header.php"; ?>
<div class="container">
<div>
<h2>Purchase Requests</h2>
</div>
<table border = "1px">
    <thead>
    <tr>
        <th>Purchase ID</th>
        <th>Customer ID</th>
        <th>Product Name</th>
        <th>Requested Price</th>
        <th>Description</th>
        <th>Contact</th>
        <th>Image</th>
        <th>Change Status</th>
        
    </tr>
    </thead>
    <tbody>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['purchase_id']; ?></td>
            <td><?php echo $row['customer_id']; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td>Rs. <?php echo number_format($row['req_price']); ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['contact']; ?></td>
            <td><img src="../<?php echo $row['image']; ?>" alt="Product Image" width="100px" height="100px"></td>
            
            <td>
                <form method="POST">
                    <input type="hidden" name="purchase_id" value="<?php echo $row['purchase_id']; ?>">
                    <select name="status" class="status">
                    <option value="Hold" <?php if (isset($row['status']) && $row['status'] == 'Hold') echo 'selected'; ?>>Hold</option>
                    <option value="Approved" <?php if (isset($row['status']) && $row['status'] == 'Approved') echo 'selected'; ?>>Approved</option>
                    <option value="Rejected" <?php if (isset($row['status']) && $row['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>

                    </select>
                    <button type="submit" name="update_status" class="update">Update</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</div>
<?php include "footer.php"; ?>
</body>
</html>

<?php
$conn->close();
?>
