<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Order Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile/index.css') }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<div class="container-xl px-4 mt-4">
    <nav class="nav nav-borders">
        <a class="nav-link" href="{{ route('admin.index') }}">Back to Admin</a>
        <a class="nav-link active" href="{{ route('admin.orders.create') }}">Create Order</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">Order Details</div>
                <div class="card-body">
                    @include('errors.form-errors')
                    <form method="POST" action="{{ route('admin.orders.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1" for="category">Status</label>
                            <select name="status">
                                <option value="">--- Select ---</option>
                                @foreach (\App\Enums\OrderStatus::cases() as $status)
                                    <option value="{{ $status->value }}">
                                        {{ ucfirst($status->value) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" value="{{ old('first_name') }}" placeholder="Enter customer first name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" value="{{ old('last_name') }}" placeholder="Enter customer last name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter customer email">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter customer phone">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="Enter customer city">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Enter customer address">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="address">Notes</label>
                            <input type="text" class="form-control" id="notes" name="notes" value="{{ old('notes') }}" placeholder="Enter customer notes">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Product Variants</label>
                            <select name="product_variant_ids[]" multiple>
                                @foreach ($productVariants as $productVariant)
                                    <option value="{{ $productVariant->id }}">
                                        {{ $productVariant->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
