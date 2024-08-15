@props(['link', 'name', 'route' => null])

@php
    $routeName = Request::route()->getName();

    // Pastikan $routeName dan $route sesuai dengan nama rute yang diharapkan
    $active = false;

    // Jika $route adalah array, loop melalui dan cek apakah salah satu rute aktif
    if (is_array($route)) {
        foreach ($route as $r) {
            if (request()->routeIs($r)) {
                $active = true;
                break;
            }
        }
    } else {
        // Jika $route adalah string, gunakan request()->routeIs() untuk cek kecocokan
        $active = request()->routeIs($route) || str_contains($routeName, strtolower($name));
    }

    // Tetapkan kelas berdasarkan apakah rute aktif atau tidak
    $subItemClasses = $active ? 'active-sub-item' : '';
@endphp


<li>
    <a href="{{ $link }}" class="{{ $active ? 'active' : '' }}">
        <i class="bi bi-circle"></i><span>{{ $name }}</span>
    </a>
</li>
