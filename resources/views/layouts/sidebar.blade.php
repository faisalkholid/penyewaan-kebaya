<nav class="col-md-2 d-none d-md-block bg-white sidebar shadow-sm p-0" style="min-height:100vh;">
    <div class="sidebar-sticky pt-4 px-3 d-flex flex-column align-items-start h-100">
        <div class="w-100 mb-4 px-2">
            <span class="fs-4 fw-bold text-primary">Yanti Kebaya</span>
        </div>
        <ul class="nav flex-column gap-2 w-100">
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded {{ request()->routeIs('home') ? 'active bg-primary text-white' : 'text-dark' }} d-flex align-items-center gap-2 sidebar-link" href="{{ route('home') }}">
                    <i class="bi bi-clipboard-data fs-5"></i> <span class="fw-semibold">Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded {{ request()->routeIs('rentals.*') ? 'active bg-primary text-white' : 'text-dark' }} d-flex align-items-center gap-2 sidebar-link" href="{{ route('rentals.index') }}">
                    <i class="bi bi-people-fill fs-5"></i> <span class="fw-semibold">Daftar Penyewa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded {{ request()->routeIs('dresses.*') ? 'active bg-primary text-white' : 'text-dark' }} d-flex align-items-center gap-2 sidebar-link" href="{{ route('dresses.index') }}">
                    <i class="bi bi-person-lines-fill fs-5"></i> <span class="fw-semibold">Daftar Kebaya</span>
                </a>
            </li>
        </ul>
        <div class="mt-auto w-100 px-2 pb-4 small text-muted text-center" style="font-size: 0.95rem;">
            &copy; {{ date('Y') }} Yanti Kebaya
        </div>
    </div>
</nav>
<style>
    .sidebar-link.active, .sidebar-link:hover {
        background: #0d6efd !important;
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(13,110,253,0.08);
        transition: background 0.2s, color 0.2s;
    }
    .sidebar-link {
        transition: background 0.2s, color 0.2s;
    }
</style>
