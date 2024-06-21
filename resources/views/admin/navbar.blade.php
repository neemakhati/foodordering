<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category">
            <span class="nav-link">Admin Navigation</span>
        </li>
        <li class="nav-item menu-items {{ request()->is('users') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/users') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">Users</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->is('foodMenu') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/foodMenu') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">Products</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->is('categoryMenu') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/categoryMenu') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">Category</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->is('orders') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/orders') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">Orders</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->is('analytics') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/analytics') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">Analytics</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->is('chart') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/chart') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">Chart</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->is('adminlogout') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/adminlogout') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">Logout</span>
            </a>
        </li>
    </ul>
</nav>
