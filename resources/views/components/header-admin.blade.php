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
    <ul class="navbar-nav">
        <!-- Breadcrumb on the left -->
        <li class="nav-item">
            @include('components.breadcrumb')
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Notification Icon on the right -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if ($unreadNotificationsCount > 0)
                    <span class="badge badge-warning navbar-badge">{{ $unreadNotificationsCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach ($notifications as $notification)
                    <a href="#" class="dropdown-item">
                        <!-- Notification Start -->
                        <div class="media">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Pesanan Baru
                                </h3>
                                <p class="text-sm">Pesanan ID: {{ $notification->order_code }}</p>
                            </div>
                        </div>
                        <!-- Notification End -->
                    </a>
                @endforeach
            </div>
        </li>
    </ul>
</nav>

<!-- /.navbar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Contoh AJAX untuk mendapatkan notifikasi baru setiap beberapa detik
        setInterval(function() {
            fetch('/get-notifications')
                .then(response => response.json())
                .then(data => {
                    const notificationDropdown = document.querySelector('.dropdown-menu');
                    notificationDropdown.innerHTML = '';
                    data.notifications.forEach(notification => {
                        notificationDropdown.innerHTML += `
                            <a href="#" class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Pesanan Baru
                                        </h3>
                                        <p class="text-sm">Pesanan ID: ${notification.order_id}</p>
                                    </div>
                                </div>
                            </a>
                        `;
                    });

                    const badge = document.querySelector('.navbar-badge');
                    badge.textContent = data.unreadNotificationsCount;
                });
        }, 30000); // Update setiap 30 detik
    });
</script>
