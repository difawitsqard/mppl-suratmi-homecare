@if (count(request()->segments()) > 1)
<nav aria-label="breadcrumb" class="breadcrumb-header">
  <ol class="breadcrumb">
      @foreach (request()->segments() as $key => $segment)
          @php
              $url = url(implode('/', array_slice(request()->segments(), 0, $key + 1)));
              // Mengubah segment dari kebab-case ke Title Case
              $segmentTitle = ucwords(str_replace('-', ' ', $segment));
          @endphp
          
          @if ($key == count(request()->segments()) - 1)
              <li class="breadcrumb-item active" aria-current="page">{{ $segmentTitle }}</li>
          @else
              <li class="breadcrumb-item">
                  <a href="{{ $url }}">{{ $segmentTitle }}</a>
              </li>
          @endif
      @endforeach
  </ol>
</nav>
@endif
