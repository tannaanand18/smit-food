<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section py-5 text-center" style="background: linear-gradient(rgba(18, 18, 18, 0.85), rgba(18, 18, 18, 0.9)), url('https://images.unsplash.com/photo-1525351484163-7529414344d8?w=1200&q=80') center/cover; min-height: 65vh; display: flex; align-items: center;">
    <div class="container">
        <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill mb-3 fw-bold">WELCOME TO CHEF EGG</span>
        <h1 class="display-3 font-playfair fw-bold mb-3 text-white">Egg-cellent <span class="text-warning">Nutrition</span> <br>For A Healthy Lifestyle!</h1>
        <p class="lead mb-4 text-white-50 mx-auto" style="max-width: 650px;">All our recipes are crafted in such a way that you get maximum health benefits in each and every meal you order from us.</p>
        <a href="/pages/menu.php" class="btn btn-warning btn-lg rounded-pill px-5 py-3 shadow-lg fs-5 fw-bold text-dark">Explore Full Menu</a>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5" style="background-color: #161616;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-playfair fw-bold text-white">Our Specialties</h2>
            <p class="text-white-50">Explore our delicious egg categories crafted with care</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Category Card 1 -->
            <div class="col-6 col-md-3">
                <a href="/pages/menu.php?cat=Starter" class="text-decoration-none">
                    <div class="card food-card text-center py-4 border-secondary">
                        <i class="fa-solid fa-bowl-food fs-1 text-warning mb-3"></i>
                        <h5 class="text-white mb-1">Starter</h5>
                        <small class="text-white-50">Kofta, Chaap, Tikka & more</small>
                    </div>
                </a>
            </div>
            <!-- Category Card 2 -->
            <div class="col-6 col-md-3">
                <a href="/pages/menu.php?cat=Omelette" class="text-decoration-none">
                    <div class="card food-card text-center py-4 border-secondary">
                        <i class="fa-solid fa-egg fs-1 text-warning mb-3"></i>
                        <h5 class="text-white mb-1">Omelette</h5>
                        <small class="text-white-50">Cheese, Latpat, Curry & more</small>
                    </div>
                </a>
            </div>
            <!-- Category Card 3 -->
            <div class="col-6 col-md-3">
                <a href="/pages/menu.php?cat=Kheema And Gotala" class="text-decoration-none">
                    <div class="card food-card text-center py-4 border-secondary">
                        <i class="fa-solid fa-fire-burner fs-1 text-warning mb-3"></i>
                        <h5 class="text-white mb-1">Kheema & Gotala</h5>
                        <small class="text-white-50">Bhurji, Rajwadi, Royal Gotala</small>
                    </div>
                </a>
            </div>
            <!-- Category Card 4 -->
            <div class="col-6 col-md-3">
                <a href="/pages/menu.php?cat=Egg Fry" class="text-decoration-none">
                    <div class="card food-card text-center py-4 border-secondary">
                        <i class="fa-solid fa-kitchen-set fs-1 text-warning mb-3"></i>
                        <h5 class="text-white mb-1">Egg Fry</h5>
                        <small class="text-white-50">Half Fry, Lasan, Australian Fry</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Health Chart Section (From PDF Screenshot 1) -->
<section class="py-5 bg-dark">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="health-chart-box">
                    <h3 class="font-playfair text-warning mb-2 fw-bold"><i class="fa-solid fa-heart-pulse me-2"></i>Personalised Chef Egg Health Chart</h3>
                    <p class="text-white-50 mb-4 small">All our recipes are crafted in such a way that you get the following health benefits in each and every meal you order from us.</p>
                    
                    <div class="health-bar-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Protein</span>
                            <span class="text-warning fw-bold">45%</span>
                        </div>
                        <div class="progress bg-secondary" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 45%;"></div>
                        </div>
                    </div>
                    
                    <div class="health-bar-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Carbohydrates</span>
                            <span class="text-warning fw-bold">15%</span>
                        </div>
                        <div class="progress bg-secondary" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 15%;"></div>
                        </div>
                    </div>

                    <div class="health-bar-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Fiber</span>
                            <span class="text-warning fw-bold">10%</span>
                        </div>
                        <div class="progress bg-secondary" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;"></div>
                        </div>
                    </div>

                    <div class="health-bar-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Fat (Extra virgin Olive oil)</span>
                            <span class="text-warning fw-bold">5%</span>
                        </div>
                        <div class="progress bg-secondary" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 5%;"></div>
                        </div>
                    </div>

                    <div class="health-bar-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Calcium</span>
                            <span class="text-warning fw-bold">5%</span>
                        </div>
                        <div class="progress bg-secondary" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 5%;"></div>
                        </div>
                    </div>

                    <div class="health-bar-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Vitamins and Minerals</span>
                            <span class="text-warning fw-bold">10%</span>
                        </div>
                        <div class="progress bg-secondary" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;"></div>
                        </div>
                    </div>

                    <div class="health-bar-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Roughage and Water</span>
                            <span class="text-warning fw-bold">10%</span>
                        </div>
                        <div class="progress bg-secondary" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;"></div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 border border-warning rounded-3 text-center bg-black">
                        <h5 class="text-warning mb-0 fw-bold"><i class="fa-solid fa-shield-halved me-2"></i>100% Guarantee</h5>
                        <small class="text-white-50">For stress-free and healthy living</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=700&q=80" alt="Chef Egg Healthy Meals" class="img-fluid rounded-4 shadow-lg border border-secondary mb-3">
                <blockquote class="blockquote text-warning font-playfair fs-4">
                    "When We Cook... We Care For Your Health !!!"
                </blockquote>
            </div>
        </div>
    </div>
</section>

<!-- How it Works Section -->
<section class="py-5" style="background-color: #161616;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-playfair fw-bold text-white">How It Works</h2>
            <p class="text-white-50">Order your favorite egg dishes in 3 simple steps</p>
        </div>
        
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="bg-dark border border-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm" style="width: 90px; height: 90px;">
                    <i class="fa-solid fa-book-open fs-2 text-warning"></i>
                </div>
                <h4 class="text-white">1. Select Dishes</h4>
                <p class="text-white-50 px-3">Choose from Starters, Omelettes, Kheema, or Egg Fry varieties.</p>
            </div>
            <div class="col-md-4">
                <div class="bg-dark border border-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm" style="width: 90px; height: 90px;">
                    <i class="fa-solid fa-cart-arrow-down fs-2 text-warning"></i>
                </div>
                <h4 class="text-white">2. Add to Cart</h4>
                <p class="text-white-50 px-3">Customize quantities and proceed to our easy checkout.</p>
            </div>
            <div class="col-md-4">
                <div class="bg-dark border border-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm" style="width: 90px; height: 90px;">
                    <i class="fa-solid fa-motorcycle fs-2 text-warning"></i>
                </div>
                <h4 class="text-white">3. Fast Delivery</h4>
                <p class="text-white-50 px-3">Fresh, hot egg dishes delivered directly to your doorstep!</p>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
