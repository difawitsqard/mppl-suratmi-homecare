<x-app-layout>

    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="col-12">

        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">Income</h5>

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

        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">Order</h5>

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
</x-app-layout>
