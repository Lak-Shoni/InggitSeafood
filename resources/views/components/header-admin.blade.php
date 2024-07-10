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
        </div>
    </ul>
</nav>
<!-- /.navbar -->
