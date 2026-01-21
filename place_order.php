<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

// 1. Verify Khalti Token
$token = $_POST['khalti_token'];
$amount = $_POST['khalti_amount'];

$verify_url = "https://khalti.com/api/v2/payment/verify/";
$args = http_build_query([
    'token' => $token,
    'amount' => $amount
]);

$headers = [
    "Authorization: Key test_secret_key_d7ebd54632f64cbcb31bbfae0093e8a4"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $verify_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($status_code != 200) {
    echo json_encode(["success" => false, "message" => "Payment verification failed."]);
    exit();
}

// 2. Place the Order (move your current SQL code here)
