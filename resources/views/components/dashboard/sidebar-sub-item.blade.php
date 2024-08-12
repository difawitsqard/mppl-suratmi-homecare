@props(['link', 'name', 'route' => null])

@php
    $routeName = Request::route()->getName();
    $active = request()->is($route) || str_contains($routeName, strtolower($name));
@endphp

<li>
    <a href="{{ $link }}" class="{{ $active ? 'active' : '' }}">
        <i class="bi bi-circle"></i><span>{{ $name }}</span>
    </a>
</li>
