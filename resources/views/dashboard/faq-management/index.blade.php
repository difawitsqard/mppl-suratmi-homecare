<x-app-layout>
    <x-slot name="header">
        {{ __('FAQ Management') }}
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
                                    {{ $faqs->total() < 30 ? 'disabled' : '' }}>
                                    {{ $faqs->perPage() }} entri per halaman
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownPerPage">
                                    @php
                                        $perPageOptions = [10, 20, 50, 100]; // Opsi jumlah entri per halaman
                                    @endphp
                                    @foreach ($perPageOptions as $page)
                                        @if ($faqs->perPage() == $page || $faqs->perPage() == null || $faqs->total() < $page)
                                            @continue
                                        @endif
                                        <a class="dropdown-item"
                                            href="{{ request()->url() . '?' . http_build_query(array_merge(request()->except(['page', 'perPage']), ['perPage' => $page])) }}">{{ $page }}
                                            entri per halaman</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mb-1 add-faq-button" data-bs-toggle="modal"
                            data-bs-target="#FAQModal" data-add-url="{{ route('dashboard.faq-management.store') }}">
                            <i class="bi bi-plus"></i> Tambah
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
                            <th scope="col">Pertanyaan</th>
                            <th scope="col">Jawaban</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $num => $faq)
                            <tr>
                                <th scope="row">{{ $faqs->firstItem() + $num }}</th>
                                <td>{{ $faq->question }}</td>
                                <td>{{ $faq->answer }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-primary show-faq-button"
                                            data-bs-toggle="modal" data-bs-target="#FAQModal"
                                            data-id="{{ $faq->id }}"
                                            data-url="{{ route('dashboard.faq-management.show', $faq->id) }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning edit-faq-button"
                                            data-bs-toggle="modal" data-bs-target="#FAQModal"
                                            data-id="{{ $faq->id }}" data-question="{{ $faq->question }}"
                                            data-answer="{{ $faq->answer }}"
                                            data-edit-url="{{ route('dashboard.faq-management.update', $faq->id) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('dashboard.faq-management.destroy', $faq->id) }}"
                                            method="POST" class="d-inline" id="deleteForm-{{ $faq->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="if (confirm('Apakah Anda yakin ingin menghapus Data #{{ $faqs->firstItem() + $num }} ?')) { document.getElementById('deleteForm-{{ $faq->id }}').submit(); }">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $faqs->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('modals')
        <div class="modal fade" id="FAQModal" tabindex="-1" aria-labelledby="FAQModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="FAQModalLabel">Tambah FAQ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboard.faq-management.store') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            @method('POST')
                            <input type="hidden" id="faqId" name="id">
                            <div class="mb-3">
                                <label for="question" class="form-label">Pertanyaan</label>
                                <input type="text" class="form-control" id="question" name="question" placeholder="..."
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="answer" class="form-label">Jawaban</label>
                                <textarea class="form-control" id="answer" name="answer" placeholder="..." rows="5"></textarea>
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
                var Modal = document.querySelector('#FAQModal');
                var modalForm = Modal.querySelector('form');
                var inputs = modalForm.querySelectorAll('input, textarea');
                var methodInput = modalForm.querySelector('input[name="_method"]');
                var faqIdInput = modalForm.querySelector('input[name="id"]');
                var questionInput = modalForm.querySelector('input[name="question"]');
                var answerTextarea = modalForm.querySelector('textarea[name="answer"]');
                var submitButton = modalForm.querySelector('button[type="submit"]');

                // Function to set all fields to read-only & Disabled
                function setFieldsReadOnly(isReadOnly) {
                    inputs.forEach(function(input) {
                        input.readOnly = isReadOnly;
                        input.disabled = isReadOnly;
                    });
                }

                document.querySelectorAll('.add-faq-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        submitButton.style.display = 'block';
                        setFieldsReadOnly(false);
                        methodInput.value = 'POST';
                        Modal.querySelector('#FAQModalLabel').textContent = 'Tambah FAQ';
                        modalForm.action = button.getAttribute('data-add-url');
                        modalForm.reset();
                        faqIdInput.value = '';
                    });
                });

                document.querySelectorAll('.edit-faq-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        submitButton.style.display = 'block';
                        setFieldsReadOnly(false);
                        methodInput.value = 'PUT';
                        Modal.querySelector('#FAQModalLabel').textContent = 'Edit FAQ';
                        modalForm.action = button.getAttribute('data-edit-url');

                        faqIdInput.value = button.getAttribute('data-id');
                        questionInput.value = button.getAttribute('data-question');
                        answerTextarea.value = button.getAttribute('data-answer');
                    });
                });

                document.querySelectorAll('.show-faq-button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var url = button.getAttribute('data-url');
                        submitButton.style.display = 'none';
                        modalForm.reset();
                        setFieldsReadOnly(true);
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                methodInput.value = '';
                                Modal.querySelector('#FAQModalLabel').textContent = 'Detail FAQ';
                                modalForm.action = '';

                                faqIdInput.value = data.id;
                                questionInput.value = data.question;
                                answerTextarea.value = data.answer;
                            })
                            .catch(error => console.error('Error fetching FAQ:', error));
                    });
                });
            });
        </script>
    @endpush

</x-app-layout>
