<x-app-layout>
    <x-slot name="header">
        {{ __('Testimonial Management') }}
    </x-slot>

    @push('styles')
        <link href="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/css/star-rating.css') }}" media="all"
            rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/_module/kartik-v-bootstrap-star-rating/themes/krajee-svg/theme.min.css') }}"
            media="all" rel="stylesheet" type="text/css" />
    @endpush

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body mb-3">
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
                                    {{ $Testimonials->total() < 30 ? 'disabled' : '' }}>
                                    {{ $Testimonials->perPage() }} entri per halaman
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownPerPage">
                                    @php
                                        $perPageOptions = [10, 20, 50, 100]; // Opsi jumlah entri per halaman
                                    @endphp
                                    @foreach ($perPageOptions as $page)
                                        @if ($Testimonials->perPage() == $page || $Testimonials->perPage() == null || $Testimonials->total() < $page)
                                            @continue
                                        @endif
                                        <a class="dropdown-item"
                                            href="{{ request()->url() . '?' . http_build_query(array_merge(request()->except(['page', 'perPage']), ['perPage' => $page])) }}">{{ $page }}
                                            entri per halaman</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
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

                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th class="text-center bg-light mr-5" scope="col">#</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Ulasan</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($Testimonials as $num => $Testimonial)
                            <tr>
                                <th class="align-middle text-center bg-light px-3" scope="row">
                                    {{ $Testimonials->firstItem() + $num }}</th>
                                <th class="align-middle text">
                                    <div class="d-flex align-items-center pe-0">
                                        <img src="{{ $Testimonial->orderService->customer->profile_photo_url }}"
                                            alt="{{ $Testimonial->orderService->customer->name }}" width="40px"
                                            height="40px" class="rounded-circle shadow-sm" style="object-fit: cover;">
                                        <span
                                            class="ps-3 fw-normal"><b>{{ $Testimonial->orderService->customer->name }}</b><i></br>{{ ucwords($Testimonial->orderService->customer->roles[0]->name) }}</i></span>
                                    </div>
                                </th>
                                <td class="align-middle">{{ $Testimonial->content }}</td>
                                <td class="align-middle text-nowrap" width="20%">
                                    <input name="rating-{{ $Testimonial->id }}" class="rating-input" type="text"
                                        value="{{ $Testimonial->rating }}" />
                                </td>

                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-primary show-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-id="{{ $Testimonial->id }}"
                                            data-url="{{ route('dashboard.testimonial-management.show', $Testimonial->id) }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $Testimonials->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('modals')
        <div class="modal fade" id="MyModal" tabindex="-1" aria-labelledby="MyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MyModalLabel">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card mb-1">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center p-0 mb-1">
                            <img id="profile-image" src="https://suratmi-homecare.com/_dashboard\assets\img\avatar.jpg"
                                style="width: 120px; height:120px; object-fit: cover;" class="rounded-circle mb-2">
                            <h4 id="profile-name" class="fw-bold mb-0">Nama</h4>
                            <p id="profile-role" class="p-0">Role</p>
                        </div>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="d-flex flex-column align-items-center mt-0">
                            <input name="rating-detail" class="rating-detail" type="text" style="display: none;" />
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_id" class="form-label">ID Pesanan</label>
                                    <input type="text" class="form-control" id="order_id" name="order_id"
                                        placeholder="..." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="service_name" class="form-label">Layanan</label>
                                    <input type="text" class="form-control" id="service_name" name="service_name"
                                        placeholder="..." required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-0 text-center">
                            <label for="testimoni_content" class="form-label fw-bold">Ulasan</label>
                            <textarea class="form-control" id="testimoni_content" name="testimoni_content" placeholder="..." rows="4"
                                style="text-align: center;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

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
                $(".rating-input").rating({
                    min: 0,
                    max: 5,
                    step: 1,
                    size: 'lg',
                    showClear: false, // Hide the clear button
                    showCaption: false, // Hide the caption
                    disabled: true,
                });

                var Modal = document.querySelector('#MyModal');
                var inputs = Modal.querySelectorAll('input, textarea, select');
                var itemId = Modal.querySelector('input[name="id"]');
                var submitButton = Modal.querySelector('button[type="submit"]');

                var profileImage = Modal.querySelector('#profile-image');
                var profileName = Modal.querySelector('#profile-name');
                var profileRole = Modal.querySelector('#profile-role');

                var ratingInput = Modal.querySelector('input[name="rating-detail"]');
                var orderIdInput = Modal.querySelector('input[name="order_id"]');
                var serviceNameInput = Modal.querySelector('input[name="service_name"]');
                var testimoniContentTextarea = Modal.querySelector('textarea[name="testimoni_content"]');

                // Function to set all fields to read-only & Disabled
                function setFieldsReadOnly(isReadOnly) {
                    inputs.forEach(function(input) {
                        input.readOnly = isReadOnly;
                        input.disabled = isReadOnly;
                    });
                }

                // Show button click event
                document.querySelectorAll('.show-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var url = button.getAttribute('data-url');
                        submitButton.style.display = 'none';
                        setFieldsReadOnly(true);
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                profileName.textContent = data.order_service.customer.name;
                                profileRole.textContent = data.order_service.customer.roles[0].name
                                    .replace(/^\w/, c => c
                                        .toUpperCase());;
                                profileImage.src = data.order_service.customer.profile_photo_url;

                                ratingInput.value = data.rating;
                                orderIdInput.value = data.id;
                                serviceNameInput.value = data.order_service.service.name;
                                testimoniContentTextarea.value = data.content;

                                $(".rating-detail").rating({
                                    min: 0,
                                    max: 5,
                                    step: 1,
                                    size: 'lg',
                                    showClear: false, // Hide the clear button
                                    showCaption: false, // Hide the caption
                                    disabled: true,
                                }).rating('update', data.rating); // Update the rating value
                                $(".rating-detail").show();

                            })
                            .catch(error => console.error('Error fetching:', error));
                    });
                });

            });
        </script>
    @endpush

</x-app-layout>
