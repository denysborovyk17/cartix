<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile/security.css') }}">
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link" href="{{ route('admin.index') }}">Back to Admin</a>
        <a class="nav-link active" href="{{ route('admin.products.edit', $product->id) }}">Edit Product</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div style="display: inline">
                    <div class="card-header">Edit Product</div>
                </div>
                <div class="card-body">
                    @include('errors.form-errors')
                    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="small mb-1" for="category">Category</label>
                            <select name="category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ old('category', $product->category->name) === $category->name ? 'selected' : '' }}>
                                        {{ ucfirst($category->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="brand">Brand</label>
                            <select name="brand">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->name }}"
                                        {{ old('brand', $product->brand->name) === $brand->name ? 'selected' : '' }}>
                                        {{ ucfirst($brand->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" placeholder="Enter product name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ $product->description }}" placeholder="Enter product description">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="avatarPath">Image</label>
                            <input type="file" class="form-control" name="image" id="avatarPath" accept="image/*">
                            @if ($product->image)
                                <img class="img-account-profile rounded-circle mb-2" src="{{ $product->image_url }}" alt="">
                                Delete Image <input type="checkbox" name="remove_image" value="1">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="isActive">Is Active</label>
                            <input type="checkbox" name="is_active" id="isActive" value="1"
                                {{ $product->is_active ? 'checked' : '' }}>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="existingProductName">Existing Products</label>
                            <select name="existing_product_name">
                                <option value="">{{ $product->name ?? 'NONE' }}</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->name }}
                                        {{ old('existing_product_name') }}">
                                        {{ ucfirst($product->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ $product->variants->first()->price }}" placeholder="Enter product price">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="discountPrice">Discount Price</label>
                            <input type="number" class="form-control" id="discountPrice" name="discount_price" value="{{ $product->variants->first()->discount_price }}" placeholder="Enter product discount price">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="currency">Currency</label>
                            <select name="currency">
                                @foreach (['UAH', 'USD', 'EUR'] as $currency)
                                    <option value="{{ $currency }}"
                                        {{ old('currency', $product->variants->first()->currency) === $currency ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->variants->first()->stock }}" placeholder="Enter product stock">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="options">Options</label>
                            <select name="options[]" multiple>
                                <option value="[]">--- Select ---</option>
                                @foreach ($options as $option)
                                    <option value="{{ $option->name }}"
                                        {{ collect(old('options', $product->options->pluck('name')))->contains($option->name) ? 'selected' : '' }}>
                                        {{ ucfirst($option->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="options">Option Values</label>
                            <select name="option_values[]" multiple>
                                <option value="[]">--- Select ---</option>
                                @foreach ($optionValues as $optionValue)
                                    <option value="{{ $optionValue->value }}"
                                        {{ collect(old('option_values', $product->variants->first()->optionValues->pluck('value')))->contains($optionValue->value) ? 'selected' : '' }}>
                                        {{ ucfirst($optionValue->value) }}
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
