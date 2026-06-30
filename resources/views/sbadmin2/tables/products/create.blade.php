<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Product Page</title>
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
        <a class="nav-link active" href="{{ route('admin.categories.create') }}">Create Product</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">Product Details</div>
                <div class="card-body">
                    @include('errors.form-errors')
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1" for="category">Category</label>
                            <select name="category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}">
                                        {{ ucfirst($category->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="brand">Brand</label>
                            <select name="brand">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->name }}">
                                        {{ ucfirst($brand->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter product name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" placeholder="Enter product description">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="image">Image</label>
                            <input type="file" class="form-control" name="image" value="{{ old('image') }}" id="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="isActive">Is Active</label>
                            <input type="checkbox" name="is_active" id="isActive" value="1">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="existingProductName">Existing Products</label>
                            <select name="existing_product_name">
                                <option value="">NONE</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->name}} {{ old('existing_product_name') }}">
                                        {{ ucfirst($product->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="Enter product price">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="discountPrice">Discount Price</label>
                            <input type="number" class="form-control" id="discountPrice" name="discount_price" value="{{ old('discount_price') }}" placeholder="Enter product discount price">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="currency">Currency</label>
                            <select name="currency">
                                <option value="UAH">UAH</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" placeholder="Enter product stock">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="options">Options</label>
                            <select name="options[]" multiple>
                                <option value="">--- Select ---</option>
                                @foreach ($options as $option)
                                    <option value="{{ $option->name}} {{ old('options') }}">
                                        {{ ucfirst($option->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="options">Option Values</label>
                            <select name="option_values[]" multiple>
                                <option value="">--- Select ---</option>
                                @foreach ($optionValues as $optionValue)
                                    <option value="{{ $optionValue->value }} {{ old('option_values') }}">
                                        {{ ucfirst($optionValue->value) }}
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
