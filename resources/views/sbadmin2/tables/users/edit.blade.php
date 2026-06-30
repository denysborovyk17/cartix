<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile/security.css') }}">
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link" href="{{ route('admin.index') }}">Back to Admin</a>
        <a class="nav-link active" href="{{ route('admin.users.edit', $user->id) }}">Edit User</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div style="display: inline">
                    <div class="card-header">Edit User</div>
                </div>
                <div class="card-body">
                    @include('errors.form-errors')
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" id="name" placeholder="Enter user name">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input type="email" class="form-control" id="inputEmailAddress" name="email" value="{{ $user->email }}" placeholder="Enter user email address">
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
                                <input type="tel" class="form-control" id="inputPhone" name="phone" value="{{ $user->phone }}" placeholder="Enter user phone number">
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputBirthday">Birthday</label>
                                <input type="date" class="form-control" id="inputBirthday" name="birthday" value="{{ $user->birthday?->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="avatarPath">Image</label>
                            <input type="file" class="form-control" name="avatar_path" id="avatarPath" accept="image/*">
                            @if ($user->avatar_path)
                                <img class="img-account-profile rounded-circle mb-2" src="{{ $user->avatar_path_url }}" alt="">
                                Delete Avatar <input type="checkbox" name="remove_avatar_path" value="1">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="role">Role</label>
                            <select name="role">
                                @foreach (\App\Enums\UserRole::cases() as $role)
                                    <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>
                                        {{ ucfirst($role->value) }}
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
