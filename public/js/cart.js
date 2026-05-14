{
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    document.addEventListener('DOMContentLoaded', () => {
        addCartItem();
        updateCartItem();
        deleteCartItem();
    });

    function addCartItem() {
        document.body.addEventListener('click', async (e) => {
            const button = e.target.closest('.add-item');
            if (!button) {
                return;
            }

            const productVariantId = button.dataset.productVariantId;

            try {
                const response = await fetch(`/cart`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        product_variant_id: productVariantId,
                        quantity: 1
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
                    cartCounter.textContent = `My Cart (${data.cartCounter})`;
                }

                const existingCartItem = document.querySelector(`.cart-item[data-product-variant-id="${productVariantId}"]`);
                if (existingCartItem) {
                    const quantitySpan = existingCartItem.querySelector('.cart-item-quantity');
                    quantitySpan.textContent = `Quantity (${data.cartItem.quantity})`;
                } else {
                    const cartContainer = document.querySelector('#cart-container');
                    const html = `
                    <div class="row mx-0 py-4 g-0 border-bottom cart-item" data-product-variant-id="${data.cartItem.product_variant_id}">
                        <div class="col-2 position-relative">
                            <picture class="d-block ">
                                <img class="img-fluid" src="${data.cartItem.image}" alt="">
                            </picture>
                        </div>
                        <div class="col-9 offset-1">
                            <div>
                                <h6 class="justify-content-between d-flex align-items-start mb-2">
                                    ${data.cartItem.name}
                                    <i class="ri-close-line ms-3"></i>
                                </h6>
                                <span class="d-block text-muted fw-bolder text-uppercase fs-9 cart-item-quantity">Quantity (${data.cartItem.quantity})</span>
                            </div>
                            <p class="fw-bolder text-end text-muted m-0">
                               ${data.cartItem.price.formatted}
                            </p>
                        </div>
                    </div>`;

                    if (cartContainer) {
                        cartContainer.insertAdjacentHTML('beforeend', html);
                    }
                }

            } catch (error) {
                console.error(error);
            }
        });
    }

    function updateCartItem() {
        document.body.addEventListener('input', (e) => {
            if (!e.target.classList.contains('quantity')) {
                return;
            }

            const input = e.target;
            const quantity = Number(input.value);
            const productVariantId = input.dataset.productVariantId;

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
                        body: JSON.stringify({quantity})
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
                    console.error(error);
                }
            }, 400);
        })
    }

    function deleteCartItem() {
        document.body.addEventListener('click', async (e) => {
            const button = e.target.closest('.remove-item');
            if (!button) {
                return;
            }

            const productVariantId = button.dataset.productVariantId;

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
