<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

// Fetch all menu items
$stmt = $pdo->query("SELECT * FROM menu WHERE is_available = 1 ORDER BY category, name");
$items = $stmt->fetchAll();

// Group items by category for easy filtering (if we want to render by category, but here we just render all and use JS or CSS to filter)
$categories = ['Starters', 'Main Course', 'Drinks', 'Desserts'];

$active_cat = $_GET['cat'] ?? 'All';
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="font-playfair fw-bold text-dark">Our Menu</h1>
        <p class="text-muted">Discover our delicious offerings</p>
    </div>

    <!-- Category Filters -->
    <ul class="nav nav-pills justify-content-center mb-5" id="menu-filters">
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 mx-1 <?php echo $active_cat === 'All' ? 'active btn-primary' : 'text-dark border'; ?>" href="#" data-filter="All">All</a>
        </li>
        <?php foreach($categories as $cat): ?>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-4 mx-1 <?php echo $active_cat === $cat ? 'active btn-primary' : 'text-dark border'; ?>" href="#" data-filter="<?php echo htmlspecialchars($cat); ?>">
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
                            <h5 class="card-title font-playfair fw-bold mb-0"><?php echo htmlspecialchars($item['name']); ?></h5>
                            <span class="badge"><?php echo htmlspecialchars($item['category']); ?></span>
                        </div>
                        <p class="card-text text-muted small flex-grow-1"><?php echo htmlspecialchars($item['description']); ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-5 fw-bold text-primary">$<?php echo number_format($item['price'], 2); ?></span>
                            <button class="btn btn-outline-primary rounded-pill add-to-cart-btn" 
                                    data-id="<?php echo $item['id']; ?>" 
                                    data-name="<?php echo htmlspecialchars($item['name']); ?>" 
                                    data-price="<?php echo $item['price']; ?>">
                                Add to Cart
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
                f.classList.remove('active', 'btn-primary');
                f.classList.add('text-dark', 'border');
            });
            this.classList.remove('text-dark', 'border');
            this.classList.add('active', 'btn-primary');
            
            const category = this.dataset.filter;
            applyFilter(category);
        });
    });

    function applyFilter(category) {
        items.forEach(item => {
            if (category === 'All' || item.dataset.category === category) {
                item.style.display = 'block';
                // Slight animation
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
        // Observe changes to main badge
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
