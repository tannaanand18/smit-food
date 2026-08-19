<footer class="footer mt-auto py-5 bg-dark text-white">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="text-warning font-playfair mb-3"><i class="fa-solid fa-egg me-2"></i>Chef Egg</h5>
                <p class="text-white-50">Egg-cellent nutrition for a healthy lifestyle! All our recipes are crafted to provide maximum health benefits.</p>
                <div class="social-links mt-3">
                    <a href="#" class="text-white-50 me-3 fs-5 hover-text-primary"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="text-white-50 me-3 fs-5 hover-text-primary"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="text-white-50 me-3 fs-5 hover-text-primary"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="/index.php" class="text-white-50 text-decoration-none hover-text-white">Home</a></li>
                    <li class="mb-2"><a href="/pages/menu.php" class="text-white-50 text-decoration-none hover-text-white">Menu</a></li>
                    <li class="mb-2"><a href="/pages/cart.php" class="text-white-50 text-decoration-none hover-text-white">Cart</a></li>
                    <?php if(is_logged_in()): ?>
                        <li class="mb-2"><a href="/pages/my-orders.php" class="text-white-50 text-decoration-none hover-text-white">My Orders</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-lg-4 col-md-12">
                <h5 class="mb-3">Contact Us</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="fa-solid fa-location-dot me-2 text-warning"></i> S.V. Patel Road, Opp. Alka Dairy, Bilimora</li>
                    <li class="mb-2"><i class="fa-solid fa-phone me-2 text-warning"></i> +91 84601 50125</li>
                    <li class="mb-2"><i class="fa-solid fa-envelope me-2 text-warning"></i> chefegg116@gmail.com</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary mt-4 mb-4">
        <div class="text-center text-white-50">
            <small>&copy; <?php echo date('Y'); ?> Chef Egg. All rights reserved. Thank You Visit Again!</small>
        </div>
    </div>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom Cart JS -->
<script src="/assets/js/cart.js"></script>
</body>
</html>
