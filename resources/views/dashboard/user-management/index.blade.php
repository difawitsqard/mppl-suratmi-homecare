<x-app-layout>
    <x-slot name="header">
        {{ __('User Management') }} {{ '( ' . ucwords($role) . ' )' }}
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
                                    {{ $users->total() < 30 ? 'disabled' : '' }}>
                                    {{ $users->perPage() }} entri per halaman
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownPerPage">
                                    @php
                                        $perPageOptions = [10, 20, 50, 100]; // Opsi jumlah entri per halaman
                                    @endphp
                                    @foreach ($perPageOptions as $page)
                                        @if ($users->perPage() == $page || $users->perPage() == null || $users->total() < $page)
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
                                    {{ !empty(request()->input('search')) ? 'value=' . request()->input('search') . '' : '' }}>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th class="text-center bg-light mr-5" scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nomor Hp</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $num => $user)
                            <tr>
                                <th class="align-middle text-center bg-light px-3" scope="row">
                                    {{ $users->firstItem() + $num }}</th>
                                <th class="align-middle">
                                    <div class="d-flex align-items-center pe-0">
                                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                            width="36px" height="36px" class="rounded-circle shadow-sm" style="object-fit: cover;">
                                        <span class="d-none d-md-block ps-2">{{ $user->name }}</span>
                                    </div>
                                </th>
                                <td class="align-middle">{{ $user->email }}</td>
                                <td class="align-middle">{{ $user->phone_number }}</td>
                                <td class="align-middle text-muted fst-italic fw-bolder">
                                        {{ isset($user->roles[0]->name) ? ucwords($user->roles[0]->name) : 'Unknown' }}
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-primary show-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-id="{{ $user->id }}"
                                            data-url="{{ route('dashboard.user-management.show', $user->id) }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning edit-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-url="{{ route('dashboard.user-management.destroy', $user->id) }}"
                                            data-edit-url="{{ route('dashboard.user-management.update', $user->id) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('dashboard.user-management.destroy', $user->id) }}"
                                            method="POST" class="d-inline" id="deleteForm-{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="if (confirm('Apakah Anda yakin ingin menghapus Data #{{ $users->firstItem() + $num }} ?')) { document.getElementById('deleteForm-{{ $user->id }}').submit(); }">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('modals')
        <div class="modal fade" id="MyModal" tabindex="-1" aria-labelledby="MyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MyModalLabel">Tambah Galeri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card mb-1">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center p-0 mb-1">
                            <img id="profile-image" src="{{ asset('_dashboard\assets\img\avatar.jpg') }}"
                                style="width: 120px; height:120px; object-fit: cover;" class="rounded-circle mb-2">
                            <h4 id="profile-name" class="fw-bold mb-0">name</h4>
                            <p id="profile-role" class="p-0">role</p>
                        </div>
                        <ul class="list-group block">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-5">
                                Bergabung
                                <span class="badge bg-dark rounded-pill" id="profile-join"></span>
                            </li>
                        </ul>
                    </div>
                    <form action="{{ route('dashboard.gallery-management.store') }}" method="POST">
                        <div class="modal-body bg-white">
                            <div class="row g-3">
                                @csrf
                                @method('POST')
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
                                        <select id="role" class="form-select" name="role">
                                            <option>Pilih Role...</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
                                            @endforeach
                                        </select>
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
                                    <textarea class="form-control" id="address" name="address" placeholder="..." rows="3"></textarea>
                                </div>
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
                var inputs = modalForm.querySelectorAll('input, textarea, select');
                var methodInput = modalForm.querySelector('input[name="_method"]');
                var tokenInput = modalForm.querySelector('input[name="_token"]');
                var itemId = modalForm.querySelector('input[name="id"]');

                var profileImage = Modal.querySelector('#profile-image');
                var profileName = Modal.querySelector('#profile-name');
                var profileRole = Modal.querySelector('#profile-role');
                var profileImage = Modal.querySelector('#profile-image');
                var profileJoin = Modal.querySelector('#profile-join');

                var nameInput = modalForm.querySelector('input[name="name"]');
                var roleInput = modalForm.querySelector('select[name="role"]');
                var emailInput = modalForm.querySelector('input[name="email"]');
                var phonenumberInput = modalForm.querySelector('input[name="phone_number"]');
                var addressTextarea = modalForm.querySelector('textarea[name="address"]');
                var submitButton = modalForm.querySelector('button[type="submit"]');

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

                // // Add button click event
                // document.querySelectorAll('.add-button').forEach(function(button) {
                //     button.addEventListener('click', function() {
                //         removeImagePreview();
                //         submitButton.style.display = 'block';
                //         emailInput.parentElement.style.display = 'block'; // Show image input
                //         setFieldsReadOnly(false);
                //         methodInput.value = 'POST';
                //         Modal.querySelector('#MyModalLabel').textContent = 'Tambah Galeri';
                //         modalForm.action = button.getAttribute('data-add-url');
                //         modalForm.reset();
                //         itemId.value = '';
                //     });
                // });

                // Edit button click event
                document.querySelectorAll('.edit-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        submitButton.style.display = 'block';
                        setFieldsReadOnly(true);
                        methodInput.value = 'PUT';
                        Modal.querySelector('#MyModalLabel').textContent = 'Edit User';
                        modalForm.action = button.getAttribute('data-edit-url');
                        modalForm.reset();

                        var url = button.getAttribute('data-url');
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                itemId.value = data.id;
                                nameInput.value = data.name;
                                roleInput.value = data.roles[0].id;
                                profileName.textContent = data.name;
                                profileRole.textContent = data.roles[0].name.replace(/^\w/, c => c
                                    .toUpperCase());
                                profileImage.src = data.profile_photo_url;
                                emailInput.value = data.email;
                                phonenumberInput.value = data.phone_number;
                                addressTextarea.value = data.address;
                                profileJoin.textContent = data.created_at_formatted;

                                let inputs = [roleInput, tokenInput, methodInput];
                                inputs.forEach(input => {
                                    input.readOnly = false;
                                    input.disabled = false;
                                });
                                submitButton.style.display = 'block';
                            })
                            .catch(error => console.error('Error fetching:', error));
                    });
                });

                // Show button click event
                document.querySelectorAll('.show-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var url = button.getAttribute('data-url');
                        submitButton.style.display = 'none';
                        modalForm.reset();
                        setFieldsReadOnly(true);
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                methodInput.value = '';
                                Modal.querySelector('#MyModalLabel').textContent = 'Detail';
                                modalForm.action = '';

                                console.log(data);
                                itemId.value = data.id;
                                nameInput.value = data.name;
                                roleInput.value = data.roles[0].id;
                                profileName.textContent = data.name;
                                profileRole.textContent = data.roles[0].name.replace(/^\w/, c => c
                                    .toUpperCase());
                                profileJoin.textContent = data.created_at_formatted;
                                profileImage.src = data.profile_photo_url;
                                emailInput.value = data.email;
                                phonenumberInput.value = data.phone_number;
                                addressTextarea.value = data.address;
                            })
                            .catch(error => console.error('Error fetching:', error));
                    });
                });

            });
        </script>
    @endpush

</x-app-layout>
