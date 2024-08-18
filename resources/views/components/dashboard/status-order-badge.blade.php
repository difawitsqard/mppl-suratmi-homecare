<!-- resources/views/components/status-badge.blade.php -->
@props(['status' => null])
@php
    $DataStatus = match ($status) {
        'pending' => [
            'color' => 'warning',
            'text' => 'Pending',
        ],
        'approved' => [
            'color' => 'primary',
            'text' => 'Approved',
        ],
        'completed' => [
            'color' => 'success',
            'text' => 'Completed',
        ],
        'rejected' => [
            'color' => 'danger',
            'text' => 'Rejected',
        ],
        'canceled' => [
            'color' => 'danger',
            'text' => 'Canceled',
        ],
        default => [
            'color' => 'secondary',
            'text' => 'Unknown',
        ],
    };
@endphp

<span class="badge bg-{{ $DataStatus['color'] }}">
    {{ $DataStatus['text'] }}
</span>
