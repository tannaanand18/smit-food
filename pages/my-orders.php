<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/header.php';

redirect_if_not_logged_in();
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

function getStatusBadgeClass($status) {
    switch ($status) {
        case 'pending': return 'bg-warning text-dark';
        case 'confirmed': return 'bg-info text-dark';
        case 'preparing': return 'bg-primary';
        case 'delivered': return 'bg-success';
        case 'cancelled': return 'bg-danger';
        default: return 'bg-secondary';
    }
}
?>

<div class="container py-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-playfair fw-bold mb-0 text-warning">My Orders</h2>
        <a href="/pages/menu.php" class="btn btn-outline-warning rounded-pill px-4">Order Again</a>
    </div>

    <?php if(empty($orders)): ?>
        <div class="card food-card border-secondary text-center py-5">
            <div class="card-body">
                <i class="fa-solid fa-receipt fs-1 text-white-50 mb-3"></i>
                <h4 class="text-white">No orders yet</h4>
                <p class="text-white-50 mb-4">You haven't placed any orders with Chef Egg yet.</p>
                <a href="/pages/menu.php" class="btn btn-warning rounded-pill px-4 fw-bold text-dark">Explore Chef Egg Menu</a>
            </div>
        </div>
    <?php else: ?>
        <div class="card food-card border-secondary overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead class="table-dark text-warning border-secondary">
                            <tr>
                                <th class="ps-4 py-3">Order ID</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Items Summary</th>
                                <th class="py-3">Total</th>
                                <th class="py-3">Status</th>
                                <th class="pe-4 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $order): 
                                $items = json_decode($order['items'], true);
                                $items_summary = [];
                                if(is_array($items)) {
                                    foreach($items as $item) {
                                        $items_summary[] = $item['qty'] . 'x ' . $item['name'];
                                    }
                                }
                                $summary_text = implode(', ', $items_summary);
                                if(strlen($summary_text) > 40) {
                                    $summary_text = substr($summary_text, 0, 40) . '...';
                                }
                            ?>
                                <tr>
                                    <td class="ps-4 py-3 fw-bold text-warning">#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                                    <td class="py-3 text-white-50"><?php echo date('M d, Y g:i A', strtotime($order['created_at'])); ?></td>
                                    <td class="py-3 text-white" title="<?php echo htmlspecialchars(implode(', ', $items_summary)); ?>">
                                        <?php echo htmlspecialchars($summary_text); ?>
                                    </td>
                                    <td class="py-3 fw-bold text-warning">₹<?php echo number_format($order['total_amount'], 0); ?></td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill <?php echo getStatusBadgeClass($order['status']); ?> px-3 py-2 text-capitalize">
                                            <?php echo htmlspecialchars($order['status']); ?>
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <button class="btn btn-sm btn-outline-warning rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order['id']; ?>">
                                            View Details
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal for Order Details -->
                                <div class="modal fade" id="orderModal<?php echo $order['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-secondary bg-dark text-white shadow-lg">
                                            <div class="modal-header border-bottom border-secondary pb-3">
                                                <h5 class="modal-title font-playfair fw-bold text-warning">Order #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pt-3">
                                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-secondary">
                                                    <span class="text-white-50">Date: <?php echo date('M d, Y', strtotime($order['created_at'])); ?></span>
                                                    <span class="badge <?php echo getStatusBadgeClass($order['status']); ?> text-capitalize"><?php echo htmlspecialchars($order['status']); ?></span>
                                                </div>
                                                
                                                <h6 class="fw-bold mb-3 text-warning">Items</h6>
                                                <ul class="list-group list-group-flush mb-4 bg-transparent">
                                                    <?php foreach($items as $item): ?>
                                                        <li class="list-group-item bg-transparent text-white border-secondary px-0 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <span class="fw-medium text-white"><?php echo htmlspecialchars($item['name']); ?></span>
                                                                <span class="text-white-50 ms-2">x<?php echo $item['qty']; ?></span>
                                                            </div>
                                                            <span class="text-warning">₹<?php echo number_format($item['price'] * $item['qty'], 0); ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="fs-5 fw-bold text-white">Total Paid</span>
                                                    <span class="fs-5 fw-bold text-warning">₹<?php echo number_format($order['total_amount'], 0); ?></span>
                                                </div>
                                                
                                                <div class="bg-black p-3 border border-secondary rounded-3 mt-4">
                                                    <h6 class="fw-bold mb-2 text-warning">Delivery Details</h6>
                                                    <p class="mb-0 text-white-50 small" style="white-space: pre-line;"><?php echo htmlspecialchars($order['delivery_address']); ?></p>
                                                    <?php if(!empty($order['notes'])): ?>
                                                        <hr class="my-2 border-secondary">
                                                        <p class="mb-0 text-white-50 small"><strong class="text-white">Note:</strong> <?php echo htmlspecialchars($order['notes']); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top border-secondary">
                                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
