{{--<x-guest-layout>--}}
{{--    <x-authentication-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <x-authentication-card-logo />--}}
{{--        </x-slot>--}}

{{--        <x-validation-errors class="mb-4" />--}}

{{--        <form method="POST" action="{{ route('register') }}">--}}
{{--            @csrf--}}

{{--            <div>--}}
{{--                <x-label for="name" value="{{ __('Name') }}" />--}}
{{--                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-label for="email" value="{{ __('Email') }}" />--}}
{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-label for="password" value="{{ __('Password') }}" />--}}
{{--                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />--}}
{{--                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())--}}
{{--                <div class="mt-4">--}}
{{--                    <x-label for="terms">--}}
{{--                        <div class="flex items-center">--}}
{{--                            <x-checkbox name="terms" id="terms" required />--}}

{{--                            <div class="ms-2">--}}
{{--                                {!! __('I agree to the :terms_of_service and :privacy_policy', [--}}
{{--                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',--}}
{{--                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',--}}
{{--                                ]) !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </x-label>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">--}}
{{--                    {{ __('Already registered?') }}--}}
{{--                </a>--}}

{{--                <x-button class="ms-4">--}}
{{--                    {{ __('Register') }}--}}
{{--                </x-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-authentication-card>--}}
{{--</x-guest-layout>--}}


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Pages / Register - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
        href="_dashboard/assets/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link
        href="_dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css"
        rel="stylesheet"
    />
    <link href="_dashboard/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="_dashboard/assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="_dashboard/assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="_dashboard/assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="_dashboard/assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="_dashboard/assets/css/style.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<main>
    <div class="container">
        <section
            class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4"
        >
            <div class="container">
                <div class="row justify-content-center">
                    <div
                        class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center"
                    >
                        <div class="d-flex justify-content-center py-4">
                            <a
                                href="index.html"
                                class="logo d-flex align-items-center w-auto"
                            >
                                <img src="_dashboard/assets/img/logo.png" alt="" />
                                <span class="d-none d-lg-block">Suratmi Homecare</span>
                            </a>
                        </div>
                        <!-- End Logo -->

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">
                                        Buat Akun
                                    </h5>
                                </div>

                                <form class="row g-3 needs-validation" novalidate>
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Name</label>
                                        <input
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            id="yourName"
                                            required
                                        />
                                        <div class="invalid-feedback">
                                            Please, enter your name!
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Email</label>
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control"
                                            id="yourEmail"
                                            required
                                        />
                                        <div class="invalid-feedback">
                                            Please enter a valid Email adddress!
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label"
                                        >Password</label
                                        >
                                        <input
                                            type="password"
                                            name="password"
                                            class="form-control"
                                            id="yourPassword"
                                            required
                                        />
                                        <div class="invalid-feedback">
                                            Please enter your password!
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                name="terms"
                                                type="checkbox"
                                                value=""
                                                id="acceptTerms"
                                                required
                                            />
                                            <label class="form-check-label" for="acceptTerms"
                                            >Saya setuju dan menerima
                                                <a href="#">syarat dan ketentuan</a></label
                                            >
                                            <div class="invalid-feedback">
                                                You must agree before submitting.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">
                                            Buat Akun
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">
                                            Sudah punya akun ?
                                            <a href="pages-login.html">Masuk</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<!-- End #main -->

<a
    href="#"
    class="back-to-top d-flex align-items-center justify-content-center"
><i class="bi bi-arrow-up-short"></i
    ></a>

<!-- Vendor JS Files -->
<script src="_dashboard/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="_dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="_dashboard/assets/vendor/chart.js/chart.umd.js"></script>
<script src="_dashboard/assets/vendor/echarts/echarts.min.js"></script>
<script src="_dashboard/assets/vendor/quill/quill.js"></script>
<script src="_dashboard/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="_dashboard/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="_dashboard/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="_dashboard/assets/js/main.js"></script>
</body>
</html>
