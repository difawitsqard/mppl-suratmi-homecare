@props(['icon', 'link', 'name', 'route' => null])

@php
    $route = isset($route) ? $route : null;
    $routeName = Request::route()->getName();
    $active = request()->is($route) || str_contains($routeName, strtolower($name));
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
