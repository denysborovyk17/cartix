@extends('layouts.app')

@section('title', 'Products')

@section('content')

<!-- Main Section-->
<section class="mt-0 ">
    <!-- Page Content Goes Here -->

    <!-- Category Top Banner -->
    <div class="py-10 bg-img-cover bg-overlay-dark position-relative overflow-hidden bg-pos-center-center rounded-0"
         style="background-image: url(/images/banners/banner-category-top.jpg);">
        <div class="container-fluid position-relative z-index-20" data-aos="fade-right" data-aos-delay="300">
            <h1 class="fw-bold display-6 mb-4 text-white">{{ $category->name }}</h1>
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

                <!-- Filter Trigger-->
                <button class="btn bg-light p-3 me-md-3 d-flex align-items-center fs-7 lh-1 w-100 mb-2 mb-md-0 w-md-auto " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilters" aria-controls="offcanvasFilters">
                    <i class="ri-equalizer-line me-2"></i> Filters
                </button>
                <!-- / Filter Trigger-->

                <!-- Sort Options-->
                <select class="form-select form-select-sm border-0 bg-light p-3 pe-5 lh-1 fs-7">
                    <option selected>Sort By</option>
                    <option value="1">Hi Low</option>
                    <option value="2">Low Hi</option>
                    <option value="3">Name</option>
                </select>
                <!-- / Sort Options-->
            </div>
        </div>            <!-- /Category Toolbar-->

        <!-- Products-->
        @session('success')
            <h3 style="color: limegreen">{{ $value }}</h3>
        @endsession

        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-12 col-sm-6 col-lg-4">
                    <!-- Card Product-->
                    <div class="card border border-transparent h-100 transparent">

                        <div class="card-img position-relative" style="height: 500px; overflow: hidden;">
                            <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i class="ri-heart-line"></i></span>

                            <picture class="d-block bg-light h-100">
                                <img class="w-100 h-100 object-fit-cover" src="{{ $product->image }}" alt="">
                            </picture>

                        </div>

                        @if ($product->variants->first()->stock > 0)
                            <div class="p-2 opacity-100" style="position: relative; z-index: 50; opacity: 1 !important; visibility: visible !important;">
                                <button class="btn btn-quick-add w-100 add-item"
                                        style="position: relative; z-index: 52; transform: translateY(0) !important; opacity: 1 !important;"
                                        name="product_variant_id"
                                        data-product-variant-id="{{ $product->variants->first()->id }}">
                                    Add to Cart
                                </button>
                            </div>
                        @else
                            <div class="p-2 opacity-100" style="position: relative; z-index: 50; opacity: 1 !important; visibility: visible !important;">
                                <button class="btn btn-quick-add w-100 add-item"
                                        style="position: relative; z-index: 52; transform: translateY(0) !important; opacity: 1 !important;"
                                        name="product_variant_id"
                                        data-product-variant-id="{{ $product->variants->first()->id }}"
                                        disabled>
                                    Add to Cart
                                </button>
                            </div>
                        @endif

                        <div class="card-body px-0">
                            <a class="text-decoration-none link-cover" href="{{ route('products.show', [$product->slug, 'variant' => $product->variants->first()->id]) }}">
                                {{ $product->name }}
                            </a>
                            @if ($product->variants->first()->discount_price)
                                <p class="mt-2 mb-0 small">
                                    <s class="text-muted">
                                        ${{ number_format($product->variants->first()->price / 100, 2) }}
                                    </s>
                                    <span style="color: red">
                                        ${{ number_format($product->variants->first()->discount_price / 100, 2) }}
                                    </span>
                                </p>
                            @else
                                <p class="mt-2 mb-0 small">
                                    <span>
                                        ${{ number_format($product->variants->first()->price / 100, 2) }}
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
                {{ $products->links() }}
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

            <!-- Filters-->
            <form method="GET" action="{{ url()->current() }}">
                <div>
                    <!-- Price Filter -->
                        <div class="py-4 widget-filter widget-filter-price border-top">
                            <a class="small text-body text-decoration-none text-secondary-hover transition-all transition-all fs-6 fw-bolder d-block collapse-icon-chevron"
                               data-bs-toggle="collapse" href="#filter-modal-price" role="button" aria-expanded="true"
                               aria-controls="filter-modal-price">
                                Price
                            </a>
                            <div id="filter-modal-price" class="collapse show">
                                <div class="d-flex justify-content-between align-items-center mt-7">
                                    <div class="input-group mb-0 me-2 border">
                                        <span class="input-group-text bg-transparent fs-7 p-2 text-muted border-0">$</span>
                                        <input type="number" name="min_price" value="{{ request('min_price') }}" step="1">
                                    </div>
                                    <div class="input-group mb-0 ms-2 border">
                                        <span class="input-group-text bg-transparent fs-7 p-2 text-muted border-0">$</span>
                                        <input type="number" name="max_price" value="{{ request('max_price') }}" step="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- / Price Filter -->

                    @if (request()->filled('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="py-4 widget-filter border-top">
                        <a class="small text-body text-decoration-none text-secondary-hover transition-all transition-all fs-6 fw-bolder d-block collapse-icon-chevron"
                           data-bs-toggle="collapse" href="#filter-modal-brands" role="button" aria-expanded="true"
                           aria-controls="filter-modal-brands">
                            Brands
                        </a>
                        <div id="filter-modal-brand" class="collapse show">
                            <div class="filter-options mt-3">
                                @foreach ($brands as $index => $brand)
                                    <div class="form-group d-inline-block mr-2 mb-2 form-check-bg form-check-custom">
                                        <input type="checkbox" name="brands[]" value="{{ $brand->id }}" class="form-check-color-input" id="filter-brands-modal-{{ $index }}"
                                            {{ is_array(request('brands')) && in_array($brand->id, request('brands')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter-brands-modal-{{ $index }}">{{ $brand->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Sizes Filter -->
                    <div class="py-4 widget-filter border-top">
                        <a class="small text-body text-decoration-none text-secondary-hover transition-all transition-all fs-6 fw-bolder d-block collapse-icon-chevron"
                           data-bs-toggle="collapse" href="#filter-modal-sizes" role="button" aria-expanded="true"
                           aria-controls="filter-modal-sizes">
                            Sizes
                        </a>
                        <div id="filter-modal-sizes" class="collapse show">
                            <div class="filter-options mt-3">
                                @foreach ($sizes as $index => $size)
                                    <div class="form-group d-inline-block mr-2 mb-2 form-check-bg form-check-custom">
                                        <input type="checkbox" name="sizes[]" value="{{ $size }}" class="form-check-bg-input" id="filter-sizes-modal-{{ $index }}"
                                            {{ is_array(request('sizes')) && in_array($size, request('sizes')) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-normal" for="filter-sizes-modal-{{ $index }}">{{ $size }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- / Sizes Filter -->

                    <!-- Colour Filter -->
                    <div class="py-4 widget-filter border-top">
                        <a class="small text-body text-decoration-none text-secondary-hover transition-all transition-all fs-6 fw-bolder d-block collapse-icon-chevron"
                           data-bs-toggle="collapse" href="#filter-modal-colour" role="button" aria-expanded="true"
                           aria-controls="filter-modal-colour">
                            Colour
                        </a>
                        <div id="filter-modal-colour" class="collapse show">
                            <div class="filter-options mt-3">
                                @foreach ($colors as $index => $color)
                                    <div class="form-group d-inline-block mr-2 mb-2 form-check-bg form-check-custom">
                                        <input type="checkbox" name="colors[]" value="{{ $color }}" class="form-check-color-input" id="filter-colours-modal-{{ $index }}"
                                            {{ is_array(request('colors')) && in_array($color, request('colors')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter-colours-modal-{{ $index }}">{{ $color }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- / Colour Filter -->
                </div>

                <div class="border-top pt-3">
                    <button type="submit" class="btn btn-dark mt-2 d-block hover-lift-sm hover-boxshadow" data-bs-dismiss="offcanvas" aria-label="Close">Done</button>
                </div>
            </form>
            <!-- / Filters-->

        </div>
    </div>
</div>
<!-- Theme JS -->
<!-- Vendor JS -->
<script src="{{ asset('/js/vendor.bundle.js') }}"></script>

<!-- Theme JS -->
<script src="{{ asset('/js/theme.bundle.js') }}"></script>

@endsection
