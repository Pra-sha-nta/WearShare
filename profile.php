<?php
session_start();
include 'config.php';


if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN'] != 'yes') {
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
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/profile_style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="profile-container">
            <h2>User Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['contact']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
            <a href="edit_profile.php" class="edit-profile-btn">Edit Profile</a>
        </div>
        <div class="order-container">
            <h1>Your Orders</h1>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Return Till</th>
                        <th>Return Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT o.id as order_id, od.product_id, p.name, p.rent_price, od.quantity, od.amount as total, od.issued_date, od.return_till, od.return_status
                            FROM orders o
                            JOIN order_details od ON o.id = od.order_id
                            JOIN product p ON od.product_id = p.id
                            WHERE o.customer_id='$user_id' AND od.return_till >= CURDATE()";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($order = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['name']); ?></td>
                                <td><?php echo htmlspecialchars($order['rent_price']); ?></td>
                                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($order['total']); ?></td>
                                <td><?php echo htmlspecialchars($order['issued_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['return_till']); ?></td>
                                <td><?php echo $order['return_status'] == 0 ? "Pending" : "Returned"; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="8">No orders found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>