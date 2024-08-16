<x-app-layout>

    <x-slot name="header">
        {{ __('Service Management') }}
    </x-slot>

    <div class="col-12">
        <div class="card info-card p-5">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal"
                    style="width: 200px">
                Add Service
            </button>

            <table class="table mt-3">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($services as $service)
                    <tr>
                        <th scope="row">{{ $service->id }}</th>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->description }}</td>
                        <td>
                            <a href="#" class="btn btn-warning edit-service-btn" data-bs-toggle="modal"
                               data-bs-target="#editServiceModal" data-id="{{ $service->id }}"
                               data-name="{{ $service->name }}" data-description="{{ $service->description }}">Edit</a>
                            <form action="{{ route('dashboard.service-management.destroy', $service->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-black">
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Tambah Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.service-management.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-black">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editServiceForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit-description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editServiceModal = document.getElementById('editServiceModal');
            const editServiceForm = document.getElementById('editServiceForm');
            const editNameInput = document.getElementById('edit-name');
            const editDescriptionInput = document.getElementById('edit-description');

            editServiceModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const serviceId = button.getAttribute('data-id');
                const serviceName = button.getAttribute('data-name');
                const serviceDescription = button.getAttribute('data-description');

                editServiceForm.action = `/dashboard/service-management/${serviceId}`;
                editNameInput.value = serviceName;
                editDescriptionInput.value = serviceDescription;
            });
        });
    </script>
</x-app-layout>
