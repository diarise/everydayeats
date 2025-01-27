<?php
header('Content-Type: application/json');

// Sanitize inputs
$data = [
    'order_id' => uniqid('HH-'),
    'customer_name' => filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING),
    'customer_email' => filter_input(INPUT_POST, 'customer_email', FILTER_SANITIZE_EMAIL),
    'customer_phone' => filter_input(INPUT_POST, 'customer_phone', FILTER_SANITIZE_STRING),
    'delivery_address' => filter_input(INPUT_POST, 'delivery_address', FILTER_SANITIZE_STRING),
    'delivery_time' => filter_input(INPUT_POST, 'delivery_time', FILTER_SANITIZE_STRING),
    'total_amount' => filter_input(INPUT_POST, 'total_amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
    'cart' => json_decode($_POST['cart'], true)
];

// Validate required fields
$required = ['customer_name', 'customer_email', 'delivery_address', 'delivery_time'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
}

// Build email message
$message = "New Order Received!\n\n";
$message .= "Order ID: {$data['order_id']}\n";
$message .= "Customer: {$data['customer_name']}\n";
$message .= "Email: {$data['customer_email']}\n";
$message .= "Phone: {$data['customer_phone']}\n";
$message .= "Address: {$data['delivery_address']}\n";
$message .= "Delivery Time: {$data['delivery_time']}\n\n";
$message .= "Items:\n";

foreach ($data['cart'] as $item) {
    $message .= "- {$item['name']} ({$item['quantity']} x \${$item['price']})\n";
}

$message .= "\nTotal: \${$data['total_amount']}";

// Send email
$to = 'diarise@gmail.com';
$subject = "New Order: {$data['order_id']}";
$headers = "From: {$data['customer_email']}";

if (mail($to, $subject, $message, $headers)) {
    echo json_encode(['success' => true, 'order_id' => $data['order_id']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send order']);
}