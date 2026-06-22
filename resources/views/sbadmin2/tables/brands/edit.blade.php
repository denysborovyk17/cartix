<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Brand Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile/security.css') }}">
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link" href="{{ route('admin.index') }}">Back to Admin</a>
        <a class="nav-link active" href="{{ route('admin.brands.edit', $brand->id) }}">Edit Brand</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div style="display: inline">
                    <div class="card-header">Edit Brand</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $brand->name }}" id="name" placeholder="Enter brand name">
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            @if ($brand->image)
                                <img class="img-account-profile rounded-circle mb-2" src="{{ $brand->image_url }}" alt="">
                                Delete Image <input type="checkbox" name="remove_image" value="1">
                            @endif
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
