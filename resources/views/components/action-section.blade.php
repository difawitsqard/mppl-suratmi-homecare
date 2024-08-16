@props(['card' => true])

<span>
@if ($card)
    <div {{ $attributes->merge(['class' => 'card']) }} style="overflow: auto;">
        <div class="card-body">
            <div class="container">
                <h5 class="card-title">{{ $title }}</h5>
                {{ $content }}
            </div>
        </div>
    </div>
@else
<h5 class="card-title">{{ $title }}</h5>
{{ $content }}
@endif

</span>
