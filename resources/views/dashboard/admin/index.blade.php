<x-app-layout>

    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>
    <div class="col-12 mt-3">

        <div class="row">
            <div class="col-md-3">
                <div class="card px-3">
                    <div class="d-flex align-items-center">
                        <div class="me-2 p-3">
                            <i class="bi bi-people" style="font-size: 3rem; color:#ea7510ed;"></i>
                        </div>
                        <div>
                            <h3 class="card-title py-1 fw-bold mb-0">{{ $customers->count() }}</h3>
                            <p class="card-text">Total Costumer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card px-3">
                    <div class="d-flex align-items-center">
                        <div class="me-2 p-3">
                            <i class="bi bi-people" style="font-size: 3rem; color:#1076eaed;"></i>
                        </div>
                        <div>
                            <h3 class="card-title py-1 fw-bold mb-0">{{ $therapists->count() }}</h3>
                            <p class="card-text">Total Terapis</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card px-3">
                    <div class="d-flex align-items-center">
                        <div class="me-2 p-3">
                            <i class="bi bi-chat-left text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <div>
                            <h3 class="card-title py-1 fw-bold mb-0">{{ $totalPending }}</h3>
                            <p class="card-text">Menunggu Konfirmasi</p>
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

            <div class="col-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Pendapatan</h5>

                        <!-- Line Chart -->
                        <div id="reportsChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#reportsChart"), {
                                    series: [{
                                        name: 'Income',
                                        data: @json($orders->incomes),
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'area',
                                        toolbar: {
                                            show: false
                                        },
                                    },
                                    markers: {
                                        size: 4
                                    },
                                    colors: ['#4154f1', '#2eca6a'],
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            shadeIntensity: 1,
                                            opacityFrom: 0.3,
                                            opacityTo: 0.4,
                                            stops: [0, 90, 100]
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'smooth',
                                        width: 2
                                    },
                                    xaxis: {
                                        categories: @json($orders->dates),
                                    },
                                }).render();
                            });
                        </script>
                        <!-- End Line Chart -->

                    </div>

                </div>
            </div>

            <div class="col-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Pesanan</h5>

                        <!-- Line Chart -->
                        <div id="orderChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#orderChart"), {
                                    series: [{
                                        name: 'Orders',
                                        data: @json($orders->orders),
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'area',
                                        toolbar: {
                                            show: false
                                        },
                                    },
                                    markers: {
                                        size: 4
                                    },
                                    colors: ['#4154f1', '#2eca6a'],
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            shadeIntensity: 1,
                                            opacityFrom: 0.3,
                                            opacityTo: 0.4,
                                            stops: [0, 90, 100]
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'smooth',
                                        width: 2
                                    },
                                    xaxis: {
                                        categories: @json($orders->dates),
                                    },
                                }).render();
                            });
                        </script>
                        <!-- End Line Chart -->

                    </div>

                </div>
            </div>


        </div>

    </div>
</x-app-layout>
