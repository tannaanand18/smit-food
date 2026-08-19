<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

// Fetch all menu items
$stmt = $pdo->query("SELECT * FROM menu WHERE is_available = 1 ORDER BY category, id");
$items = $stmt->fetchAll();

// Categories defined in Chef Egg menu
$categories = ['Starter', 'Omelette', 'Kheema And Gotala', 'Egg Fry'];

$active_cat = $_GET['cat'] ?? 'All';
?>

<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="font-playfair fw-bold text-warning display-4">Chef Egg Menu</h1>
        <p class="text-white-50 lead fs-5">WHEN WE COOK... WE CARE FOR YOUR HEALTH !!!</p>
    </div>

    <!-- Category Filters -->
    <ul class="nav nav-pills justify-content-center mb-5" id="menu-filters">
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 mx-1 my-1 <?php echo $active_cat === 'All' ? 'active btn-warning text-dark fw-bold' : 'text-white border border-secondary'; ?>" href="#" data-filter="All">All Dishes</a>
        </li>
        <?php foreach($categories as $cat): ?>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-4 mx-1 my-1 <?php echo $active_cat === $cat ? 'active btn-warning text-dark fw-bold' : 'text-white border border-secondary'; ?>" href="#" data-filter="<?php echo htmlspecialchars($cat); ?>">
                    <?php echo htmlspecialchars($cat); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Menu Grid -->
    <div class="row g-4" id="menu-grid">
        <?php foreach($items as $item): ?>
            <div class="col-12 col-md-6 col-lg-4 menu-item" data-category="<?php echo htmlspecialchars($item['category']); ?>">
                <div class="card food-card h-100">
                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title font-playfair fw-bold mb-0 text-white"><?php echo htmlspecialchars($item['name']); ?></h5>
                            <span class="badge bg-warning text-dark"><?php echo htmlspecialchars($item['category']); ?></span>
                        </div>
                        <p class="card-text text-white-50 small flex-grow-1"><?php echo htmlspecialchars($item['description']); ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-4 fw-bold text-warning">₹<?php echo number_format($item['price'], 0); ?>/-</span>
                            <button class="btn btn-warning btn-sm rounded-pill fw-bold text-dark add-to-cart-btn px-3 py-2" 
                                    data-id="<?php echo $item['id']; ?>" 
                                    data-name="<?php echo htmlspecialchars($item['name']); ?>" 
                                    data-price="<?php echo $item['price']; ?>">
                                <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Floating Cart Button -->
<a href="/pages/cart.php" class="floating-cart">
    <i class="fa-solid fa-cart-shopping"></i>
    <span class="badge bg-danger rounded-pill" id="floating-cart-badge"><?php echo $cart_count; ?></span>
</a>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Menu Filtering Logic
    const filters = document.querySelectorAll('#menu-filters .nav-link');
    const items = document.querySelectorAll('.menu-item');

    // Initial filter from URL if present
    const urlParams = new URLSearchParams(window.location.search);
    const initialCat = urlParams.get('cat') || 'All';
    applyFilter(initialCat);

    filters.forEach(filter => {
        filter.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active state
            filters.forEach(f => {
                f.classList.remove('active', 'btn-warning', 'text-dark', 'fw-bold');
                f.classList.add('text-white', 'border', 'border-secondary');
            });
            this.classList.remove('text-white', 'border', 'border-secondary');
            this.classList.add('active', 'btn-warning', 'text-dark', 'fw-bold');
            
            const category = this.dataset.filter;
            applyFilter(category);
        });
    });

    function applyFilter(category) {
        items.forEach(item => {
            if (category === 'All' || item.dataset.category === category) {
                item.style.display = 'block';
                item.animate([
                    { opacity: 0, transform: 'scale(0.95)' },
                    { opacity: 1, transform: 'scale(1)' }
                ], { duration: 300, fill: 'forwards' });
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Update floating badge when main badge updates
    const mainBadge = document.getElementById('cart-badge');
    const floatBadge = document.getElementById('floating-cart-badge');
    
    if (mainBadge && floatBadge) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === "childList") {
                    floatBadge.textContent = mainBadge.textContent;
                }
            });
        });
        observer.observe(mainBadge, { childList: true });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
