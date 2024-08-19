<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <x-dashboard.sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid" :route="['dashboard']" />
        <li class="nav-heading">Menu</li>

        @if (auth()->user()->hasRole(['admin']))
            <x-dashboard.sidebar-item name="Manajemen Pesanan" :link="route('dashboard.order-management.index')" icon="bi bi-chat-right-text"
                :route="['dashboard.order-management.index']" />

            <x-dashboard.sidebar-item name="Manajemen Pengguna" icon="bi bi-people" :route="['dashboard.user-management.*']">
                <x-dashboard.sidebar-sub-item name="All Roles" :link="route('dashboard.user-management.index')" :route="['dashboard.user-management.index']" />
                @foreach ($userRoles as $roleName)
                    <x-dashboard.sidebar-sub-item name="Role {{ ucwords($roleName) }}" :link="route('dashboard.user-management.role', ['role' => $roleName])"
                        :route="['dashboard/user-management/role/' . $roleName]" />
                @endforeach
            </x-dashboard.sidebar-item>

            <x-dashboard.sidebar-item name="Manajemen layanan" :link="route('dashboard.service-management.index')" icon="bi bi-grid-fill"
                :route="['dashboard.service-management.index']" />
            <x-dashboard.sidebar-item name="Manajemen FAQ" :link="route('dashboard.faq-management.index')" icon="bi bi-list-check"
                :route="['dashboard.faq-management.index']" />
            <x-dashboard.sidebar-item name="Manajemen Galeri" :link="route('dashboard.gallery-management.index')" icon="bi bi-image"
                :route="['dashboard.gallery-management.index']" />

            <x-dashboard.sidebar-item name="Ulasan Pelanggan" :link="route('dashboard.testimonial-management.index')" icon="bi bi-star" :route="['dashboard.testimonial-management.index']" />
            <li class="nav-heading">Pengaturan</li>
            <x-dashboard.sidebar-item name="Informasi Perusahaan" :link="route('dashboard.company-info.index')" icon="bi bi-buildings"
                :route="['dashboard.company-info.index']" />
        @endif

        @if (auth()->user()->hasRole('customer'))
            <x-dashboard.sidebar-item name="Pemesanan" :link="route('dashboard.order-service.index')" icon="bi bi-chat-left" :route="['dashboard.order-service.index']" />
        @endif

        <li class="nav-heading">Akun</li>
        <x-dashboard.sidebar-item name="Pengaturan Akun" :link="route('profile.show')" icon="bi bi-gear" :route="['profile.show']" />

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="modal" data-bs-target="#LogoutModal">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </a>
        </li>

    </ul>
</aside>
<!-- End Sidebar-->
