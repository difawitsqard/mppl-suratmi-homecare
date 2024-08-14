<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('_dashboard/assets/img/logo.png') }}" alt="" />
                        <span class="d-none d-lg-block">Suratmi Homecare</span>
                    </a>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">
                                Buat Akun
                            </h5>
                        </div>

                        <form method="POST" class="row g-3 needs-validation" action="{{ route('register') }}"
                            novalidate>
                            @csrf
                            <div class="col-12">
                                <label for="yourName" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="yourName"
                                    value="{{ old('name') }}" required />
                                <div class="invalid-feedback">
                                    Please, enter your name!
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="yourEmail" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="yourEmail" required />
                                <div class="invalid-feedback">
                                    Please enter a valid Email adddress!
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="yourPassword"
                                    required />
                                <div class="invalid-feedback">
                                    Please enter your password!
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="yourPasswordConfirm" class="form-label">Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="yourPasswordConfirm" required />
                                <div class="invalid-feedback">
                                    Please enter your password!
                                </div>
                            </div>

                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" name="terms" type="checkbox" value=""
                                            id="acceptTerms" required />
                                        <label class="form-check-label" for="acceptTerms">Saya setuju dan menerima
                                            <a href="#">syarat dan ketentuan</a></label>
                                        <div class="invalid-feedback">
                                            You must agree before submitting.
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="mt-4">
                                    <x-label for="terms">
                                        <div class="flex items-center">
                                            <x-checkbox name="terms" id="terms" required />

                                            <div class="ms-2">
                                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                    'terms_of_service' =>
                                                        '<a target="_blank" href="' .
                                                        route('terms.show') .
                                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                        __('Terms of Service') .
                                                        '</a>',
                                                    'privacy_policy' =>
                                                        '<a target="_blank" href="' .
                                                        route('policy.show') .
                                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                        __('Privacy Policy') .
                                                        '</a>',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </x-label>
                                </div> --}}
                            @endif


                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">
                                    {{ __('Buat Akun') }}
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">
                                    Sudah punya akun ?
                                    <a href="{{ route('login') }}">Masuk</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
