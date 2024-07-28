<style>
    /* Custom styles for breadcrumb in navbar */
    .navbar .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .navbar .breadcrumb-item+.breadcrumb-item::before {
        content: '>';
        color: #6c757d;
        padding: 0 0.5rem;
    }

    .navbar .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
    }

    .navbar .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .navbar .breadcrumb-item.active {
        color: #6c757d;
    }
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav m-2">
        <div class="row">
            <div class="col">
                @include('components.breadcrumb')
            </div>
            <a class="nav-link" data-toggle="dropdown" href="#">
                <li class="nav-item dropdown">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </div>

        </li>

    </ul>
</nav>
<!-- /.navbar -->
