<x-app-layout>

    <x-slot name="header">
        {{ __('Service Management') }}
    </x-slot>

    <div class="col-12">
        <div class="card info-card p-5">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderServiceModal"
                    style="width: 200px">
                Pesan Layanan
            </button>

            <h3 class="mt-3">Riwayat Pemesanan</h3>

            <table class="table mt-3">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name Layanan</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Tanggal Booking</th>
                    <th scope="col">Catatan</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orderedServices as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->service->name }}</td>
                        <td>{{ $order->service->price }}</td>
                        <td>{{ $order->date }}</td>
                        <td>{{ $order->note }}</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                @endforeach
                </tbody>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderServiceModal" tabindex="-1" aria-labelledby="orderServiceModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-black">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderServiceModal">Pesan Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.order-service.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="mb-3">
                            <label for="select-service" class="form-label">Layanan</label>
                            <select class="form-select" aria-label="Default select example" id="select-service" name="service_id">
                                <option selected>Pilih Layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="price" name="price" disabled id>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal dan jam</label>
                            <input type="datetime-local" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectService = document.getElementById('select-service');
            const priceInput = document.getElementById('price');

            selectService.addEventListener('change', function () {
                const selectedService = selectService.options[selectService.selectedIndex];
                priceInput.value = selectedService.getAttribute('data-price');
            });
        });

    </script>
</x-app-layout>
