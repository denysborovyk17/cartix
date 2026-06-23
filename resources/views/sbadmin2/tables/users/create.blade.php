<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create User Page</title>
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
        <a class="nav-link active" href="{{ route('admin.users.create') }}">Create User</a>
    </nav>
    <hr class="mt-0 mb-4">
    @include('errors.form-errors')
    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">User Avatar</div>
                    <div class="card-body text-center">
                        <input type="file" class="btn btn-primary" name="avatar_path" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">User Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter user name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input type="email" class="form-control" id="inputEmailAddress" name="email" placeholder="Enter user email address">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter user password">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="passwordConfirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="passwordConfirmation" name="password_confirmation" placeholder="Confirm user password">
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">Phone number</label>
                                <input type="tel" class="form-control" id="inputPhone" name="phone" placeholder="Enter user phone number">
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputBirthday">Birthday</label>
                                <input type="date" class="form-control" id="inputBirthday" name="birthday">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="role">Role</label>
                            <input type="text" class="form-control" id="role" name="role" placeholder="Enter user role">
                        </div>

                        <button class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
