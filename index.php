<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section py-5 text-center" style="background: linear-gradient(rgba(255, 248, 243, 0.9), rgba(255, 248, 243, 0.9)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1200&q=80') center/cover; min-height: 60vh; display: flex; align-items: center;">
    <div class="container">
        <h1 class="display-3 font-playfair fw-bold mb-4 text-dark">Taste the Magic of <br><span class="text-primary">Perfect Flavors</span></h1>
        <p class="lead mb-5 text-secondary mx-auto" style="max-width: 600px;">Experience culinary excellence delivered straight to your door. Fresh ingredients, masterful chefs, unforgettable taste.</p>
        <a href="/pages/menu.php" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-sm fs-5">Order Now</a>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-playfair fw-bold">Explore Our Menu</h2>
            <p class="text-muted">Discover our carefully crafted categories</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Category Card 1 -->
            <div class="col-6 col-md-3">
                <a href="/pages/menu.php?cat=Starters" class="text-decoration-none">
                    <div class="card food-card text-center py-4 border-0 bg-light">
                        <i class="fa-solid fa-leaf fs-1 text-primary mb-3"></i>
                        <h5 class="text-dark mb-0">Starters</h5>
                    </div>
                </a>
            </div>
            <!-- Category Card 2 -->
            <div class="col-6 col-md-3">
                <a href="/pages/menu.php?cat=Main Course" class="text-decoration-none">
                    <div class="card food-card text-center py-4 border-0 bg-light">
                        <i class="fa-solid fa-bell-concierge fs-1 text-primary mb-3"></i>
                        <h5 class="text-dark mb-0">Main Course</h5>
                    </div>
                </a>
            </div>
            <!-- Category Card 3 -->
            <div class="col-6 col-md-3">
                <a href="/pages/menu.php?cat=Drinks" class="text-decoration-none">
                    <div class="card food-card text-center py-4 border-0 bg-light">
                        <i class="fa-solid fa-martini-glass-citrus fs-1 text-primary mb-3"></i>
                        <h5 class="text-dark mb-0">Drinks</h5>
                    </div>
                </a>
            </div>
            <!-- Category Card 4 -->
            <div class="col-6 col-md-3">
                <a href="/pages/menu.php?cat=Desserts" class="text-decoration-none">
                    <div class="card food-card text-center py-4 border-0 bg-light">
                        <i class="fa-solid fa-ice-cream fs-1 text-primary mb-3"></i>
                        <h5 class="text-dark mb-0">Desserts</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- How it Works Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-playfair fw-bold">How It Works</h2>
            <p class="text-muted">Order your favorite food in 3 simple steps</p>
        </div>
        
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm" style="width: 100px; height: 100px;">
                    <i class="fa-solid fa-book-open fs-2 text-primary"></i>
                </div>
                <h4>1. Browse Menu</h4>
                <p class="text-muted px-3">Explore our extensive menu of delicious, freshly prepared dishes.</p>
            </div>
            <div class="col-md-4">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm" style="width: 100px; height: 100px;">
                    <i class="fa-solid fa-cart-arrow-down fs-2 text-primary"></i>
                </div>
                <h4>2. Add to Cart</h4>
                <p class="text-muted px-3">Select your favorites and add them to your shopping cart.</p>
            </div>
            <div class="col-md-4">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm" style="width: 100px; height: 100px;">
                    <i class="fa-solid fa-credit-card fs-2 text-primary"></i>
                </div>
                <h4>3. Confirm Order</h4>
                <p class="text-muted px-3">Checkout quickly and securely, then enjoy your meal!</p>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
