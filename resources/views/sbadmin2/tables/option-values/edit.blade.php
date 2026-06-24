<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Option Value Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile/security.css') }}">
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link" href="{{ route('admin.index') }}">Back to Admin</a>
        <a class="nav-link active" href="{{ route('admin.option-values.edit', $optionValue->id) }}">Edit Option Value</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div style="display: inline">
                    <div class="card-header">Edit Option Value</div>
                </div>
                <div class="card-body">
                    @include('errors.form-errors')
                    <form method="POST" action="{{ route('admin.option-values.update', $optionValue->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="small mb-1" for="optionName">Option Name</label>
                            <select name="option_name">
                                @foreach ($options as $option)
                                    <option value="{{ $option->name }}" {{ old('name', $optionValue->option->name) === $option->name ? 'selected' : '' }}>
                                        {{ ucfirst($option->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="value">Value</label>
                            <input type="text" class="form-control" name="value" value="{{ $optionValue->value }}" id="value" placeholder="Enter option value">
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
