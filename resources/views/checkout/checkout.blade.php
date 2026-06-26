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
                            <form method="POST" action="{{ route('checkout.store') }}">
                                @csrf
                                <div class="row">
                                  <!-- First Name-->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="firstNameBilling" class="form-label">First name</label>
                                            <input type="text" class="form-control" name="first_name" id="firstNameBilling" placeholder="">
                                        </div>
                                    </div>

                                    <!-- Last Name-->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="lastNameBilling" class="form-label">Last name</label>
                                            <input type="text" class="form-control" name="last_name" id="lastNameBilling" placeholder="" value="">
                                        </div>
                                    </div>

                                    <!-- Email-->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="example@mail.com">
                                        </div>
                                    </div>

                                    <!-- Phone-->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="+380 00 000 00 00">
                                        </div>
                                    </div>
                                </div>

                                <h3 class="fs-5 mt-5 fw-bolder mb-4 border-bottom pb-4">Shipping Address</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="Enter your city">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Enter your address">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="notes" class="form-label">Notes</label>
                                            <input type="text" class="form-control" name="notes" id="notes" placeholder="Your notes">
                                        </div>
                                    </div>

                                    <div class="pt-5 mt-5 pb-5 border-top d-flex justify-content-md-end align-items-center">
                                        <button type="submit" class="btn btn-dark w-100 w-md-auto">Proceed to Shipping</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <div class="col-12 col-lg-5 bg-light pt-lg-10 aside-checkout pb-5 pb-lg-0 my-5 my-lg-0">
                        <div class="p-4 py-lg-0 pe-lg-0 ps-lg-5">
                        @foreach ($cart->items as $cartItem)
                            <div class="pb-3">
                                <div class="row mx-0 py-4 g-0 border-bottom">
                                    <div class="col-2 position-relative">
                                        <picture class="d-block border">
                                            <img class="img-fluid" src="{{ $cartItem->productVariant->product->image_url }}" alt="HTML Bootstrap Template by Pixel Rocket">
                                        </picture>
                                    </div>
                                    <div class="col-9 offset-1">
                                        <div>
                                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                                {{ $cartItem->productVariant->product->name }}
                                            </h6>
                                            <span class="d-block text-muted fw-bolder text-uppercase fs-9 cart-item-quantity">
                                                Quantity ({{ $cartItem->quantity }})
                                            </span>
                                            <span class="d-block text-muted fw-bolder text-uppercase fs-9">
                                                {{ $cartItem->productVariant->optionValues->pluck('value')->implode(' + ') }}
                                            </span>
                                        </div>
                                        @if ($cartItem->productVariant->discount_price)
                                            <p class="fw-bolder text-end text-muted m-0">
                                                <s class="text-muted">
                                                    ${{ number_format($cartItem->productVariant->price / 100, 2) }}
                                                </s>
                                                <span style="color: red;">
                                                    ${{ number_format($cartItem->productVariant->discount_price * $cartItem->quantity / 100, 2) }}
                                                </span>
                                            </p>
                                        @else
                                            <p class="fw-bolder text-end text-muted m-0">
                                                ${{ number_format($cartItem->productVariant->price * $cartItem->quantity / 100, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                        @endforeach
                        </div>
                        <div class="py-4 border-bottom">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="m-0 fw-bold fs-5">Grand Total</p>
                                </div>
                                <p class="m-0 fs-5 fw-bold">
                                    ${{ number_format($cartTotal / 100, 2) }}
                                </p>
                            </div>
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
