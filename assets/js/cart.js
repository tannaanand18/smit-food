document.addEventListener('DOMContentLoaded', () => {
    
    // Add to Cart functionality via AJAX
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const cartBadge = document.getElementById('cart-badge');
    const cartToast = document.getElementById('cartToast');
    let bsToast = null;
    
    if (cartToast) {
        bsToast = new bootstrap.Toast(cartToast, { delay: 3000 });
    }

    addToCartButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const itemId = this.dataset.id;
            const itemName = this.dataset.name;
            const itemPrice = this.dataset.price;
            
            // Disable button temporarily to prevent double click
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
            
            fetch('/ajax/cart_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=add&id=${itemId}&name=${encodeURIComponent(itemName)}&price=${itemPrice}&qty=1`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update badge
                    if (cartBadge) {
                        cartBadge.textContent = data.total_items;
                        // Add small animation class
                        cartBadge.classList.add('animate__animated', 'animate__bounceIn');
                        setTimeout(() => {
                            cartBadge.classList.remove('animate__animated', 'animate__bounceIn');
                        }, 1000);
                    }
                    
                    // Show Toast
                    if (bsToast) {
                        document.querySelector('#cartToast .toast-body').textContent = `${itemName} added to cart!`;
                        bsToast.show();
                    }
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                alert("An error occurred while adding to cart.");
            })
            .finally(() => {
                // Revert button state
                this.disabled = false;
                this.innerHTML = 'Add to Cart';
            });
        });
    });

    // Cart page logic (update qty, remove)
    const cartForms = document.querySelectorAll('.cart-update-form');
    cartForms.forEach(form => {
        const input = form.querySelector('.qty-input');
        const btnMinus = form.querySelector('.btn-minus');
        const btnPlus = form.querySelector('.btn-plus');
        
        if (btnMinus && btnPlus && input) {
            btnMinus.addEventListener('click', () => {
                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                    form.submit();
                }
            });
            
            btnPlus.addEventListener('click', () => {
                input.value = parseInt(input.value) + 1;
                form.submit();
            });
        }
    });
});
