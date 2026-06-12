@extends('layouts.app')

@section('title', 'Product')

@section('content')

<!-- Main Section-->
<section class="mt-0 ">
    <!-- Page Content Goes Here -->

    <!-- Breadcrumbs-->
    <div class="bg-dark py-6">
        <div class="container-fluid">
            <nav class="m-0" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item breadcrumb-light"><a href="#">Home</a></li>
                    <li class="breadcrumb-item breadcrumb-light"><a href="#">T-Shirts</a></li>
                    <li class="breadcrumb-item  breadcrumb-light active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>            </div>
    </div>
    <!-- / Breadcrumbs-->

    <div class="container-fluid mt-5">

        <!-- Product Top Section-->
        <div class="row g-9" data-sticky-container>
            <!-- Product Images-->
            <div class="col-12 col-md-6 col-xl-7">
                <div class="row g-3" data-aos="fade-right">
                    <div class="col-12">
                        <picture>
                            <img class="img-fluid" data-zoomable src="{{ $product->image }}" alt="HTML Bootstrap Template by Pixel Rocket">
                        </picture>
                    </div>
                </div>
            </div>
            <!-- /Product Images-->

            <!-- Product Information-->
            <div class="col-12 col-md-6 col-lg-5">
                    <div class="sticky-top top-5">
                        <div class="pb-3" data-aos="fade-in">
                            <div class="d-flex align-items-center mb-3">
                                <p class="small fw-bolder text-uppercase tracking-wider text-muted m-0 me-4"></p>
                                <div class="d-flex justify-content-start align-items-center disable-child-pointer cursor-pointer"
                                     data-pixr-scrollto
                                     data-target=".reviews">
                                    <!-- Review Stars Small-->
                                    <div class="rating position-relative d-table">
                                        <div class="position-absolute stars" style="width: 80%">
                                            <i class="ri-star-fill text-dark mr-1"></i>
                                            <i class="ri-star-fill text-dark mr-1"></i>
                                            <i class="ri-star-fill text-dark mr-1"></i>
                                            <i class="ri-star-fill text-dark mr-1"></i>
                                            <i class="ri-star-fill text-dark mr-1"></i>
                                        </div>
                                        <div class="stars">
                                            <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                            <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                            <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                            <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                            <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        </div>
                                    </div>        <small class="text-muted d-inline-block ms-2 fs-bolder">(105 reviews)</small>
                                </div>
                            </div>

                            <h1 class="mb-1 fs-2 fw-bold">{{ $product->name }}</h1>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="fs-4 m-0">${{ number_format($selectedVariant->price / 100, 2) }}</p>
                            </div>
                            <div class="border-top mt-4 mb-3 product-option">
                                <small class="text-uppercase pt-4 d-block fw-bolder">
                                    <span class="text-muted">Available Options</span>
                                </small>
                                <div class="mt-4 d-flex justify-content-start flex-wrap align-items-start">
                                    @foreach ($product->variants as $productVariant)
                                        @if ($productVariant->optionValues->isNotEmpty())
                                            <div class="form-check-option form-check-rounded">
                                                <a href="{{ route('products.show', [$product->slug, 'variant' => $productVariant->id]) }}">
                                                    <label>
                                                        <small>
                                                            {{ $productVariant->optionValues->pluck('value')->implode(' + ')}}
                                                        </small>
                                                    </label>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @if ($selectedVariant->stock > 0)
                                <button class="btn btn-dark w-100 mt-4 mb-0 hover-lift-sm hover-boxshadow add-item"
                                        name="product_variant_id"
                                        data-product-variant-id="{{ $selectedVariant->id }}">
                                    Add To Cart
                                </button>
                            @else
                                <button class="btn btn-dark w-100 mt-4 mb-0 hover-lift-sm hover-boxshadow add-item"
                                        name="product_variant_id"
                                        data-product-variant-id="{{ $selectedVariant->id }}"
                                        disabled>
                                    Product is out of stock
                                </button>
                            @endif

                            <!-- Product Highlights-->
                            <div class="my-5">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="text-center px-2">
                                            <i class="ri-24-hours-line ri-2x"></i>
                                            <small class="d-block mt-1">Next-day Delivery</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="text-center px-2">
                                            <i class="ri-secure-payment-line ri-2x"></i>
                                            <small class="d-block mt-1">Secure Checkout</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="text-center px-2">
                                            <i class="ri-service-line ri-2x"></i>
                                            <small class="d-block mt-1">Free Returns</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Product Highlights-->

                            <!-- Product Accordion -->
                            <div class="accordion" id="accordionProduct">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Product Details
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionProduct">
                                        <div class="accordion-body">
                                            <p class="m-0">
                                                {{ $product->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Details & Care
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionProduct">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex border-0 row g-0 px-0">
                                                    <span class="col-4 fw-bolder">Composition</span>
                                                    <span class="col-7 offset-1">98% Cotton, 2% elastane</span>
                                                </li>
                                                <li class="list-group-item d-flex border-0 row g-0 px-0">
                                                    <span class="col-4 fw-bolder">Care</span>
                                                    <span class="col-7 offset-1">Professional dry clean only. Do not bleach. Do not iron.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Delivery & Returns
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionProduct">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex border-0 row g-0 px-0">
                                                    <span class="col-4 fw-bolder">Delivery</span>
                                                    <span class="col-7 offset-1">Standard delivery free for orders over $99. Next day delivery $9.99</span>
                                                </li>
                                                <li class="list-group-item d-flex border-0 row g-0 px-0">
                                                    <span class="col-4 fw-bolder">Returns</span>
                                                    <span class="col-7 offset-1">30 day return period. See our <a class="text-link-border" href="#">terms & conditions.</a></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Product Accordion-->
                        </div>
                    </div>
                </div>
            <!-- / Product Information-->
        </div>
        <!-- / Product Top Section-->

        <div class="row g-0">

            <!-- Related Products-->
            <div class="col-12" data-aos="fade-up">
                <h3 class="fs-4 fw-bolder mt-7 mb-4">You May Also Like</h3>
                <!-- Swiper Latest -->
                <div class="swiper-container" data-swiper data-options='{
                        "spaceBetween": 10,
                        "loop": false,
                        "autoplay": {
                          "delay": 5000,
                          "disableOnInteraction": false
                        },
                        "navigation": {
                          "nextEl": ".swiper-next",
                          "prevEl": ".swiper-prev"
                        },
                        "breakpoints": {
                          "600": {
                            "slidesPerView": 2
                          },
                          "1024": {
                            "slidesPerView": 3
                          },
                          "1400": {
                            "slidesPerView": 4
                          }
                        }
                      }'>

                <div class="swiper-wrapper">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="swiper-slide">
                            <!-- Card Product-->
                            <div class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                <div class="card-img position-relative">
                                    <div class="card-badges">
                                        <span class="badge badge-card"><span class="f-w-2 f-h-2 bg-danger rounded-circle d-block me-1"></span> Sale</span>
                                    </div>
                                    <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i class="ri-heart-line"></i></span>
                                    <picture class="position-relative overflow-hidden d-block bg-light">
                                        <img class="w-100 h-100 img-fluid position-relative z-index-10" title="" src="{{ $relatedProduct->image }}" alt="">
                                    </picture>
                                </div>
                                @if ($relatedProduct->variants->first()->stock > 0)
                                    <div class="p-2 opacity-100" style="position: relative; z-index: 50; opacity: 1 !important; visibility: visible !important;">
                                        <button class="btn btn-quick-add w-100 add-item"
                                                name="product_variant_id"
                                                data-product-variant-id="{{ $relatedProduct->variants->first()->id }}">
                                            Add To Cart
                                        </button>
                                    </div>
                                @else
                                    <div class="p-2 opacity-100" style="position: relative; z-index: 50; opacity: 1 !important; visibility: visible !important;">
                                        <button class="btn btn-quick-add w-100 add-item"
                                                name="product_variant_id"
                                                data-product-variant-id="{{ $relatedProduct->variants->first()->id }}"
                                                disabled>
                                            Add To Cart
                                        </button>
                                    </div>
                                @endif
                                <div class="card-body px-0">
                                    <a class="text-decoration-none link-cover" href="{{ route('products.show', [$relatedProduct->slug, 'productVariant' => $relatedProduct->variants->first()?->id]) }}">
                                        {{ $relatedProduct->name }}
                                    </a>
                                    <small class="text-muted d-block">
                                        {{ $relatedProduct->variants->first()->optionValues->pluck('value')->implode(' + ') }}
                                    </small>
                                    @if ($relatedProduct->variants->first()->discount_price)
                                        <p class="mt-2 mb-0 small">
                                            <s class="text-muted">
                                                ${{ number_format($relatedProduct->variants->first()->price / 100, 2) }}
                                            </s>
                                            <span style="color: red">
                                                ${{ number_format($relatedProduct->variants->first()->discount_price / 100, 2) }}
                                            </span>
                                        </p>
                                    @else
                                        <p class="mt-2 mb-0 small">
                                            <span>
                                                ${{ number_format($relatedProduct->variants->first()->price / 100, 2) }}
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <!--/ Card Product-->
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Add Arrows -->
            <div
                class="swiper-prev top-50  start-0 z-index-30 cursor-pointer transition-all bg-white px-3 py-4 position-absolute z-index-30 top-50 start-0 mt-n8 d-flex justify-content-center align-items-center opacity-50-hover">
                <i class="ri-arrow-left-s-line ri-lg"></i></div>
            <div
                class="swiper-next top-50 end-0 z-index-30 cursor-pointer transition-all bg-white px-3 py-4 position-absolute z-index-30 top-50 end-0 mt-n8 d-flex justify-content-center align-items-center opacity-50-hover">
                <i class="ri-arrow-right-s-line ri-lg"></i></div>


            <!-- / Swiper Latest--> </div>
            <!-- / Related Products-->

            <!-- Reviews-->
            <div class="col-12" data-aos="fade-up">
                <h3 class="fs-4 fw-bolder mt-7 mb-4 reviews">Reviews</h3>

                <!-- Review Summary-->
                <div class="bg-light p-5 justify-content-between d-flex flex-column flex-lg-row">
                    <div class="d-flex flex-column align-items-center mb-4 mb-lg-0">
                        <div class="bg-dark text-white f-w-24 f-h-24 d-flex rounded-circle align-items-center justify-content-center fs-2 fw-bold mb-3">
                            {{ number_format($product->avg_rating, 2) }}
                        </div>

                        @auth
                            <a href="{{ route('reviews.show', $product->slug) }}" class="btn btn-outline-dark btn-sm mt-5 align-self-center py-3 px-4 border-2">
                                Write a review
                            </a>
                        @endauth

                        @guest
                            <a href="{{ route('auth.login') }}" class="btn btn-outline-dark btn-sm mt-5 align-self-center py-3 px-4 border-2 alert-link">
                                Sign in to write a review
                            </a>
                        @endguest

                    </div>
                    <div class="d-flex flex-grow-1 flex-column ms-lg-8">
                        <div class="d-flex align-items-center justify-content-start mb-2">
                            <div class="f-w-20">
                                <!-- Review Stars Small-->
                                <div class="rating position-relative d-table">
                                    <div class="position-absolute stars" style="width: 100%">
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                    </div>
                                    <div class="stars">
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-bold small d-block f-w-4 text-end">{{ $product->stars_5 }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-start mb-2">
                            <div class="f-w-20">
                                <!-- Review Stars Small-->
                                <div class="rating position-relative d-table">
                                    <div class="position-absolute stars" style="width: 80%">
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                    </div>
                                    <div class="stars">
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-bold small d-block f-w-4 text-end">{{ $product->stars_4 }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-start mb-2">
                            <div class="f-w-20">
                                <!-- Review Stars Small-->
                                <div class="rating position-relative d-table">
                                    <div class="position-absolute stars" style="width: 60%">
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                    </div>
                                    <div class="stars">
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-bold small d-block f-w-4 text-end">{{ $product->stars_3 }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-start mb-2">
                            <div class="f-w-20">
                                <!-- Review Stars Small-->
                                <div class="rating position-relative d-table">
                                    <div class="position-absolute stars" style="width: 40%">
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                    </div>
                                    <div class="stars">
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-bold small d-block f-w-4 text-end">{{ $product->stars_2 }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-start mb-2">
                            <div class="f-w-20">
                                <!-- Review Stars Small-->
                                <div class="rating position-relative d-table">
                                    <div class="position-absolute stars" style="width: 20%">
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                    </div>
                                    <div class="stars">
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-bold small d-block f-w-4 text-end">{{ $product->stars_1 }}</span>
                        </div>
                        <p class="mt-3 mb-0 d-flex align-items-start"><i class="ri-chat-voice-line me-2"></i>{{ $product->total_reviews }} customers have reviewed this product</p>
                    </div>
                </div>
                <!-- / Review Summary-->

                <!-- Reviews-->
                @foreach ($reviews as $review)
                    <div class="row g-6 g-md-8 g-lg-10 my-3">
                        <div class="col-12 col-lg-6 col-xxl-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- Review Stars Small-->
                                <div class="rating position-relative d-table">
                                    <div class="position-absolute stars" style="width: 80%">
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                    </div>
                                    <div class="stars">
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    </div>
                                </div>
                                <div class="text-muted small">{{ $review->created_at }} by {{ $review->user->name }}</div>
                            </div>
                            <p class="fs-7">{{ $review->comment }}</p>
                        </div>
                    </div>
                @endforeach
                <!-- / Reviews-->

                <div class="d-flex flex-column f-w-44 mx-auto my-5 text-center">
                    <div class="mt-5 d-flex justify-content-around">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
            <!-- / Reviews-->
        </div>

    </div>

    <!-- /Page Content -->
</section>
<!-- / Main Section-->

<!-- Theme JS -->
<!-- Vendor JS -->
<script src="{{ asset('/js/vendor.bundle.js') }}"></script>

<!-- Theme JS -->
<script src="{{ asset('/js/theme.bundle.js') }}"></script>

@endsection
