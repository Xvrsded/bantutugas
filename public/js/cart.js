// Shopping Cart System
class ShoppingCart {
    constructor() {
        this.cartKey = 'bantutugas_cart';
        this.loadCart();
        this.initEventListeners();
        this.renderCart();
    }

    loadCart() {
        const stored = localStorage.getItem(this.cartKey);
        this.items = stored ? JSON.parse(stored) : [];
    }

    saveCart() {
        localStorage.setItem(this.cartKey, JSON.stringify(this.items));
    }

    addItem(id, name, price) {
        const existingItem = this.items.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.quantity += 1;
            this.showToast(`${name} ditambah ke keranjang (qty: ${existingItem.quantity})`);
        } else {
            this.items.push({
                id: id,
                name: name,
                price: price,
                quantity: 1
            });
            this.showToast(`${name} ditambahkan ke keranjang`);
        }
        
        this.saveCart();
        this.renderCart();
    }

    removeItem(id) {
        this.items = this.items.filter(item => item.id !== id);
        this.saveCart();
        this.renderCart();
    }

    updateQuantity(id, quantity) {
        const item = this.items.find(item => item.id === id);
        if (item) {
            item.quantity = Math.max(1, quantity);
            this.saveCart();
            this.renderCart();
        }
    }

    getTotalPrice() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    getTotalItems() {
        return this.items.reduce((total, item) => total + item.quantity, 0);
    }

    renderCart() {
        const cartWidget = document.getElementById('cart-widget');
        const cartCount = document.getElementById('cart-count');
        
        if (!cartWidget) return;

        const totalItems = this.getTotalItems();
        const totalPrice = this.getTotalPrice();

        // Update badge
        if (cartCount) {
            cartCount.textContent = totalItems;
            cartCount.style.display = totalItems > 0 ? 'flex' : 'none';
        }

        // Render items
        const cartItemsDiv = document.getElementById('cart-items');
        if (cartItemsDiv) {
            if (this.items.length === 0) {
                cartItemsDiv.innerHTML = '<p class="text-muted text-center p-3">Keranjang kosong</p>';
            } else {
                cartItemsDiv.innerHTML = this.items.map(item => `
                    <div class="cart-item-card" data-item-id="${item.id}">
                        <div class="cart-item-header">
                            <strong>${item.name}</strong>
                            <button class="btn-remove" onclick="cart.removeItem(${item.id})">×</button>
                        </div>
                        <div class="cart-item-price">Rp ${this.formatPrice(item.price)}</div>
                        <div class="cart-item-quantity">
                            <button onclick="cart.updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                            <input type="number" value="${item.quantity}" readonly>
                            <button onclick="cart.updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                        </div>
                        <div class="cart-item-subtotal">
                            Subtotal: Rp ${this.formatPrice(item.price * item.quantity)}
                        </div>
                    </div>
                `).join('');
            }
        }

        // Update total
        const cartTotal = document.getElementById('cart-total');
        if (cartTotal) {
            cartTotal.innerHTML = `
                <div class="cart-total-section">
                    <div class="total-items">Total Items: <strong>${totalItems}</strong></div>
                    <div class="total-price">Total: Rp <strong>${this.formatPrice(totalPrice)}</strong></div>
                    ${totalItems > 0 ? `
                        <button class="btn btn-primary w-100 mt-2" onclick="cart.checkout()">
                            <i class="bi bi-cart-check"></i> Checkout
                        </button>
                    ` : ''}
                </div>
            `;
        }
    }

    checkout() {
        if (this.items.length === 0) {
            alert('Keranjang Anda kosong!');
            return;
        }

        // Buat form untuk checkout
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/checkout';
        form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
            <input type="hidden" name="cart_items" value='${JSON.stringify(this.items)}'>
        `;
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    clearCart() {
        this.items = [];
        this.saveCart();
        this.renderCart();
    }

    formatPrice(price) {
        return new Intl.NumberFormat('id-ID').format(Math.round(price));
    }

    showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 3000);
    }

    initEventListeners() {
        const cartWidget = document.getElementById('cart-widget');
        if (!cartWidget) return;

        // Toggle cart visibility
        const cartToggle = document.getElementById('cart-toggle');
        if (cartToggle) {
            cartToggle.addEventListener('click', () => {
                cartWidget.classList.toggle('open');
            });
        }

        // Close cart when clicking outside
        document.addEventListener('click', (e) => {
            if (!cartWidget.contains(e.target) && !cartToggle.contains(e.target)) {
                cartWidget.classList.remove('open');
            }
        });
    }
}

// Initialize cart globally
let cart;
document.addEventListener('DOMContentLoaded', () => {
    cart = new ShoppingCart();
});

// Function to add item to cart with confirmation
function addToCart(serviceId, serviceName, servicePrice) {
    // Show confirmation modal
    const modal = document.getElementById('confirmation-modal');
    if (modal) {
        document.getElementById('confirm-service-name').textContent = serviceName;
        document.getElementById('confirm-service-price').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(servicePrice));
        document.getElementById('confirm-service-id').value = serviceId;
        document.getElementById('confirm-service-price-value').value = servicePrice;
        
        modal.style.display = 'flex';
    }
}

function confirmAddToCart() {
    const serviceId = parseInt(document.getElementById('confirm-service-id').value);
    const serviceName = document.getElementById('confirm-service-name').textContent;
    const servicePrice = parseFloat(document.getElementById('confirm-service-price-value').value);
    
    cart.addItem(serviceId, serviceName, servicePrice);
    closeConfirmationModal();
}

function closeConfirmationModal() {
    const modal = document.getElementById('confirmation-modal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Close modal when clicking outside
window.addEventListener('click', (event) => {
    const modal = document.getElementById('confirmation-modal');
    if (modal && event.target === modal) {
        closeConfirmationModal();
    }
});
