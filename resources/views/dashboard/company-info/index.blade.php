<x-app-layout>
    <x-slot name="header">
        {{ __('Company Info') }}
    </x-slot>

    @push('styles')
        <link href="{{ asset('_dashboard/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('_dashboard/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    @endpush


    <div class="col-lg-12">
        @if ($errors->any())
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible mb-3 fade show" role="alert">
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
            <div class="alert alert-success bg-success text-light border-0 alert-dismissible mb-3 fade show"
                role="alert">
                <b>Ok!</b> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('dashboard.company-info.create_or_update') }}" id="form-company-info" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Info Perusahaan</h5>
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label">Nama Perusahaan</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ old('name') ?? ($CompanyInfo->name ?? '') }}" placeholder="This company"  maxlength="55">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="short_name" class="form-label">Nama Pendek Perusahaan</label>
                                <input type="text" name="short_name" class="form-control" id="short_name"
                                    value="{{ old('short_name') ?? ($CompanyInfo->short_name ?? '') }}" placeholder="TCompany ( Optional )" maxlength="16">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="tagline" class="form-label">Tagline Perusahaan</label>
                                <input type="text" name="tagline" class="form-control" value="{{ old('tagline') ?? ($CompanyInfo->tagline ?? '') }}" placeholder="Your Trusted Partner for Success">
                            </div>
                            <!-- Quill Editor Bubble -->
                            <p class="mb-2">Tentang Perusahaan</p>
                            <div class="company-about bg-light">
                                {!! old('about_us') ?? ($CompanyInfo->about_us ?? '') !!}
                            </div>
                            <input type="hidden" name="about_us" id="about_us">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Informasi lainnya</h5>

                            <div class="row mb-3">
                                <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="address" class="form-control" id="address" rows="3" placeholder="123 Company St, City, Country">{{ old('address') ?? ($CompanyInfo->address ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email') ?? ($CompanyInfo->email ?? '') }}" placeholder="info@example.com">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">Telepon</label>
                                <div class="col-sm-10">
                                    <input type="text" name="phone" class="form-control" id="phone"
                                        value="{{ old('phone') ?? ($CompanyInfo->phone ?? '') }}" placeholder="0812XXXXXXXX" >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="whatsapp" class="col-sm-2 col-form-label">WhatsApp</label>
                                <div class="col-sm-10">
                                    <input type="whatsapp" name="whatsapp" class="form-control" id="whatsapp"
                                        value="{{ old('whatsapp') ?? ($CompanyInfo->whatsapp ?? '') }}" placeholder="0812XXXXXXXX">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                                <div class="col-sm-10">
                                    <input type="instagram" name="instagram" class="form-control" id="instagram"
                                        value="{{ old('instagram') ?? ($CompanyInfo->instagram ?? '') }}" placeholder="Username instagram">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary ms-2">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="{{ asset('_dashboard/assets/vendor/quill/quill.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var quill = new Quill('.company-about', {
                    theme: 'snow'
                });
                document.querySelector('.company-about .ql-editor').style.minHeight = '180px';
                document.getElementById('form-company-info').addEventListener('submit', function() {
                    document.getElementById('about_us').value = quill.root.innerHTML;
                });
            });
        </script>
    @endpush

</x-app-layout>
