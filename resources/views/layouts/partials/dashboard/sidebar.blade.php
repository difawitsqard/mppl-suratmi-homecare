    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <x-dashboard.sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid" :route="['dashboard']" />
            <li class="nav-heading">Menu</li>
            <x-dashboard.sidebar-item name="Item Sub" icon="bi bi-person" :route="['dashboard/admin', 'dashboard/admin/*']">
                <x-dashboard.sidebar-sub-item name="Sub Item" :link="route('dashboard')" :route="['dashboard']" />
            </x-dashboard.sidebar-item>
            <x-dashboard.sidebar-item name="Manajemen layanan" :link="route('dashboard.service-management.index')" icon="bi bi-grid-fill" :route="['dashboard.service-management.index']" />
            <x-dashboard.sidebar-item name="Manajemen Faq" :link="route('dashboard.faq-management.index')" icon="bi bi-list-check" :route="['dashboard.faq-management.index']" />
            <x-dashboard.sidebar-item name="Manajemen Galeri" :link="route('dashboard.gallery-management.index')" icon="bi bi-image" :route="['dashboard.gallery-management.index']" />
        </ul>
    </aside>
    <!-- End Sidebar-->
