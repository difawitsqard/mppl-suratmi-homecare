<x-app-layout>

    <x-slot name="header">
        {{ __('Service Management') }}
    </x-slot>

    @push('styles')
        <link href="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/css/star-rating.css') }}" media="all"
              rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/themes/krajee-svg/theme.min.css') }}"
              media="all" rel="stylesheet" type="text/css"/>
    @endpush

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
                    <th scope="col">Action</th>
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
                        <td>
                            <x-dashboard.status-order-badge :status="$order->status"/>
                        </td>
                        <td>
                            @if($order->status === 'completed')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                    Rating
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
                            <select class="form-select" aria-label="Default select example" id="select-service"
                                    name="service_id">
                                <option selected>Pilih Layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}"
                                            data-price="{{ $service->price }}">{{ $service->name }}</option>
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

    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-black">
                <div class="modal-header">
                    <h5 class="modal-title">Berikan Rating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.order-service.rating', [
                        'order_service' => $order->id
                        ]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="note" class="form-label">Rating</label>
                            <input name="rating" class="rating-input" type="text"/>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Review</label>
                            <textarea class="form-control" id="note" name="review" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/_module/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/js/star-rating.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/themes/krajee-svg/theme.min.js') }}"
            type="text/javascript"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const selectService = document.getElementById('select-service');
            const priceInput = document.getElementById('price');

            selectService.addEventListener('change', function () {
                const selectedService = selectService.options[selectService.selectedIndex];
                priceInput.value = selectedService.getAttribute('data-price');
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            $(".rating-input").rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'lg',
                showClear: false, // Hide the clear button
                showCaption: false, // Hide the caption,
            })})
    </script>
</x-app-layout>
