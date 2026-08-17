<?php
require_once __DIR__ . '/../includes/session.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$action = $_POST['action'] ?? '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($action === 'add') {
    $name = $_POST['name'] ?? 'Unknown';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

    if ($id > 0 && $price >= 0) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'qty' => $qty
            ];
        }
    }
} elseif ($action === 'remove') {
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
} elseif ($action === 'update') {
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    if ($qty > 0 && isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] = $qty;
    } elseif ($qty <= 0 && isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

// Calculate new total items
$total_items = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_items += $item['qty'];
}

echo json_encode([
    'success' => true,
    'total_items' => $total_items,
    'cart' => $_SESSION['cart']
]);
