<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Category Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile/security.css') }}">
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link" href="{{ route('admin.index') }}">Back to Admin</a>
        <a class="nav-link active" href="{{ route('admin.categories.edit', $category->id) }}">Edit Category</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div style="display: inline">
                    <div class="card-header">Edit Category</div>
                </div>
                <div class="card-body">
                    @include('errors.form-errors')
                    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $category->name }}" id="name" placeholder="Enter category name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="parent">Parent</label>
                            <input type="text" class="form-control" name="parent" value="{{ $category->parent?->name }}" id="parent" placeholder="Enter parent category">
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
