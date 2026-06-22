<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Tables
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Users Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.brands.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Brands Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.categories.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Categories Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.payments.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Payments Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.orders.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Orders Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.reviews.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Reviews Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.carts.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Carts Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.product-variants.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Product Variants Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.wishlists.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Wishlist Items Table</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>
