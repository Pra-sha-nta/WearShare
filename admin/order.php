<?php
session_start();
include "config.php";
if (strlen($_SESSION['ADMIN_LOGIN']) == 0) {
    header('location:login.php');
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orders</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/category_manage.css">
    </head>

    <body>
        <?php include "header.php"; ?>
        <div>
            <h3>Orders</h3>
        </div>
        <div>
            <table border="1px">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Total</th>
                        <th>Return Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT o.id as order_id, o.full_name, o.contact, o.address, o.total, 
                                    (SELECT MIN(return_status) FROM order_details od WHERE od.order_id = o.id) as return_status
                            FROM orders o";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['contact']); ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td><?php echo htmlspecialchars($row['total']); ?></td>
                                <td><?php echo $row['return_status'] == 0 ? "Pending" : "Returned"; ?></td>
                                <td>
                                    <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>"><button
                                            class="edit">Details</button></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='8'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php include "footer.php"; ?>
    </body>

    </html>
<?php } ?>