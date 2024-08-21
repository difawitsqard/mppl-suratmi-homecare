<x-app-layout>
    <x-slot name="header">
        {{ __('Order History') }}
    </x-slot>

    @push('styles')
        <link href="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/css/star-rating.css') }}" media="all"
            rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/themes/krajee-svg/theme.min.css') }}"
            media="all" rel="stylesheet" type="text/css" />
    @endpush

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"></h5>
                @if ($errors->any())
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible mb-4 fade show"
                        role="alert">
                        @if ($errors->count() > 1)
                            <b>Upps !</b> An error occurred while entering data.
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @else
                            <b>Upps!</b> {{ $errors->first() }}
                        @endif
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible mb-4 fade show"
                        role="alert">
                        <b>Ok!</b> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="btn-group mb-1">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownPerPage"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    {{ $orderedServices->total() < 30 ? 'disabled' : '' }}>
                                    {{ $orderedServices->perPage() }} entri per halaman
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownPerPage">
                                    @php
                                        $perPageOptions = [10, 20, 50, 100]; // Opsi jumlah entri per halaman
                                    @endphp
                                    @foreach ($perPageOptions as $page)
                                        @if ($orderedServices->perPage() == $page || $orderedServices->perPage() == null || $orderedServices->total() < $page)
                                            @continue
                                        @endif
                                        <a class="dropdown-item"
                                            href="{{ request()->url() . '?' . http_build_query(array_merge(request()->except(['page', 'perPage']), ['perPage' => $page])) }}">{{ $page }}
                                            entri per halaman</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.order-service.index') }}" class="btn btn-primary mb-1">Buat Pesanan
                            Baru</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <form action="{{ request()->fullUrlWithoutQuery(['page']) }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Cari..."
                                    {{ !empty(request()->search) ? 'value=' . request()->search . '' : '' }}>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Layanan</th>
                            <th scope="col">Tanggal Booking</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderedServices as $num => $orderedService)
                            <tr>
                                <th class="align-middle" scope="row">{{ $orderedServices->firstItem() + $num }}</th>
                                <td class="align-middle">{{ $orderedService->service->name }}</td>
                                <td class="align-middle text-nowarp">
                                    {{ \Carbon\Carbon::parse($orderedService->date)->format('d F Y H:i') }}
                                </td>
                                <td class="align-middle text-nowrap" width="10%"><small
                                        class="fw-bold">Rp.</small>{{ formatRupiah($orderedService->service->price) }}
                                </td>
                                <td class="align-middle">
                                    <x-dashboard.status-order-badge :status="$orderedService->status" />
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-primary show-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-id="{{ $orderedService->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @if ($orderedService->status == 'pending')
                                            <button type="button" class="btn btn-warning edit-button"
                                                data-bs-toggle="modal" data-bs-target="#MyModal"
                                                data-id="{{ $orderedService->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        @endif
                                        @if ($orderedService->status == 'completed' && $orderedService->testimonial == null)
                                            <button type="button" class="btn btn-warning rating-button"
                                                data-bs-toggle="modal" data-bs-target="#ratingModal"
                                                data-id="{{ $orderedService->id }}" data-url="">
                                                <i class="bi bi-star"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $orderedServices->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('modals')
        <div class="modal fade" id="MyModal" tabindex="-1" aria-labelledby="MyModalLabel" aria-hidden="true"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MyModalLabel">Tambah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body row">
                            @csrf
                            @method('POST')
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="service_id" name="service_id"
                                        aria-label="service_id">
                                        <option selected="" disabled>Pilih Layanan</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                data-price="{{ formatRupiah($service->price) }}">
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="service_id">Layanan</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="price" class="form-control" id="price" name="price"
                                        placeholder="price" value="0" readonly disabled>
                                    <label for="price">Harga</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="datetime-local" class="form-control" id="date" name="date"
                                        value="{{ old('date') }}" placeholder="Tanggal Booking">
                                    <label for="date">Tanggal Booking</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Catatan" id="note" name="note" style="height: 155px;">{{ old('note') }}</textarea>
                                    <label for="note">Catatan</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white testimonial-detail" style="display: none;">
                            <div class="d-flex flex-column align-items-center mt-0">
                                <input name="rating-detail" class="rating-detail" type="text"
                                    style="display: none;" />
                            </div>
                            <div class="mt-3 text-center">
                                <label for="testimoni_content" class="form-label fw-bold">Ulasan</label>
                                <textarea class="form-control" id="testimoni_content" placeholder="..." rows="4"
                                    style="text-align: center;" readonly="" disabled=""></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModal" aria-hidden="true"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content text-black">
                    <div class="modal-header">
                        <h5 class="modal-title">Berikan Rating & Ulasan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="d-flex flex-column align-items-center mt-0">
                                <input name="rating" class="rating-input" type="text" />
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Ulasan</label>
                                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/_module/jquery/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/js/star-rating.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/themes/krajee-svg/theme.min.js') }}"
            type="text/javascript"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var Modal = document.querySelector('#MyModal');
                var modalForm = Modal.querySelector('form');
                var inputs = modalForm.querySelectorAll('input, textarea, select');
                var methodInput = modalForm.querySelector('input[name="_method"]');
                var itemIdInput = modalForm.querySelector('input[name="id"]');
                var submitButton = modalForm.querySelector('button[type="submit"]');
                var serviceIdInput = modalForm.querySelector('select[name="service_id"]');
                var priceInput = modalForm.querySelector('input[name="price"]');
                var dateInput = modalForm.querySelector('input[name="date"]');
                var noteTextarea = modalForm.querySelector('textarea[name="note"]');

                var ratingModal = document.querySelector('#ratingModal');
                var ratingForm = ratingModal.querySelector('form');

                // Function to set all fields to read-only & Disabled
                function setFieldsReadOnly(isReadOnly) {
                    inputs.forEach(function(input) {
                        input.readOnly = isReadOnly;
                        input.disabled = isReadOnly;
                    });
                }

                document.querySelectorAll('.show-button, .edit-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var isEdit = button.classList.contains('edit-button');
                        var itemId = button.getAttribute('data-id');
                        $('.testimonial-detail').hide();

                        if (isEdit) {
                            modalForm.action =
                                `{{ route('dashboard.order-service.index') }}/${itemId}`;
                            methodInput.value = 'PUT';
                            submitButton.style.display = 'block';
                            setFieldsReadOnly(false);
                            priceInput.readOnly = true;
                            priceInput.disabled = true;
                        } else {
                            methodInput.value = '';
                            modalForm.action = '';
                            submitButton.style.display = 'none';
                            setFieldsReadOnly(true);
                        }

                        Modal.querySelector('#MyModalLabel').textContent = isEdit ? 'Edit' : 'Detail';

                        fetch(`{{ route('dashboard.order-service.index') }}/${itemId}`)
                            .then(response => response.json())
                            .then(data => {
                                serviceIdInput.selectedIndex = [...serviceIdInput.options]
                                    .findIndex(option => option.value == data.service_id);
                                priceInput.value = data.service.price;
                                dateInput.value = data.date;
                                noteTextarea.value = data.note;

                                if (data.testimonial && !isEdit) {
                                    $(".rating-detail").rating({
                                        min: 0,
                                        max: 5,
                                        step: 1,
                                        size: 'lg',
                                        showClear: false, // Hide the clear button
                                        showCaption: false, // Hide the caption
                                        disabled: true,
                                    }).rating('update', data.testimonial.rating); // Update the rating value

                                    $(".rating-detail").show();
                                    Modal.querySelector('#testimoni_content').value = data.testimonial.content;
                                    $('.testimonial-detail').fadeIn();
                                }
                            });

                    });
                });

                serviceIdInput.addEventListener('change', function() {
                    var selectedOption = serviceIdInput.options[serviceIdInput.selectedIndex];
                    priceInput.value = selectedOption.getAttribute('data-price');
                });

                document.querySelectorAll('.rating-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var itemId = button.getAttribute('data-id');
                        ratingForm.action =
                            `{{ route('dashboard.order-service.index') }}/${itemId}/rating`;
                        setFieldsReadOnly(false);
                    });
                });

                $(".rating-input").rating({
                    min: 0,
                    max: 5,
                    step: 1,
                    size: 'lg',
                    showClear: false, // Hide the clear button
                    showCaption: false, // Hide the caption,
                });
            });
        </script>
    @endpush

</x-app-layout>
