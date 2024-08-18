<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('_dashboard/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('_dashboard/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('_dashboard/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('_dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('_dashboard/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('_dashboard/assets/css/style.css') }}" rel="stylesheet">

    @stack('styles')

</head>

<body>

    <!-- Header -->
    @include('layouts.partials.dashboard.header')
    <!-- Sidebar -->
    @include('layouts.partials.dashboard.sidebar')

    <main id="main" class="main">

        <div class="pagetitle">
            <!-- Page Heading -->
            <h1>{{ isset($header) ? $header : 'Unknown' }}</h1>
            <x-dashboard.breadcrumb />
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                {{ $slot }}
            </div>
        </section>

    </main>
    <!-- End #main -->

    <div style="color: #212529;">
        @stack('modals')
    </div>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('_dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('_dashboard/assets/js/main.js') }}"></script>

    @vite('resources/js/app.js')

    @stack('scripts')
</body>

</html>
