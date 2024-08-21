<x-app-layout>
    <x-slot name="header">
        {{ __('Order Service') }}
    </x-slot>

    <div class="col-xl-6">
        @if (auth()->user()->address == null || auth()->user()->phone_number == null)
            <div class="card">
                <div class="card-header text-danger fw-bold">Perhatian !</div>
                <div class="card-body">
                    <p class="card-text mt-3">Lengkapi data diri anda terlebih dahulu sebelum melakukan pemesanan
                        layanan.</p>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('profile.show') }}" class="btn btn-primary">Pengaturan Akun</a>
                </div>
            </div>
        @else
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
                    <form class="row g-3" action="{{ route('dashboard.order-service.store') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select" id="service_id" name="service_id" aria-label="service_id">
                                    <option selected="" disabled>Pilih Layanan</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            data-price="{{ formatRupiah($service->price) }}"
                                            {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}</option>
                                    @endforeach
                                </select>
                                <label for="service_id">Layanan</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="price" class="form-control" id="price" placeholder="price"
                                    value="0" readonly disabled>
                                <label for="price">Harga</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="date" name="date"
                                    value="{{ old('date') }}" placeholder="Tanggal Booking">
                                <label for="date">Tanggal Booking</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Catatan" id="note" name="note" style="height: 155px;">{{ old('note') }}</textarea>
                                <label for="note">Catatan</label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>

                </div>
            </div>
        @endif
    </div>

    <div class="col-xl-6 contact">
        <div class="row">
            @isset($companyInfo->address)
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Alamat</h3>
                        <p>{{ $companyInfo->address }}</p>
                    </div>
                </div>
            @endisset
            @isset($companyInfo->phone)
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-telephone"></i>
                        <h3>Hubungi Kami</h3>
                        <p>{{ $companyInfo->phone }}</p>
                    </div>
                </div>
            @endisset
            @isset($companyInfo->email)
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-envelope"></i>
                        <h3>Email</h3>
                        <p>{{ $companyInfo->email }}</p>
                    </div>
                </div>
            @endisset
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const serviceIdSelect = document.getElementById('service_id');
                const priceInput = document.getElementById('price');

                serviceIdSelect.addEventListener('change', function() {
                    const selectedOption = serviceIdSelect.options[serviceIdSelect.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    priceInput.value = price;
                });
            });
        </script>
    @endpush

</x-app-layout>
