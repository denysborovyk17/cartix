<div class="row mx-0 py-4 g-0 border-bottom cart-item" data-product-variant-id="{{ $cartItem->product_variant_id }}">
    <div class="col-2 position-relative">
        <picture class="d-block ">
            <img class="img-fluid" src="{{ $cartItem->productVariant->product->image }}" alt="">
        </picture>
    </div>
    <div class="col-9 offset-1">
        <div>
            <h6 class="justify-content-between d-flex align-items-start mb-2">
                {{ $cartItem->productVariant->product->name }}
                <i class="ri-close-line ms-3"></i>
            </h6>
            <span class="d-block text-muted fw-bolder text-uppercase fs-9 cart-item-quantity">
                Quantity ({{ $cartItem->quantity }})
            </span>
        </div>
        <small class="text-muted d-block">
            {{ $cartItem->productVariant->optionValues->pluck('value')->implode(' + ') }}
        </small>
        <p class="fw-bolder text-end text-muted m-0" data-product-variant-id="{{ $cartItem->product_variant_id }}">
            ${{ number_format($cartItem->productVariant->price / 100, 2) }}
        </p>
    </div>
</div>
