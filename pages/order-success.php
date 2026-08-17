<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/header.php';

redirect_if_not_logged_in();

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($order_id <= 0) {
    header("Location: /index.php");
    exit;
}
?>

<div class="container py-5 my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 p-5 text-center">
                
                <svg class="success-checkmark mb-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="success-checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="success-checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>

                <h1 class="font-playfair fw-bold text-dark mb-3">Order Placed Successfully!</h1>
                <p class="lead text-muted mb-4">Thank you for your order. Our chefs are already getting ready to prepare your delicious meal.</p>
                
                <div class="bg-light p-3 rounded-3 mb-4 d-inline-block">
                    <p class="mb-1"><strong>Order ID:</strong> #<?php echo str_pad($order_id, 6, '0', STR_PAD_LEFT); ?></p>
                    <p class="mb-0 text-primary fw-medium"><i class="fa-regular fa-clock me-2"></i>Estimated Delivery: 30 - 45 mins</p>
                </div>
                
                <div class="d-flex justify-content-center gap-3">
                    <a href="/pages/my-orders.php" class="btn btn-outline-primary rounded-pill px-4">Track Order</a>
                    <a href="/pages/menu.php" class="btn btn-primary rounded-pill px-4">Order More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-checkmark__circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: #4bb71b;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.success-checkmark__check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    stroke-width: 3;
    stroke: #4bb71b;
    fill: none;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}
@keyframes scale {
    0%, 100% {
        transform: none;
    }
    50% {
        transform: scale3d(1.1, 1.1, 1);
    }
}
@keyframes fill {
    100% {
        box-shadow: inset 0px 0px 0px 30px rgba(75, 183, 27, 0.1);
    }
}
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
