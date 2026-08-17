<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/session.php';

redirect_if_not_logged_in();

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: /pages/menu.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details for pre-filling
$stmt = $pdo->prepare("SELECT name, phone, address FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!check_csrf_token($_POST['csrf_token'])) {
        $error = "Invalid form submission.";
    } else {
        $delivery_name = trim(filter_var($_POST['delivery_name'], FILTER_SANITIZE_STRING));
        $phone = trim(filter_var($_POST['phone'], FILTER_SANITIZE_STRING));
        $address = trim(filter_var($_POST['address'], FILTER_SANITIZE_STRING));
        $notes = trim(filter_var($_POST['notes'], FILTER_SANITIZE_STRING));
        
        if (empty($delivery_name) || empty($phone) || empty($address)) {
            $error = "Name, Phone, and Address are required.";
        } else {
            // Calculate total
            $subtotal = 0;
            $items_json_array = [];
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['qty'];
                $items_json_array[] = [
                    'menu_id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty']
                ];
            }
            $tax = $subtotal * 0.05;
            $total_amount = $subtotal + $tax;
            $items_json = json_encode($items_json_array);

            // Insert Order
            try {
                $pdo->beginTransaction();
                
                $stmt = $pdo->prepare("INSERT INTO orders (user_id, items, total_amount, delivery_address, notes) VALUES (?, ?, ?, ?, ?)");
                $full_address = $delivery_name . "\n" . $phone . "\n" . $address;
                
                $stmt->execute([$user_id, $items_json, $total_amount, $full_address, $notes]);
                $order_id = $pdo->lastInsertId();
                
                // Clear cart
                unset($_SESSION['cart']);
                
                $pdo->commit();
                
                header("Location: /pages/order-success.php?id=" . $order_id);
                exit;
            } catch (PDOException $e) {
                $pdo->rollBack();
                $error = "Failed to place order. Please try again.";
            }
        }
    }
}

// Calculate summary for display
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['qty'];
}
$tax = $subtotal * 0.05;
$total = $subtotal + $tax;

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5">
    <h2 class="font-playfair fw-bold mb-4">Checkout</h2>

    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="font-playfair fw-bold mb-4 border-bottom pb-2">Delivery Details</h4>
                
                <form method="POST" action="/pages/checkout.php">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    
                    <div class="mb-3">
                        <label for="delivery_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="delivery_name" name="delivery_name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Delivery Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label for="notes" class="form-label">Special Instructions (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="E.g. No onions, leave at door..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fs-5 fw-bold shadow-sm mt-3">Place Order</button>
                </form>
            </div>
        </div>
        
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-light sticky-summary">
                <div class="card-body p-4">
                    <h4 class="font-playfair fw-bold mb-4">Order Summary</h4>
                    
                    <ul class="list-group list-group-flush mb-4 bg-transparent">
                        <?php foreach($cart as $item): ?>
                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <span class="fw-medium"><?php echo htmlspecialchars($item['name']); ?></span>
                                    <span class="text-muted ms-2">x<?php echo $item['qty']; ?></span>
                                </div>
                                <span>$<?php echo number_format($item['price'] * $item['qty'], 2); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-medium">$<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tax (5%)</span>
                        <span class="fw-medium">$<?php echo number_format($tax, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Delivery</span>
                        <span class="text-success fw-medium">Free</span>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="d-flex justify-content-between">
                        <span class="fs-5 fw-bold">Total to Pay</span>
                        <span class="fs-5 fw-bold text-primary">$<?php echo number_format($total, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
