<x-app-layout>
    <x-slot name="header">
        {{ __('Service Management') }}
    </x-slot>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"></h5>
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="btn-group mb-1">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownPerPage"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    {{ $services->total() < 30 ? 'disabled' : '' }}>
                                    {{ $services->perPage() }} entri per halaman
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownPerPage">
                                    @php
                                        $perPageOptions = [10, 20, 50, 100]; // Opsi jumlah entri per halaman
                                    @endphp
                                    @foreach ($perPageOptions as $page)
                                        @if ($services->perPage() == $page || $services->perPage() == null || $services->total() < $page)
                                            @continue
                                        @endif
                                        <a class="dropdown-item"
                                            href="{{ request()->url() . '?' . http_build_query(array_merge(request()->except(['page', 'perPage']), ['perPage' => $page])) }}">{{ $page }}
                                            entri per halaman</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mb-1 add-button" data-bs-toggle="modal" data-bs-target="#MyModal"
                            data-add-url="{{ route('dashboard.service-management.store') }}">
                            <i class="bi bi-plus"></i>
                            Tambah
                        </button>
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
                            <th scope="col">Nama</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $num => $service)
                            <tr>
                                <th class="align-middle" scope="row">{{ $services->firstItem() + $num }}</th>
                                <td class="align-middle">{{ $service->name }}</td>
                                <td class="align-middle">{{ $service->description }}</td>
                                <td class="align-middle no-warp" width="10%"><small class="fw-bold">Rp.</small>{{ formatRupiah($service->price) }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-primary show-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-id="{{ $service->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning edit-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-id="{{ $service->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form
                                            action="{{ route('dashboard.service-management.destroy', $service->id) }}"
                                            method="POST" class="d-inline" id="deleteForm-{{ $service->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="if (confirm('Apakah Anda yakin ingin menghapus Data #{{ $services->firstItem() + $num }} ?')) { document.getElementById('deleteForm-{{ $service->id }}').submit(); }">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $services->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('modals')
        <div class="modal fade" id="MyModal" tabindex="-1" aria-labelledby="MyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MyModalLabel">Tambah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboard.service-management.store') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            @method('POST')
                            <input type="hidden" id="itemId" name="id">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Layanan</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="..."
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Layanan</label>
                                <textarea class="form-control" id="description" name="description" placeholder="..." rows="5"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="..." required>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var Modal = document.querySelector('#MyModal');
                var modalForm = Modal.querySelector('form');
                var inputs = modalForm.querySelectorAll('input, textarea');
                var methodInput = modalForm.querySelector('input[name="_method"]');
                var itemIdInput = modalForm.querySelector('input[name="id"]');
                var nameInput = modalForm.querySelector('input[name="name"]');
                var descriptionTextarea = modalForm.querySelector('textarea[name="description"]');
                var priceInput = modalForm.querySelector('input[name="price"]');
                var submitButton = modalForm.querySelector('button[type="submit"]');

                // Function to set all fields to read-only & Disabled
                function setFieldsReadOnly(isReadOnly) {
                    inputs.forEach(function(input) {
                        input.readOnly = isReadOnly;
                        input.disabled = isReadOnly;
                    });
                }

                document.querySelectorAll('.add-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        submitButton.style.display = 'block';
                        setFieldsReadOnly(false);
                        methodInput.value = 'POST';
                        Modal.querySelector('#MyModalLabel').textContent = 'Tambah';
                        modalForm.action = button.getAttribute('data-add-url');
                        modalForm.reset();
                        itemIdInput.value = '';
                    });
                });

                document.querySelectorAll('.show-button, .edit-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var isEdit = button.classList.contains('edit-button');
                        var itemId = button.getAttribute('data-id');

                        if (isEdit) {
                            modalForm.action =
                                `{{ route('dashboard.service-management.index') }}/${itemId}`;
                            methodInput.value = 'PUT';
                            submitButton.style.display = 'block';
                            setFieldsReadOnly(false);
                        } else {
                            methodInput.value = '';
                            modalForm.action = '';
                            submitButton.style.display = 'none';
                            setFieldsReadOnly(true);
                        }

                        Modal.querySelector('#MyModalLabel').textContent = isEdit ? 'Edit' : 'Detail';

                        fetch(`{{ route('dashboard.service-management.index') }}/${itemId}`)
                            .then(response => response.json())
                            .then(data => {
                                nameInput.value = data.name;
                                descriptionTextarea.value = data.description;
                                priceInput.value = data.price;
                            });

                    });
                });
            });
        </script>
    @endpush

</x-app-layout>
