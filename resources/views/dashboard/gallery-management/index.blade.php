<x-app-layout>
    <x-slot name="header">
        {{ __('Gallery Management') }}
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
                                    {{ $galleries->total() < 30 ? 'disabled' : '' }}>
                                    {{ $galleries->perPage() }} entri per halaman
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownPerPage">
                                    @php
                                        $perPageOptions = [10, 20, 50, 100]; // Opsi jumlah entri per halaman
                                    @endphp
                                    @foreach ($perPageOptions as $page)
                                        @if ($galleries->perPage() == $page || $galleries->perPage() == null || $galleries->total() < $page)
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
                            data-add-url="{{ route('dashboard.gallery-management.store') }}">
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

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th class="text-center bg-light mr-5" scope="col">#</th>
                            <th scope="col">Pratinjau</th>
                            <th scope="col" style="padding-left: 20px;">Judul</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($galleries as $num => $galleri)
                            <tr>
                                <th class="align-middle text-center bg-light px-3" scope="row">{{ $galleries->firstItem() + $num }}</th>
                                <th class="align-middle">
                                     {{-- <a href="#"><img style="max-width: 100px;" src="{{ Storage::url($galleri->image_path) }}" alt=""></a> --}}
                                    <a href="#">
                                        <img class="rounded mx-auto d-block" style="width: 80px; height: 80px; object-fit: cover;"
                                             src="{{ $galleri->image_url }}"
                                             alt="{{ $galleri->title }}">
                                    </a>
                                </th>
                                <td class="align-middle fw-bold text-muted" style="padding-left: 20px;" width="30%">{{ $galleri->title }}</td>
                                <td class="align-middle" width="50%">{{ $galleri->description }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-primary show-faq-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-id="{{ $galleri->id }}"
                                            data-url="{{ route('dashboard.gallery-management.show', $galleri->id) }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning edit-button"
                                            data-bs-toggle="modal" data-bs-target="#MyModal"
                                            data-id="{{ $galleri->id }}" data-title="{{ $galleri->title }}"
                                            data-desc="{{ $galleri->description }}"
                                            data-img="{{ $galleri->image_path }}"
                                            data-edit-url="{{ route('dashboard.gallery-management.update', $galleri->id) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form
                                            action="{{ route('dashboard.gallery-management.destroy', $galleri->id) }}"
                                            method="POST" class="d-inline" id="deleteForm-{{ $galleri->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="if (confirm('Apakah Anda yakin ingin menghapus Data #{{ $galleries->firstItem() + $num }} ?')) { document.getElementById('deleteForm-{{ $galleri->id }}').submit(); }">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $galleries->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('modals')
        <div class="modal fade" id="MyModal" tabindex="-1" aria-labelledby="MyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MyModalLabel">Tambah Galeri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboard.gallery-management.store') }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            @method('POST')
                            <input type="hidden" id="itemId" name="id">
                            <div class="d-flex justify-content-center">
                                <img id="imagePreview" src="#" class="rounded mb-3" alt="Pratinjau Gambar"
                                    style="display: none; max-height:150px;">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="..." required>
                            </div>
                            <div class="mb-3">
                                <label for="answer" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" placeholder="..." rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*" onchange="previewImage(event)">
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
                var itemId = modalForm.querySelector('input[name="id"]');
                var titleInput = modalForm.querySelector('input[name="title"]');
                var imageInput = modalForm.querySelector('input[name="image"]');
                var descTextarea = modalForm.querySelector('textarea[name="description"]');
                var submitButton = modalForm.querySelector('button[type="submit"]');
                var imgPreview = modalForm.querySelector('#imagePreview');

                // Function to set all fields to read-only & Disabled
                function setFieldsReadOnly(isReadOnly) {
                    inputs.forEach(function(input) {
                        input.readOnly = isReadOnly;
                        input.disabled = isReadOnly;
                    });
                }

                // Function to remove image preview
                function removeImagePreview() {
                    imgPreview.src = '';
                    imgPreview.style.display = 'none';
                }

                // Function to preview image
                function previewImage(event) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        imgPreview.src = reader.result;
                        imgPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }

                // Add button click event
                document.querySelectorAll('.add-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        removeImagePreview();
                        submitButton.style.display = 'block';
                        imageInput.parentElement.style.display = 'block'; // Show image input
                        setFieldsReadOnly(false);
                        methodInput.value = 'POST';
                        Modal.querySelector('#MyModalLabel').textContent = 'Tambah Galeri';
                        modalForm.action = button.getAttribute('data-add-url');
                        modalForm.reset();
                        itemId.value = '';
                    });
                });

                // Edit button click event
                document.querySelectorAll('.edit-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        removeImagePreview();
                        submitButton.style.display = 'block';
                        imageInput.parentElement.style.display = 'block'; // Show image input
                        setFieldsReadOnly(false);
                        methodInput.value = 'PUT';
                        Modal.querySelector('#MyModalLabel').textContent = 'Edit Galeri';
                        modalForm.action = button.getAttribute('data-edit-url');

                        imgPreview.src = "{{ asset('') }}" + "uploads/" + button.getAttribute(
                            'data-img');
                        itemId.value = button.getAttribute('data-id');
                        titleInput.value = button.getAttribute('data-title');
                        descTextarea.value = button.getAttribute('data-desc');

                        imgPreview.style.display = 'block';
                    });
                });

                // Show button click event
                document.querySelectorAll('.show-faq-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var url = button.getAttribute('data-url');
                        submitButton.style.display = 'none';
                        imageInput.parentElement.style.display = 'none'; // Hide image input
                        modalForm.reset();
                        setFieldsReadOnly(true);
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                methodInput.value = '';
                                Modal.querySelector('#MyModalLabel').textContent = 'Detail';
                                modalForm.action = '';

                                itemId.value = data.id;
                                imgPreview.src = "{{ asset('') }}" + "uploads/" + data
                                    .image_path;
                                titleInput.value = data.title;
                                descTextarea.value = data.description;

                                imgPreview.style.display = 'block';
                            })
                            .catch(error => console.error('Error fetching:', error));
                    });
                });

                // Attach previewImage function to image input change event
                imageInput.addEventListener('change', previewImage);
            });
        </script>
    @endpush

</x-app-layout>
