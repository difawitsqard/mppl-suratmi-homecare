@props(['icon', 'link', 'name', 'route' => null])

@php
    $route = isset($route) ? $route : null;
    $routeName = Request::route()->getName();

    // Pastikan $routeName dan $route sesuai dengan nama rute yang diharapkan
    $active = false;

    // Jika $route adalah array, cek apakah rute saat ini ada di dalam array tersebut
    if (is_array($route)) {
        foreach ($route as $r) {
            if (request()->routeIs($r)) {
                $active = true;
                break;
            }
        }
    } else {
        // Jika $route bukan array, gunakan request()->routeIs() untuk mengecek kecocokan
        $active = request()->routeIs($route) || str_contains($routeName, strtolower($name));
    }

    // Tetapkan kelas berdasarkan apakah rute aktif atau tidak
    $classes = $active ? '' : 'collapsed';
@endphp

<li class="nav-item">
    <a class="nav-link {{ $classes }}" href="{{ $slot->isEmpty() ? $link : '#' }}" {!! $slot->isEmpty() ? '' : 'data-bs-target="#' . Str::slug($name) . '-nav" data-bs-toggle="collapse"' !!}>
        <i class="{{ $icon }}"></i>
        <span>{{ $name }}</span>
        @if (!$slot->isEmpty())
            <i class="bi bi-chevron-down ms-auto"></i>
        @endif
    </a>
    @if (!$slot->isEmpty())
        <ul id="{{ Str::slug($name) }}-nav" class="nav-content {{ $active ? 'collapse show' : 'collapse' }} "
            data-bs-parent="#sidebar-nav">
            {{ $slot }}
        </ul>
    @endif
</li>
