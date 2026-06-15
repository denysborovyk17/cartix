@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')

<!-- Main Section-->
<section class="mt-0 ">
    <!-- Page Content Goes Here -->

    <!-- Category Top Banner -->
    <div class="py-10 bg-img-cover bg-overlay-dark position-relative overflow-hidden bg-pos-center-center rounded-0"
         style="background-image: url(/images/banners/banner-category-top.jpg);">
        <div class="container-fluid position-relative z-index-20" data-aos="fade-right" data-aos-delay="300">
            <h1 class="fw-bold display-6 mb-4 text-white">Wishlist</h1>
        </div>
    </div>
    <!-- Category Top Banner -->

    <div class="container-fluid" data-aos="fade-in">
        <!-- Category Toolbar-->
        <div class="d-flex justify-content-between items-center pt-5 pb-4 flex-column flex-lg-row">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Sneakers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Releases</li>
                    </ol>
                </nav>        <h1 class="fw-bold fs-3 mb-2">New Releases (121)</h1>
                <p class="m-0 text-muted small">Showing 1 - 9 of 121</p>
            </div>
            <div class="d-flex justify-content-end align-items-center mt-4 mt-lg-0 flex-column flex-md-row">
                <!-- Sort Options-->
                <form method="GET" action="{{ url()->current() }}">
                    <select class="form-select form-select-sm border-0 bg-light p-3 pe-5 lh-1 fs-7" name="sort" onchange="this.form.submit()">
                        <option value="">Sort By</option>
                        <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>
                            Low To High
                        </option>
                        <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>
                            High to Low
                        </option>
                    </select>
                </form>
                <!-- / Sort Options-->
            </div>
        </div>
        <!-- /Category Toolbar-->

        <!-- Products-->

        <div class="row g-4">
            @foreach($wishlistItems as $wishlistItem)
                <div class="col-12 col-sm-6 col-lg-4">
                    <!-- Card Product-->
                    <div class="card border border-transparent h-100 transparent wishlist-item">
                        <div class="card-img position-relative" style="height: 500px; overflow: hidden;">
                            <button class="position-absolute top-0 end-0 m-2 p-2 text-muted rounded-circle toggle-wishlist-item"
                                    style="z-index: 999; border: none; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                    name="product_variant_id"
                                    data-product-variant-id="{{ $wishlistItem->id }}">
                            </button>

                            <picture class="d-block bg-light h-100">
                                <img class="w-100 h-100 object-fit-cover" src="{{ $wishlistItem->product->image }}" alt="">
                            </picture>
                        </div>

                        @if ($wishlistItem->first()->stock > 0)
                            <div class="p-2 opacity-100" style="position: relative; z-index: 50; opacity: 1 !important; visibility: visible !important;">
                                <button class="btn btn-quick-add w-100 add-cart-item"
                                        style="position: relative; z-index: 52; transform: translateY(0) !important; opacity: 1 !important;"
                                        name="product_variant_id"
                                        data-product-variant-id="{{ $wishlistItem->id }}">
                                    Add to Cart
                                </button>
                            </div>
                        @else
                            <div class="p-2 opacity-100" style="position: relative; z-index: 50; opacity: 1 !important; visibility: visible !important;">
                                <button class="btn btn-quick-add w-100 text-muted add-cart-item"
                                        style="position: relative; z-index: 52; transform: translateY(0) !important; opacity: 1 !important;"
                                        name="product_variant_id"
                                        data-product-variant-id="{{ $wishlistItem->id }}"
                                        disabled>
                                    Product is out of stock
                                </button>
                            </div>
                        @endif

                        <div class="card-body px-0">
                            <a class="text-decoration-none link-cover" href="{{ route('products.show', [$wishlistItem->product->slug, 'variant' => $wishlistItem->product->variants->first()->id]) }}">
                                {{ $wishlistItem->product->name }}
                            </a>
                            @if ($wishlistItem->discount_price)
                                <p class="mt-2 mb-0 small">
                                    <s class="text-muted">
                                        ${{ number_format($wishlistItem->product->variants->min('price') / 100, 2) }}
                                    </s>
                                    <span style="color: red">
                                        ${{ number_format($wishlistItem->discount_price / 100, 2) }}
                                    </span>
                                </p>
                            @else
                                <p class="mt-2 mb-0 small">
                                    <span>
                                        ${{ number_format($wishlistItem->min('price') / 100, 2) }}
                                    </span>
                                </p>
                            @endif
                        </div>
                    </div>
                    <!--/ Card Product-->
                </div>
            @endforeach
        </div>
        <!-- / Products-->

        <!-- Pagination-->
        <div class="d-flex flex-column f-w-44 mx-auto my-5 text-center">
            <div class="mt-5 d-flex justify-content-around">
                {{ $wishlistItems->links() }}
            </div>
        </div>
        <!-- / Pagination-->
    </div>

    <!-- /Page Content -->
</section>
<!-- / Main Section-->

    <!-- Offcanvas Imports-->
    <!-- Filters Offcanvas-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilters" aria-labelledby="offcanvasFiltersLabel">
        <div class="offcanvas-header pb-0 d-flex align-items-center">
            <h5 class="offcanvas-title" id="offcanvasFiltersLabel">Category Filters</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex flex-column justify-content-between w-100 h-100">
            </div>
        </div>
    </div>

    <!-- Vendor JS -->
    <script src="{{ asset('/js/vendor.bundle.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('/js/theme.bundle.js') }}"></script>

@endsection

