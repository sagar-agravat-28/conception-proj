<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item  @if (Request::is('admin/products/*') || Request::is('admin/products')) active @endif">
        <a class="nav-link py-1" href="{{route('products.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Products</span></a>
    </li>
    <li class="nav-item  @if (Request::is('admin/categories/*') || Request::is('admin/categories')) active @endif">
        <a class="nav-link py-1" href="{{route('categories.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Categories</span></a>
    </li>
    <li class="nav-item  @if (Request::is('admin/subcategories/*') || Request::is('admin/subcategories')) active @endif">
        <a class="nav-link py-1" href="{{route('subcategories.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Sub Categories</span></a>
    </li>
    <li class="nav-item  @if (Request::is('admin/orders/*') || Request::is('admin/orders')) active @endif">
        <a class="nav-link py-1" href="{{route('orders.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Orders</span></a>
    </li>
    <li class="nav-item  @if (Request::is('admin/profile/*') || Request::is('admin/profile')) active @endif">
        <a class="nav-link py-1" href="{{route('profile.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Profile</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
