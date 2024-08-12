    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <x-dashboard.sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid" :route="['dashboard']" />
            <li class="nav-heading">Menu</li>
            <x-dashboard.sidebar-item name="Item Sub" icon="bi bi-person" :route="['dashboard/admin', 'dashboard/admin/*']">
                <x-dashboard.sidebar-sub-item name="Sub Item" :link="route('dashboard.admin')" :route="['dashboard.admin']" />
            </x-dashboard.sidebar-item>
            <x-dashboard.sidebar-item name="Item" :link="route('dashboard.admin')" icon="bi bi-grid-fill" :route="['dashboard.admin']" />
        </ul>
    </aside>
    <!-- End Sidebar-->
