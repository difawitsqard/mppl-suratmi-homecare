@props(['submit'])

<div {{ $attributes }}>
    <form wire:submit="{{ $submit }}">
        {{ $form }}
        @if (isset($actions))
        <div class="d-flex justify-content-end">
            {{ $actions }}
        </div>
        @endif
    </form>
</div>
