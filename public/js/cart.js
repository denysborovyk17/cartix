{
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    document.addEventListener('DOMContentLoaded', () => {
        addCartItem();
        updateCartItem();
        deleteCartItem();
    });

    function addCartItem() {
        document.addEventListener('click', async (event) => {
            const button = event.target.closest('.add-cart-item');
            if (!button) {
                return;
            }

            const productVariantId = button.getAttribute('data-product-variant-id');
            const productVariantQuantity = 1;

            try {
                const response = await fetch(`/cart`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        product_variant_id: productVariantId,
                        quantity: productVariantQuantity
                    })
                });

                if (!response.ok) {
                    throw new Error('Request failed');
                }

                const data = await response.json();

                const originalText = button.textContent;

                button.textContent = 'Added';
                button.disabled = true;

                setTimeout(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                }, 1500);

                const cartCounter = document.querySelector('.cart-counter')
                if (cartCounter) {
                    cartCounter.textContent = `Cart (${data.cartCounter})`;
                }

                const itemTotal = document.querySelector(`.item-total[data-product-variant-id="${productVariantId}"]`);
                if (itemTotal) {
                    itemTotal.textContent = `${data.itemTotal}`;
                }

                const cartTotal = document.querySelector(`.cart-total`);
                if (cartTotal) {
                    cartTotal.textContent = `${data.cartTotal}`;
                }

                const existingCartItem = document.querySelector(`.cart-item[data-product-variant-id="${productVariantId}"]`);
                if (existingCartItem) {
                    const cartItemQuantity = existingCartItem.querySelector('.cart-item-quantity');
                    cartItemQuantity.textContent = `Quantity (${data.cartItem.quantity})`;
                }

            } catch (error) {
                console.error(error);
            }
        });
    }

    function updateCartItem() {
        document.addEventListener('input', (event) => {
            if (!event.target.classList.contains('cart-item-quantity')) {
                return;
            }

            const input = event.target;
            const quantity = Number(input.value);
            const productVariantId = input.getAttribute('data-product-variant-id');

            if (!quantity || quantity < 1) {
                return;
            }

            clearTimeout(input.debounceTimer);

            input.debounceTimer = setTimeout(async () => {
                try {
                    const response = await fetch(`/cart/${productVariantId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    });

                    const data = await response.json();

                    const itemTotal = document.querySelector(`.item-total[data-product-variant-id="${productVariantId}"]`);
                    if (itemTotal) {
                        itemTotal.textContent = `${data.itemTotal}`;
                    }

                    const cartTotal = document.querySelector(`.cart-total`);
                    if (cartTotal) {
                        cartTotal.textContent = `${data.cartTotal}`;
                    }

                } catch (error) {
                    console.log(error);
                }
            }, 400);
        })
    }

    function deleteCartItem() {
        document.addEventListener('click', async (event) => {
            const button = event.target.closest('.remove-cart-item');
            if (!button) {
                return;
            }

            const productVariantId = button.getAttribute('data-product-variant-id');

            try {
                const response = await fetch(`/cart/${productVariantId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    }
                });

                if (!response.ok) {
                    throw new Error('Request failed');
                }

                const data = await response.json();

                const row = button.closest('.cart-item');
                if (row) {
                    row.remove();
                }

                const cartTotal = document.querySelector('.cart-total');
                if (cartTotal) {
                    cartTotal.textContent = `${data.cartTotal}`;
                }

            } catch (error) {
                console.error(error);
            }
        });
    }
}
