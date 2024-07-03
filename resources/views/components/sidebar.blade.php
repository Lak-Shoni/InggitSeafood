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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pakets.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pakets.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>
                            Kelola Paket
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                        {{-- <i class="nav-icon fas fa-copy"></i> --}}
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Daftar Pesanan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.bahan_masakan.index') }}"
                        class="nav-link {{ request()->routeIs('admin.bahan_masakan.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fish"></i> 
                        <p>
                            Bahan Masakan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.inventories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.inventories.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>
                            Inventaris
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.keuangan.index') }}" class="nav-link">                  
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Keuangan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="sidebar-logout-btn">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn = document.getElementById('sidebar-logout-btn');
        const logoutForm = document.getElementById('sidebar-logout-form');

        logoutBtn.addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Logout?',
                text: "Apakah Anda yakin ingin logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    logoutForm.submit();
                }
            });
        });
    });
</script>
