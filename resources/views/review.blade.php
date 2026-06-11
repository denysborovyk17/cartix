<!doctype html>
<html lang="en">

<!-- Head -->
<head>
    <!-- Page Meta Tags-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- Custom Google Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600&family=Roboto:wght@300;400;700&display=auto"
          rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/css/libs.bundle.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="/css/theme.bundle.css" />

    <!-- Fix for custom scrollbar if JS is disabled-->
    <noscript>
        <style>
            /**
                * Reinstate scrolling for non-JS clients
                */
            .simplebar-content-wrapper {
                overflow: auto;
            }
        </style>
    </noscript>

    <!-- Page Title -->
    <title>Checkout Page</title>

</head>
<body class="">

<!-- Main Section-->
<section class="mt-0  vh-lg-100">
    <!-- Page Content Goes Here -->
    <div class="container">
        <div class="row g-0 vh-lg-100">
            <div class="col-lg-7 pt-5 pt-lg-10">
                <div class="pe-lg-5">
                    <!-- Logo-->
                    <a class="navbar-brand fw-bold fs-3 flex-shrink-0 mx-0 px-0" href="{{ route('index') }}">
                        <div class="d-flex align-items-center">
                            <svg class="f-w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 77.53 72.26"><path d="M10.43,54.2h0L0,36.13,10.43,18.06,20.86,0H41.72L10.43,54.2Zm67.1-7.83L73,54.2,68.49,62,45,48.47,31.29,72.26H20.86l-5.22-9L52.15,0H62.58l5.21,9L54.06,32.82,77.53,46.37Z" fill="currentColor" fill-rule="evenodd"/></svg>
                        </div>
                    </a>
                    <!-- / Logo-->
                    <div class="mt-5">
                        <!-- Checkout Panel Information-->
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-4">
                            <h3 class="fs-5 fw-bolder m-0 lh-1">Contact Information</h3>
                        </div>

                        @include('errors.form-errors')
                        <form method="POST" action="{{ route('reviews.store', $product->slug) }}">
                            @csrf
                            <div class="row">
                                <!-- Comment -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="comment" class="form-label">Comment</label>
                                        <input type="text" class="form-control" name="comment" id="comment" placeholder="Your comment...">
                                    </div>
                                </div>
                            <!-- Rating -->
                            <div class="col-sm-6">
                                <select class="form-group" name="rating">
                                    <option value="">Rating</option>
                                    <option class="form-control" value="5">★★★★★</option>
                                    <option class="form-control" value="4">★★★★</option>
                                    <option class="form-control" value="3">★★★</option>
                                    <option class="form-control" value="2">★★</option>
                                    <option class="form-control" value="1">★</option>
                                </select>
                            </div>

                            <div class="pt-5 mt-5 pb-5 border-top d-flex flex-column flex-md-row justify-content-between align-items-center">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn ps-md-0 btn-link fw-bolder w-100 w-md-auto mb-2 mb-md-0">
                                    Back to product page
                                </a>
                                <button type="submit" class="btn btn-dark w-100 w-md-auto">Write a review</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
</body>

</html>
