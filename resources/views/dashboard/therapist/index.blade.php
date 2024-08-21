<x-app-layout>

    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    @push('styles')
        <!-- Vendor CSS Files -->
        <link href="{{ asset('_dashboard/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('_dashboard/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    @endpush

    <div class="col-12 mt-3">

        <div class="row">
            <div class="col-md-3">
                <div class="card px-3">
                    <div class="d-flex align-items-center">
                        <div class="me-2 p-3">
                            <i class="bi bi-chat-left" style="font-size: 3rem; color:#ea7510ed;"></i>
                        </div>
                        <div>
                            <h3 class="card-title py-1 fw-bold mb-0">{{ $OrderServices->count() }}</h3>
                            <p class="card-text">Total Pesanan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card px-3">
                    <div class="d-flex align-items-center">
                        <div class="me-2 p-3">
                            <i class="bi bi-chat-left" style="font-size: 3rem; color:#0053b8ed;"></i>
                        </div>
                        <div>
                            <h3 class="card-title py-1 fw-bold mb-0">{{ $totalApproved }}</h3>
                            <p class="card-text">Menunggu Diproses</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card px-3">
                    <div class="d-flex align-items-center">
                        <div class="me-2 p-3">
                            <i class="bi bi-chat-left" style="font-size: 3rem; color:#00b806ed;"></i>
                        </div>
                        <div>
                            <h3 class="card-title py-1 fw-bold mb-0">{{ $totalComplete }}</h3>
                            <p class="card-text">Pesanan Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
