<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('img/logo-inggit.png') }}" alt="AdminLTE Logo" class="brand-image">
    <span class="brand-text font-weight-light"><br></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Kelola Menu
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Daftar Pesanan
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">6</span>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.bahan_masakan.index') }}" class="nav-link {{ request()->routeIs('admin.bahan_masakan.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Bahan Masakan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.inventories.index') }}" class="nav-link {{ request()->routeIs('admin.inventories.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tree"></i>
            <p>
              Inventaris
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Keuangan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
