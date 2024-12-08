// review.js
document.addEventListener('DOMContentLoaded', () => {
    class ReviewManager {
        constructor() {
            this.cartKey = 'autoCarCart';
            this.deliveryKey = 'autoCarDelivery';
        }

        // Display review information
        displayReviewDetails() {
            const cartItems = JSON.parse(localStorage.getItem(this.cartKey) || '[]');
            const deliveryInfo = JSON.parse(localStorage.getItem(this.deliveryKey) || '{}');

            // Update product details
            const productContainer = document.getElementById('product-details');
            if (productContainer) {
                let totalPrice = 0;
                productContainer.innerHTML = cartItems.map(item => {
                    totalPrice += item.price;
                    return `
                        <div class="review-product-item">
                            <span>${item.brand} - ${item.name}</span>
                            <span>${item.price.toLocaleString()} VND</span>
                        </div>
                    `;
                }).join('');

                // Add total summary
                productContainer.innerHTML += `
                    <div class="review-total">
                        <div>Tổng số lượng:</div>
                        <div>${cartItems.length} xe</div>
                        <div>Tổng tiền:</div>
                        <div>${totalPrice.toLocaleString()} VND</div>
                    </div>
                `;
            }

            // Update delivery information
            const deliveryContainer = document.getElementById('delivery-details');
            if (deliveryContainer && deliveryInfo.fullName) {
                deliveryContainer.innerHTML = `
                    <div class="review-delivery-info">
                        <p><strong>Người nhận:</strong> ${deliveryInfo.fullName}</p>
                        <p><strong>Điện thoại:</strong> ${deliveryInfo.phone}</p>
                        <p><strong>Địa chỉ:</strong> ${deliveryInfo.address}, ${deliveryInfo.district}, ${deliveryInfo.province}</p>
                    </div>
                `;
            }
        }
    }

    // Initialize review manager
    const reviewManager = new ReviewManager();
    reviewManager.displayReviewDetails();
});