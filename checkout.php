<?php
session_start();
include 'config.php';

if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN'] != 'yes') {
    header('location:index.php');
    exit();
} else {
    $user_id = $_SESSION['USER_ID'];

    $name = "";
    $contact = "";
    $address = "";
    $total = 0;
    $error = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $contact = trim($_POST['contact']);
        $address = trim($_POST['address']);
        $total = trim($_POST['total']);

        if (empty($name)) {
            $error = "Name is required.";
        } elseif (empty($contact)) {
            $error = "Contact is required.";
        } elseif (!preg_match('/^(98|97|96)\d{8}$/', $contact)) {
            $error = "Invalid contact number. It must start with 98, 97, or 96 and be exactly 10 digits.";
        } elseif (empty($address)) {
            $error = "Address is required.";
        } else {
           
            $conn->autocommit(FALSE); 
            $orderSuccess = true;
            foreach ($_SESSION['cart'] as $item) {
                $product_id = $item['id'];
                $quantity = $item['quantity'];

               
                $stockQuery = $conn->prepare("SELECT stock FROM product WHERE id = ?");
                $stockQuery->bind_param("i", $product_id);
                $stockQuery->execute();
                $stockResult = $stockQuery->get_result();
                $stockRow = $stockResult->fetch_assoc();

                if ($stockRow['stock'] < $quantity) {
                    $error = "Insufficient stock for product ID: $product_id";
                    $orderSuccess = false;
                    break;
                }

                $stockQuery->close();
            }


            if ($orderSuccess) {
               
                $orderQuery = $conn->prepare("INSERT INTO orders (customer_id, full_name, contact, address, total) VALUES (?, ?, ?, ?, ?)");
                $orderQuery->bind_param("isssi", $user_id, $name, $contact, $address, $total);

                if ($orderQuery->execute()) {
                    $order_id = $orderQuery->insert_id;
                    foreach ($_SESSION['cart'] as $item) {
                        $product_id = $item['id'];
                        $quantity = $item['quantity'];
                        $days = $item['days'];
                        $issued_date = date('Y-m-d');
                        $return_till = date('Y-m-d', strtotime($issued_date . ' + ' . $days . ' days'));
                        $price = $item['rent_price'] * $quantity * $days;

                        $orderDetailQuery = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, days, amount, issued_date, return_till) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $orderDetailQuery->bind_param("iiidsss", $order_id, $product_id, $quantity, $days, $price, $issued_date, $return_till);
                        if (!$orderDetailQuery->execute()) {
                            $orderSuccess = false;
                            $error = "Error: " . $orderDetailQuery->error;
                            break;
                        }

                        $updateStockQuery = $conn->prepare("UPDATE product SET stock = stock - ? WHERE id = ?");
                        $updateStockQuery->bind_param("ii", $quantity, $product_id);
                        if (!$updateStockQuery->execute()) {
                            $orderSuccess = false;
                            $error = "Error updating stock: " . $updateStockQuery->error;
                            break;
                        }
                    }
                } else {
                    $orderSuccess = false;
                    $error = "Error: " . $orderQuery->error;
                }
            }

            if ($orderSuccess) {
                $conn->commit(); 
                
                unset($_SESSION['cart']);
                
                header('Location: thank_you.php?order_id=' . $order_id);
                exit();
            } else {
                $conn->rollback(); 
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout</title>
        <link rel="stylesheet" href="css/checkout_style.css">
        
    </head>

    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="checkout">
                <h1>Checkout</h1>
                <div class="checkout_items">
                    <?php
                    $total = 0;
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $itemTotal = $item['rent_price'] * $item['quantity'] * $item['days'];
                            $total += $itemTotal;
                            echo '<div class="checkout_item">';
                            echo '<div class="checkout_image">';
                            echo '<img src="admin/images/' . $item['image'] . '">';
                            echo '</div>';
                            echo '<div class="checkout_details">';
                            echo '<h4>' . htmlspecialchars($item['name']) . '</h4>';
                            echo '<p class="checkout_price">NRs.' . htmlspecialchars($item['rent_price']) . ' per day</p>';
                            echo '<p class="checkout_quantity">Quantity: ' . htmlspecialchars($item['quantity']) . '</p>';
                            echo '<p class="checkout_days">Days: ' . htmlspecialchars($item['days']) . '</p>';
                            echo '<p class="checkout_item_total">Item Total: NRs.' . htmlspecialchars($itemTotal) . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Your cart is empty.</p>';
                    }
                    ?>
                </div>
                <div class="checkout_total">
                    <?php
                    echo '<p>Total: NRs.' . htmlspecialchars($total) . '</p>';
                    ?>
                </div>
                <div class="checkout_form">
                    <h1>Shipping Details</h1>
                    <?php if (!empty($error)) {
                        echo '<p class="error">' . htmlspecialchars($error) . '</p>';
                    } ?>
                    <form id="orderForm">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                        <label for="contact">Contact:</label>
                        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>"
                            required>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>"
                            required>

                        <input type="hidden" name="total" value="<?php echo htmlspecialchars($total); ?>">

                        <button type="button" id="khalti-button" class="checkout_btn">Pay with Khalti</button>

                    </form>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
        <script src="https://khalti.com/static/khalti-checkout.js"></script>
<script>
    var config = {
        publicKey: "test_public_key_dc74a55a3ca24a8395a7a1c84eab06a1",
        productIdentity: "WEARSHARE001",
        productName: "WearShare Order",
        productUrl: "http://localhost/wearshare/checkout.php",
        paymentPreference: ["KHALTI"],
        eventHandler: {
            onSuccess(payload) {
                // Collect form data
                const formData = new FormData(document.getElementById("orderForm"));
                formData.append("khalti_token", payload.token);
                formData.append("khalti_amount", payload.amount);

                fetch("place_order.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "thank_you.php?order_id=" + data.order_id;
                    } else {
                        alert("❌ Error placing order: " + data.message);
                    }
                });
            },
            onError(error) {
                console.log(error);
                alert("Payment failed!");
            },
            onClose() {
                console.log("Payment widget closed");
            }
        }
    };

    var checkout = new KhaltiCheckout(config);
    document.getElementById("khalti-button").onclick = function () {
        var total = <?php echo $total * 100; ?>; // in paisa
        checkout.show({ amount: total });
    };
</script>
    </body>

    </html>
    <?php
}
?>