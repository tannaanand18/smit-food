<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$subtotal = 0;

// Handle manual update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_cart') {
    $id = (int)$_POST['id'];
    $qty = (int)$_POST['qty'];
    
    if ($qty > 0 && isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] = $qty;
    } elseif ($qty <= 0 && isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    
    header("Location: /pages/cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove_item') {
    $id = (int)$_POST['id'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: /pages/cart.php");
    exit;
}
?>

<div class="container py-5">
    <h2 class="font-playfair fw-bold mb-4 text-warning">Your Shopping Cart</h2>

    <?php if(empty($cart)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-cart-shopping fs-1 text-white-50 mb-3"></i>
            <h4 class="text-white">Your cart is empty</h4>
            <p class="text-white-50">Looks like you haven't added any Chef Egg specials yet.</p>
            <a href="/pages/menu.php" class="btn btn-warning mt-3 px-4 py-2 rounded-pill fw-bold text-dark">Explore Menu</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card food-card border-secondary rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3">Item</th>
                                        <th class="py-3">Price</th>
                                        <th class="py-3">Quantity</th>
                                        <th class="py-3">Total</th>
                                        <th class="pe-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($cart as $item): 
                                        $item_total = $item['price'] * $item['qty'];
                                        $subtotal += $item_total;
                                    ?>
                                        <tr>
                                            <td class="ps-4 py-3 fw-medium text-white"><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td class="py-3 text-warning">₹<?php echo number_format($item['price'], 0); ?></td>
                                            <td class="py-3" style="width: 150px;">
                                                <form method="POST" action="/pages/cart.php" class="d-flex align-items-center cart-update-form">
                                                    <input type="hidden" name="action" value="update_cart">
                                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-minus">-</button>
                                                    <input type="number" name="qty" class="form-control form-control-sm text-center mx-1 qty-input bg-dark text-white border-secondary" value="<?php echo $item['qty']; ?>" min="1" readonly style="width: 50px;">
                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-plus">+</button>
                                                </form>
                                            </td>
                                            <td class="py-3 fw-bold text-warning">₹<?php echo number_format($item_total, 0); ?></td>
                                            <td class="pe-4 py-3 text-end">
                                                <form method="POST" action="/pages/cart.php" class="d-inline">
                                                    <input type="hidden" name="action" value="remove_item">
                                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger text-white rounded-circle" title="Remove Item">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="/pages/menu.php" class="btn btn-outline-warning rounded-pill px-4"><i class="fa-solid fa-arrow-left me-2"></i>Continue Shopping</a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card food-card border-secondary rounded-4">
                    <div class="card-body p-4">
                        <h4 class="font-playfair fw-bold mb-4 text-warning">Order Summary</h4>
                        
                        <?php 
                            $tax_rate = 0.05;
                            $tax = $subtotal * $tax_rate;
                            $total = $subtotal + $tax;
                        ?>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-white-50">Subtotal</span>
                            <span class="fw-medium text-white">₹<?php echo number_format($subtotal, 0); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-white-50">GST (5%)</span>
                            <span class="fw-medium text-white">₹<?php echo number_format($tax, 0); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-white-50">Delivery</span>
                            <span class="text-success fw-medium">Free</span>
                        </div>
                        
                        <hr class="my-4 border-secondary">
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5 fw-bold text-white">Total</span>
                            <span class="fs-5 fw-bold text-warning">₹<?php echo number_format($total, 0); ?></span>
                        </div>
                        
                        <a href="/pages/checkout.php" class="btn btn-warning w-100 py-3 rounded-pill fs-5 fw-bold text-dark shadow-sm">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
