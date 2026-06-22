<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Page</title>
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
            <a class="nav-link active" href="{{ route('admin.profile') }}">Profile</a>
            <a class="nav-link" href="{{ route('admin.profile.security') }}">Security</a>
        </nav>
        <hr class="mt-0 mb-4">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xl-4">
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Profile Picture</div>
                        <div class="card-body text-center">
                            <img class="img-account-profile rounded-circle mb-2" src="{{ auth()->user()->avatar_path_url }}" alt="">
                            <input type="file" class="btn btn-primary" name="avatar_path" accept="image/*">
                            @if (auth()->user()->avatar_path)
                                Delete Avatar <input type="checkbox" name="remove_avatar_path" value="1">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">Account Details</div>
                        <div class="card-body">
                            @include('errors.form-errors')
                            <div class="mb-3">
                                <label class="small mb-1" for="inputFirstName">Name</label>
                                <input type="text" class="form-control" id="inputFirstName" name="name" value="{{ auth()->user()->name }}" placeholder="Enter your name">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                <input type="email" class="form-control" id="inputEmailAddress" name="email" value="{{ auth()->user()->email }}" placeholder="Enter your email address">
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                    <input type="tel" class="form-control" id="inputPhone" name="phone" value="{{ auth()->user()->phone }}" placeholder="Enter your phone number">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputBirthday">Birthday</label>
                                    <input type="date" class="form-control" id="inputBirthday" name="birthday" value="{{ auth()->user()->birthday?->format('Y-m-d') }}">
                                </div>
                            </div>

                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
