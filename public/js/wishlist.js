{
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    document.addEventListener('DOMContentLoaded', () => {
        toggleWishlistItem();
    });

    function toggleWishlistItem() {
        document.addEventListener('click', async (event) => {
            const button = event.target.closest('.toggle-wishlist-item');
            if (!button) {
                return;
            }

            const productVariantId = button.getAttribute('data-product-variant-id');

            try {
                const response = await fetch(`/wishlist/${productVariantId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf
                    }
                });

                if (!response.ok) {
                    throw new Error('Request failed');
                }

                const data = await response.json();

                const wishlistCounter = document.querySelector('.wishlist-counter');
                if (wishlistCounter) {
                    wishlistCounter.textContent = `Wishlist (${data.wishlistCounter})`;
                }

                const card = button.closest('.card');
                const heart = button.querySelector('.ri-heart-line') || button.querySelector('.ri-heart-fill');
                const paragraph = document.createElement('p');
                paragraph.style.color = 'green';

                if (data.status) {
                    paragraph.textContent = 'Item added to wishlist';
                    heart.classList.add('ri-heart-fill');
                    heart.classList.remove('ri-heart-line');
                } else {
                    paragraph.textContent = 'Item removed from wishlist';
                    heart.classList.add('ri-heart-line');
                    heart.classList.remove('ri-heart-fill');
                    const row = button.closest('.wishlist-item');
                    if (row) {
                        row.remove();
                    }
                }

                setTimeout(() => {
                    paragraph.textContent = '';
                }, 1500)

                card.appendChild(paragraph);

            } catch (error) {
                console.log(error);
            }
        });
    }
}
