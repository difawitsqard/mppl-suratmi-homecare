<x-app-layout>
    <x-slot name="header">
        {{ __('Order Management') }}
    </x-slot>

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
                                    {{ $OrderServices->total() < 30 ? 'disabled' : '' }}>
                                    {{ $OrderServices->perPage() }} entri per halaman
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownPerPage">
                                    @php
                                        $perPageOptions = [10, 20, 50, 100]; // Opsi jumlah entri per halaman
                                    @endphp
                                    @foreach ($perPageOptions as $page)
                                        @if ($OrderServices->perPage() == $page || $OrderServices->perPage() == null || $OrderServices->total() < $page)
                                            @continue
                                        @endif
                                        <a class="dropdown-item"
                                            href="{{ request()->url() . '?' . http_build_query(array_merge(request()->except(['page', 'perPage']), ['perPage' => $page])) }}">{{ $page }}
                                            entri per halaman</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- <button class="btn btn-primary mb-1 add-button" data-bs-toggle="modal" data-bs-target="#MyModal"
                            data-add-url="{{ route('dashboard.gallery-management.store') }}">
                            <i class="bi bi-plus"></i>
                            Tambah
                        </button> --}}
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
                            <th scope="col">ID</th>
                            <th scope="col">Layanan</th>
                            <th scope="col">Tgl Booking</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($OrderServices as $num => $OrderService)
                            <tr>
                                <th class="align-middle text-center bg-light px-3" scope="row">
                                    {{ $OrderServices->firstItem() + $num }}</th>
                                <th class="align-middle text">
                                    <div class="d-flex align-items-center pe-0">
                                        <img src="{{ $OrderService->customer->profile_photo_url }}"
                                            alt="{{ $OrderService->customer->name }}" width="40px" height="40px"
                                            class="rounded-circle shadow-sm" style="object-fit: cover;">
                                        <span
                                            class="ps-3 fw-normal"><b>{{ $OrderService->customer->name }}</b><i></br>{{ $OrderService->customer->roles[0]->name }}</i></span>
                                    </div>
                                </th>
                                <td class="align-middle fw-bold text-nowrap">ID#{{ $OrderService->id }}</td>
                                <td class="align-middle" width="30%">{{ $OrderService->service->name }}</td>
                                <td class="align-middle text-nowrap">{{ $OrderService->date_format }}</td>
                                <td class="align-middle" width="10%">
                                    <x-dashboard.status-order-badge :status="$OrderService->status" />
                                </td>

                                <td class="align-middle text-nowrap">
                                    <div class="d-flex align-items-center gap-1">
                                        <button type="button" class="btn btn-primary btn-sm show-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-id="{{ $OrderService->id }}"
                                            data-url="{{ route('dashboard.order-management.show', $OrderService->id) }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $OrderServices->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('modals')
        <div class="modal fade" id="MyModal" tabindex="-1" aria-labelledby="MyModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MyModalLabel">Detail Pesanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="p-0 confirm-modal" style="display: none;">
                        <div class="modal-body">
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible mb-3 fade show alert-change-status"
                                role="alert" style="display: none;">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <p id="modalMessage" class="mb-0 text-center"></p>
                            <input type="hidden" id="currentStatus">
                            <div id="therapistSelection" class="mb-3 mt-2" style="display: none;">
                                <label for="therapist" class="form-label fw-bold">Pilih Terapis</label>
                                <select name="therapist" id="therapist" class="form-control">
                                    <option disabled selected>Pilih Terapis ...</option>
                                    @foreach ($therapists as $therapist)
                                        <option value="{{ $therapist->id }}">{{ $therapist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer footer-confirm">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary confirm-change-status">Ya, ubah</button>
                        </div>
                    </div>
                    <div class="p-0 detail-pesanan">
                        <div class="card mt-0 mb-1 p-0">
                            <ul class="list-group block">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-5">
                                    Pesanan Dibuat
                                    <span id="service_datetime"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-5">
                                    Status Pesanan
                                    <span id="service_status"></span>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-body bg-white">
                            <div class="row g-3">
                                <input type="hidden" id="itemId" name="id">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" class="form-control" id="role" name="role"
                                            placeholder="..." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-0">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="..." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-0">
                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label">Nomor Hp</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            placeholder="..." required>
                                    </div>
                                </div>
                                <div class="mb-3 mt-0">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" placeholder="..." rows="2"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="service_name" class="form-label">Nama Layanan</label>
                                        <input type="text" class="form-control" id="service_name" name="service_name"
                                            placeholder="..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order_id" class="form-label">ID Pesanan</label>
                                        <input type="text" class="form-control" id="order_id" name="order_id"
                                            placeholder="..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="therapist" class="form-label">Terapis</label>
                                        <input type="text" class="form-control" id="therapist" name="therapist"
                                            placeholder="..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="service_price" class="form-label">Harga</label>
                                        <input type="text" class="form-control" id="service_price"
                                            name="service_price" placeholder="..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order_date" class="form-label">Tanggal </label>
                                        <input type="text" class="form-control" id="order_date" name="order_date"
                                            placeholder="..." required>
                                    </div>
                                </div>
                                <div class="mb-3 mt-0">
                                    <label for="order_note" class="form-label">Note</label>
                                    <textarea class="form-control" id="order_note" name="order_note" placeholder="..." rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer footer-detail">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <div class="button-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var Modal = document.querySelector('#MyModal');
                var modalDialog = Modal.querySelector('.modal-dialog');
                var confirmModalBody = Modal.querySelector('.confirm-modal');

                var confirmButton = confirmModalBody.querySelector('.footer-confirm > .confirm-change-status');
                var inputs = Modal.querySelectorAll('input, textarea, select');
                var itemId = Modal.querySelector('input[name="id"]');

                var serviceStatus = Modal.querySelector('#service_status');
                var serviceDatetime = Modal.querySelector('#service_datetime');

                var orderIdInput = Modal.querySelector('input[name="order_id"]');
                var serviceNameInput = Modal.querySelector('input[name="service_name"]');
                var serviceTerapis = Modal.querySelector('input[name="therapist"]');
                var servicePriceInput = Modal.querySelector('input[name="service_price"]');
                var orderDateInput = Modal.querySelector('input[name="order_date"]');
                var orderNoteTextarea = Modal.querySelector('textarea[name="order_note"]');

                var nameInput = Modal.querySelector('input[name="name"]');
                var roleInput = Modal.querySelector('input[name="role"]');
                var emailInput = Modal.querySelector('input[name="email"]');
                var phonenumberInput = Modal.querySelector('input[name="phone_number"]');
                var addressTextarea = Modal.querySelector('textarea[name="address"]');
                var submitButton = Modal.querySelector('button[type="submit"]');

                // Function to set all fields to read-only & Disabled
                function setFieldsReadOnly(isReadOnly) {
                    inputs.forEach(function(input) {
                        input.readOnly = isReadOnly;
                        input.disabled = isReadOnly;
                    });
                }

                // Function to remove image preview
                function removeImagePreview() {
                    profile.src = '';
                    profile.style.display = 'none';
                }

                // Function to preview image
                function previewImage(event) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        profile.src = reader.result;
                        profile.style.display = 'block';
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }

                function createButton({
                    className = '',
                    innerHTML = '',
                    onClickFunction = () => {}
                } = {}) {
                    var button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'btn ' + className;
                    button.innerHTML = innerHTML;
                    button.onclick = onClickFunction;
                    return button;
                }

                // Show button click event
                document.querySelectorAll('.show-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var modalFooterDetail = Modal.querySelector(
                            '.footer-detail > .button-container');
                        modalDialog.classList.remove('modal-md');
                        modalDialog.classList.add('modal-lg');
                        Modal.querySelector('#MyModalLabel').textContent = 'Detail Pesanan';
                        confirmModalBody.style.display = 'none';
                        Modal.querySelector('.detail-pesanan').style.display = 'block';
                        modalFooterDetail.innerHTML = '';

                        var url = button.getAttribute('data-url');
                        submitButton.style.display = 'none';
                        setFieldsReadOnly(true);
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                itemId.value = data.id;
                                nameInput.value = data.customer.name;
                                roleInput.value = data.customer.roles[0].name;
                                emailInput.value = data.customer.email;
                                phonenumberInput.value = data.customer.phone_number;
                                addressTextarea.value = data.customer.address;
                                serviceStatus.innerHTML = createStatusBadge(data.status).outerHTML;
                                serviceDatetime.textContent = data.created_at_formatted;

                                orderIdInput.value = "ID#" + data.id;
                                serviceTerapis.value = data.therapist ? data.therapist.name : '...';
                                serviceNameInput.value = data.service.name;
                                servicePriceInput.value = data.service.price;
                                orderDateInput.value = data.date_format;
                                orderNoteTextarea.value = data.note;

                                if (data.status === 'pending') {
                                    let buttonApprove = createButton({
                                        className: 'btn-success me-2',
                                        innerHTML: '<i class="bi bi-check2"></i> Terima',
                                        onClickFunction: confirmChangeStatus
                                    });
                                    buttonApprove.setAttribute('data-id', data.id);
                                    buttonApprove.setAttribute('data-status', 'approved');
                                    modalFooterDetail.appendChild(buttonApprove);

                                    let buttonReject = createButton({
                                        className: 'btn-danger',
                                        innerHTML: '<i class="bi bi-x"></i> Tolak',
                                        onClickFunction: confirmChangeStatus
                                    });
                                    buttonReject.setAttribute('data-id', data.id);
                                    buttonReject.setAttribute('data-status', 'rejected');
                                    modalFooterDetail.appendChild(buttonReject);
                                }

                                if (data.status === 'approved') {
                                    let buttonCompleted = createButton({
                                        className: 'btn-success',
                                        innerHTML: '<i class="bi bi-check2-circle"></i> Selesai',
                                        onClickFunction: confirmChangeStatus
                                    });
                                    buttonCompleted.setAttribute('data-id', data.id);
                                    buttonCompleted.setAttribute('data-status', 'completed');
                                    modalFooterDetail.appendChild(buttonCompleted);
                                }
                            })
                            .catch(error => console.error('Error fetching:', error));
                    });
                });


                function confirmChangeStatus(event) {

                    var button = event.currentTarget;
                    var dataId = button.getAttribute('data-id');
                    var dataStatus = button.getAttribute('data-status');

                    modalDialog.classList.remove('modal-lg');
                    modalDialog.classList.add('modal-md');

                    Modal.querySelector('.detail-pesanan').style.display = 'none';
                    Modal.querySelector('#MyModalLabel').textContent = `Konfirmasi Perubahan Status Pesanan`;

                    confirmModalBody.querySelector('#modalMessage').innerHTML =
                        `Apakah Anda yakin ingin merubah status pesanan dengan <b>ID#${dataId}</b> ke ${createStatusBadge(dataStatus).outerHTML} ?`;
                    confirmModalBody.style.display = 'block';
                    confirmButton.setAttribute('data-id', dataId);
                    confirmButton.setAttribute('data-status', dataStatus);

                    if (dataStatus === 'approved') {
                        document.querySelector('#therapistSelection').style.display = 'block';
                        setFieldsReadOnly(false);
                    } else {
                        document.querySelector('#therapistSelection').style.display = 'none';
                        setFieldsReadOnly(true);
                    }
                }

                function createStatusBadge(status) {
                    const statusData = {
                        'pending': {
                            color: 'warning',
                            text: 'Pending'
                        },
                        'approved': {
                            color: 'primary',
                            text: 'Approved'
                        },
                        'completed': {
                            color: 'success',
                            text: 'Completed'
                        },
                        'rejected': {
                            color: 'danger',
                            text: 'Rejected'
                        },
                        'canceled': {
                            color: 'danger',
                            text: 'Canceled'
                        },
                        'default': {
                            color: 'secondary',
                            text: 'Unknown'
                        }
                    };

                    const data = statusData[status] || statusData['default'];
                    const badge = document.createElement('span');
                    badge.className = `badge bg-${data.color}`;
                    badge.textContent = data.text;

                    return badge;
                }

                confirmButton.addEventListener('click', function() {
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var status = confirmButton.getAttribute('data-status');
                    var orderId = confirmButton.getAttribute('data-id');
                    var error_message = confirmModalBody.querySelector('.alert-change-status');

                    var data = {
                        status: status
                    };

                    if (status === 'approved') {
                        data.therapist_id = document.getElementById('therapist').value;
                    }

                    fetch(`{{ route('dashboard.order-management.index') }}/${orderId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                location.reload();
                            } else {
                                error_message.textContent = data.message;
                                error_message.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to update status');
                        });
                });

            });
        </script>
    @endpush

</x-app-layout>
