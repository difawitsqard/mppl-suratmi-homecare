<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        @if(auth()->user()->hasRole(['admin', 'superadmin']))
            <x-dashboard.sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid"
                                      :route="['dashboard']"/>
            <li class="nav-heading">Menu</li>

            <x-dashboard.sidebar-item name="Manajemen Pengguna" icon="bi bi-people" :route="['dashboard.user-management.*']">
                <x-dashboard.sidebar-sub-item name="All Roles" :link="route('dashboard.user-management.index')" :route="['dashboard.user-management.index']" />
                @foreach ($userRoles as $roleName)
                    <x-dashboard.sidebar-sub-item name="Role {{ ucwords($roleName) }}" :link="route('dashboard.user-management.role', ['role' => $roleName])" :route="['dashboard/user-management/role/'. $roleName]"/>
                @endforeach
            </x-dashboard.sidebar-item>

            <x-dashboard.sidebar-item name="Manajemen layanan" :link="route('dashboard.service-management.index')"
                                      icon="bi bi-grid-fill"
                                      :route="['dashboard.service-management.index']"/>
            <x-dashboard.sidebar-item name="Manajemen FAQ" :link="route('dashboard.faq-management.index')"
                                      icon="bi bi-list-check"
                                      :route="['dashboard.faq-management.index']"/>
            <x-dashboard.sidebar-item name="Manajemen Galeri" :link="route('dashboard.gallery-management.index')"
                                      icon="bi bi-image" :route="['dashboard.gallery-management.index']"/>

        @endif

        @if(auth()->user()->hasRole('customer'))
            <x-dashboard.sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid"
                                      :route="['dashboard']"/>
            <li class="nav-heading">Menu</li>
            <x-dashboard.sidebar-item name="Pemesanan" :link="route('dashboard.order-service.index')" icon="bi bi-chat-left"
                                      :route="['dashboard.order-service.index']"/>
        @endif



        <li class="nav-heading">Pengaturan</li>
        <x-dashboard.sidebar-item name="Pengaturan Akun" :link="route('profile.show')" icon="bi bi-gear"
                                  :route="['profile.show']"/>

        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <li class="nav-item">
                <a class="nav-link collapsed" href="https://suratmi-homecare.com/logout"
                   onclick="event.preventDefault();this.closest('form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </form>
    </ul>
</aside>
<!-- End Sidebar-->
