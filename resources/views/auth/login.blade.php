
<x-guest-layout>
    <x-slot name="title">
        {{ __('Login') }}
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('_dashboard/assets/img/logo.png') }}" alt="" />
                        <span class="d-none d-lg-block">{{ getCompanyInfo()->name ?? 'This Company'}}</span>
                    </a>
                </div>
                <!-- End Logo -->
    
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                            <p class="text-center small">
                                Masukan email & password untuk login
                            </p>
                        </div>
    
                        @session('status')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ $value }}
                        </div>
                    @endsession
    
                        <form method="POST" class="row g-3 needs-validation" action="{{ route('login') }}" novalidate>
                            @csrf
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <input type="email" name="email" class="form-control" id="email" :value="old('email')" required autofocus autocomplete="username" />
                                    <div class="invalid-feedback">
                                        Please enter your email.
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    id="yourPassword" required />
                                <div class="invalid-feedback">
                                    Please enter your password!
                                </div>
                            </div>
    
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        value="true" id="rememberMe" />
                                    <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">
                                    Login
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">
                                    Belum Punya akun ?
                                    <a href="{{ route('register') }}">buat akun</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-guest-layout>