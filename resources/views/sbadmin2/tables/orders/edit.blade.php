<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Order Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile/security.css') }}">
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link" href="{{ route('admin.index') }}">Back to Admin</a>
        <a class="nav-link active" href="{{ route('admin.orders.edit', $order->id) }}">Edit Order</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div style="display: inline">
                    <div class="card-header">Edit Order</div>
                </div>
                <div class="card-body">
                    @include('errors.form-errors')
                    <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="small mb-1">Status</label>
                            <select name="status">
                                @foreach (\App\Enums\OrderStatus::cases() as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $order->status) === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status->value) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" value="{{ $order->first_name }}" placeholder="Enter customer first name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" value="{{ $order->last_name }}" placeholder="Enter customer last name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $order->email }}" placeholder="Enter customer email">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $order->phone }}" placeholder="Enter customer phone">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $order->city }}" placeholder="Enter customer city">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $order->address }}" placeholder="Enter customer address">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="address">Notes</label>
                            <input type="text" class="form-control" id="notes" name="notes" value="{{ $order->notes }}" placeholder="Enter customer notes">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Product Variants</label>
                            <select name="product_variant_ids[]" multiple>
                                <option value="">--- Select ---</option>
                                @foreach ($productVariants as $productVariant)
                                    <option value="{{ $productVariant->id }}"
                                        {{ collect(old('product_variant_ids', $order->items->pluck('product_variant_id')))->contains($productVariant->id) ? 'selected' : '' }}>
                                        {{ $productVariant->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
