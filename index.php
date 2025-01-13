<?php
require_once 'Api.php';

$api = new Api();

// Cek saldo
$api_balance = $api->balance();
echo "Saldo: " . $api_balance['balance'] . "<br>";

// Daftar layanan
$api_service_list = $api->services();
echo "Layanan:<br>";
print_r($api_service_list);

// Membuat pesanan
$api_order = $api->order([
    'service' => 1038,
    'target' => 'targetnya',
    'quantity' => 100
]);
echo "ID Pesanan: " . $api_order['order'] . "<br>";

// Cek status pesanan
$api_status = $api->status('132448');
echo "Status Pesanan: " . $api_status['order_status'] . "<br>";

// Membuat refill pesanan
$api_refill = $api->refill('123');
echo "ID Refill: " . $api_refill['refill'] . "<