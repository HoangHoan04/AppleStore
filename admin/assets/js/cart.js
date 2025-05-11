document.addEventListener('DOMContentLoaded', function () {
    const checkoutBtn = document.getElementById('checkout-btn');
    const paymentModalElement = document.getElementById('payment-modal');
    const cartItems = document.getElementById('cart-items');
    const subtotalElement = document.getElementById('subtotal');
    const totalPriceElement = document.getElementById('total-price');

    if (checkoutBtn && paymentModalElement && cartItems && subtotalElement && totalPriceElement) {
        const paymentModal = new bootstrap.Modal(paymentModalElement);

        // Hiển thị modal thanh toán khi nhấn nút "Thanh toán"
        checkoutBtn.addEventListener('click', function () {
            paymentModal.show();
        });

        // Thêm sự kiện cho các nút tăng/giảm số lượng và xóa sản phẩm
        cartItems.addEventListener('click', function (event) {
            if (event.target.classList.contains('increase-quantity')) {
                const quantityInput = event.target.closest('.product-quantity').querySelector('.quantity');
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateCart();
            } else if (event.target.classList.contains('decrease-quantity')) {
                const quantityInput = event.target.closest('.product-quantity').querySelector('.quantity');
                if (quantityInput.value > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                    updateCart();
                }
            } else if (event.target.classList.contains('remove-item')) {
                event.target.closest('li').remove();
                updateCart();
            }
        });

        // Cập nhật tổng tiền và tạm tính
        function updateCart() {
            let subtotal = 0;
            cartItems.querySelectorAll('li').forEach(item => {
                const price = parseInt(item.querySelector('.selling-price').textContent.replace(/,/g, ''));
                const quantity = parseInt(item.querySelector('.quantity').value);
                subtotal += price * quantity;
            });
            subtotalElement.textContent = subtotal.toLocaleString() + ' VND';
            totalPriceElement.textContent = subtotal.toLocaleString() + ' VND';
        }

        // Xác nhận thanh toán
        document.getElementById('confirm-payment').addEventListener('click', function () {
            const userName = document.getElementById('user-name').value;
            const userPhone = document.getElementById('user-phone').value;
            const userEmail = document.getElementById('user-email').value;
            const paymentMethod = document.getElementById('payment-method').value;
            const totalPrice = totalPriceElement.textContent;

            document.getElementById('bill-name').textContent = userName;
            document.getElementById('bill-phone').textContent = userPhone;
            document.getElementById('bill-email').textContent = userEmail;
            document.getElementById('bill-method').textContent = paymentMethod;
            document.getElementById('bill-total').textContent = totalPrice;

            document.getElementById('bill-section').style.display = 'block';
            paymentModal.hide();
        });

        // Chọn phương thức giao hàng
        document.querySelectorAll('input[name="shipping-method"]').forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'home') {
                    document.getElementById('home-delivery-section').style.display = 'block';
                    document.getElementById('store-pickup-section').style.display = 'none';
                } else {
                    document.getElementById('home-delivery-section').style.display = 'none';
                    document.getElementById('store-pickup-section').style.display = 'block';
                }
            });
        });
    } else {
        console.error('One or more elements are missing in the DOM.');
    }
});