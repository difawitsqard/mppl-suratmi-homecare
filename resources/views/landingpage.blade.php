<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $companyInfo->name ?? 'Company Name' }}</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="{{ asset('_landingpage/assets/img/favicon.png') }}" rel="icon" />
    <link href="{{ asset('_landingpage/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <!-- Vendor CSS Files -->
    <link href="{{ asset('_landingpage/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('_landingpage/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('_landingpage/assets/vendor/aos/aos.css') }}" rel="stylesheet" />
    <link href="{{ asset('_landingpage/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('_landingpage/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="{{ asset('_landingpage/assets/css/main.css') }}" rel="stylesheet" />
</head>

<body class="index-page">
    <header id="header" class="header sticky-top">
        <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    @isset($companyInfo->email)
                        <i class="bi bi-envelope d-flex align-items-center">
                            <a href="mailto:{{ $companyInfo->email }}">{{ $companyInfo->email }}</a>
                        </i>
                    @endisset
                    @isset($companyInfo->phone)
                        <i class="bi bi-phone d-flex align-items-center ms-4"><span>{{ $companyInfo->phone }}</span></i>
                    @endisset
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    @isset($companyInfo->facebook)
                        <a href="https://facebook.com/{{ $companyInfo->facebook }}" target="_blank"><i
                                class="bi bi-facebook"></i></a>
                    @endisset
                    @isset($companyInfo->whatsapp)
                        <a href="https://api.whatsapp.com/send?phone={{ $companyInfo->whatsapp }}&text=Hallo"
                            target="_blank"><i class="bi bi-whatsapp"></i></a>
                    @endisset
                    @isset($companyInfo->instagram)
                        <a href="https://instagram.com/{{ $companyInfo->instagram }}" target="_blank"><i
                                class="bi bi-instagram"></i></a>
                    @endisset

                </div>
            </div>
        </div>
        <!-- End Top Bar -->

        <div class="branding d-flex align-items-cente">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="{{ route('landingpage') }}" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <!-- <img src="{{ asset('_landingpage/assets/img/logo.png') }}" alt=""> -->
                    <h1 class="sitename">{{ $companyInfo->name ?? 'Company Name' }}</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="#hero" class="active">Home</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#services">Layanan</a></li>
                        <li><a href="#pricing">Harga</a></li>
                        <li><a href="#galeri">Galeri</a></li>
                        <li><a href="#contact">Kontak</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>
            </div>
        </div>
    </header>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section light-background">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="zoom-out">
                        @php
                            $companyName = $companyInfo->name ?? 'Company Name';
                            $words = explode(' ', $companyName);
                            $lastWord = array_pop($words);
                        @endphp
                        @if (count($words) > 0)
                            <h1> {{ implode(' ', $words) }} <span>{{ $lastWord }}</span></h1>
                        @else
                            <h1> {{ $lastWord }}</h1>
                        @endif
                        <p>{{ $companyInfo->tagline ?? 'Tagline' }}</p>
                        <div class="d-flex">
                            <a href="#about" class="btn-get-started">Cari Tahu Lebih Lanjut</a>
                            {{-- <a href="https://youtu.be/bCSgj1NG2xU"
                                class="glightbox btn-watch-video d-flex align-items-center"><i
                                    class="bi bi-play-circle"></i><span>Tonton Video</span></a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Tentang</h2>
                <p>
                    <span>Cari Tahu</span>
                    <span class="description-title">Tentang Kami</span>
                </p>
            </div>
            <!-- End Section Title -->

            <div class="container">
                <div class="row gy-3">
                    {{-- <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ asset('_landingpage/assets/img/about-example.jpg') }}" alt=""
                            class="img-fluid" />
                    </div> --}}

                    <div class="col-lg-12 d-flex flex-column justify-content-center" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="about-content ps-0 ps-lg-3">
                            {!! $companyInfo->about_us ?? '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /About Section -->

        <!-- comunity Section -->
        <section id="comunity" class="clients section">
            <div class="container section-title mb-0 pb-4" data-aos="fade-up">
                <h2>Komunitas</h2>
                <p>
                    <span class="description-title">{{ $companyInfo->name ?? 'Company Name' }}</span>
                    <br>
                    <span>Anggota Dari Komunitas</span>
                </p>
            </div>
            <div class="container">

                <div class="swiper swiper-comunity init-swiper">

                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (1).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (2).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (3).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (4).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (5).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (6).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (7).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (8).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (9).jpeg') }}" class="img-fluid">
                        </div>
                        <div class="swiper-slide"><img
                                src="{{ asset('_dashboard/assets/img/comunity/logo (10).jpeg') }}" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>

        </section><!-- /Clients Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Layanan</h2>
                <p>
                    <span>Daftar</span>
                    <span class="description-title">Layanan</span>
                </p>
            </div>
            <!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">

                    @foreach ($services as $service)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="service-item position-relative">
                                <div class="icon">
                                    <i class="bi bi-clipboard-check"></i>
                                </div>
                                <a href="#" class="stretched-link">
                                    <h3>{{ $service->name }}</h3>
                                </a>
                                <p>
                                    {{ $service->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Service Item -->
                </div>
            </div>
        </section>
        <!-- /Services Section -->

        <!-- Pricing Section -->
        <section id="pricing" class="pricing section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Harga</h2>
                <p>
                    <span>Daftar</span>
                    <span class="description-title">Harga</span>
                </p>
            </div>
            <!-- End Section Title -->

            <div class="container">
                <div class="row gy-3">
                    @foreach ($services as $service)
                        <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="400">
                            <div class="pricing-item">
                                {{-- <span class="advanced">Komplit</span> --}}
                                <h3>{{ $service->name }}</h3>
                                <h4><sup>Rp</sup>{{ number_format($service->price, 0, ',', '.') }}</h4>
                                {{-- <ul>
                                <li>Bekam</li>
                                <li>Kretek</li>
                                <li>Totok</li>
                            </ul> --}}
                                <div class="btn-wrap">
                                    <a href="{{ route('login') }}" class="btn-buy">Pesan</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Pricing Item -->
                </div>
            </div>
        </section>
        <!-- /Pricing Section -->

        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials section dark-background">
            <img src="{{ asset('_landingpage/assets/img/testimonials-example-bg.jpg') }}" class="testimonials-bg"
                alt="" />

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-testimoni swiper init-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $testimoni)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset($testimoni->OrderService->customer->profile_photo_url) }}"
                                        class="testimonial-img"
                                        alt="{{ $testimoni->OrderService->customer->name }}" />
                                    <h3>{{ $testimoni->OrderService->customer->name }}</h3>
                                    <h4>{{ $testimoni->OrderService->customer->roles[0]->name }}</h4>
                                    <div class="stars">
                                        @for ($i = 0; $i < $testimoni->rating; $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                    </div>
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>
                                            {{ $testimoni->content }}
                                        </span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <!-- End testimonial item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
        <!-- /Testimonials Section -->

        <!-- Galeri Section -->
        <section id="galeri" class="portfolio section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Galeri</h2>
                <p>
                    <span>Daftar</span>
                    <span class="description-title">Galeri</span>
                </p>
            </div>
            <!-- End Section Title -->

            <div class="container">
                <div class="isotope-layout" data-default-filter="*" data-layout="masonry"
                    data-sort="original-order">
                    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                        @foreach ($galleries as $galleri)
                            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                                <img src="{{ $galleri->image_url }}" class="img-fluid"
                                    alt="{{ $galleri->title }}" />
                                <div class="portfolio-info">
                                    <h4>{{ $galleri->title }}</h4>
                                    <p>{{ $galleri->description }}</p>
                                    <a href="{{ $galleri->image_url }}" title="{{ $galleri->title }}"
                                        data-gallery="gallery-{{ $galleri->id }}" class="glightbox preview-link"><i
                                            class="bi bi-zoom-in"></i></a>
                                </div>
                            </div>
                        @endforeach
                        <!-- End Portfolio Item -->

                    </div>
                    <!-- End Portfolio Container -->
                </div>
            </div>
        </section>
        <!-- /Portfolio Section -->

        <!-- Faq Section -->
        <section id="faq" class="faq section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>F.A.Q</h2>
                <p>
                    <span class="description-title">Pertanyaan</span>
                    <span>yang Sering Diajukan</span>
                </p>
            </div>
            <!-- End Section Title -->

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">
                        <div class="faq-container">

                            @foreach ($faqs as $key => $faq)
                                <div class="faq-item {{ $key == 0 ? 'faq-active' : '' }}">
                                    <h3>{{ $faq->question }}</h3>
                                    <div class="faq-content">
                                        <p>
                                            {{ $faq->answer }}
                                        </p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <!-- End Faq Column-->
                </div>
            </div>
        </section>
        <!-- /Faq Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section light-background">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak</h2>
                <p>
                    <span>Hubungi</span>
                    <span class="description-title">Kami</span>
                </p>
            </div>
            <!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-5">
                        <div class="info-wrap">


                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3>Alamat</h3>
                                    <p>{{ $companyInfo->address ?? '123 Company St, City, Country' }}</p>
                                </div>
                            </div>

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Telepon</h3>
                                    <p>{{ $companyInfo->phone ?? '08XXXXXXXXXX' }}</p>
                                </div>
                            </div>
                            <!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email</h3>
                                    <p>{{ $companyInfo->email ?? 'info@example.com' }}</p>
                                </div>
                            </div>
                            <!-- End Info Item -->

                            {{-- <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus"
                                frameborder="0" style="border: 0; width: 100%; height: 270px" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label for="name-field" class="pb-2">Your Name</label>
                                    <input type="text" name="name" id="name-field" class="form-control"
                                        required="" />
                                </div>

                                <div class="col-md-6">
                                    <label for="email-field" class="pb-2">Your Email</label>
                                    <input type="email" class="form-control" name="email" id="email-field"
                                        required="" />
                                </div>

                                <div class="col-md-12">
                                    <label for="subject-field" class="pb-2">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject-field"
                                        required="" />
                                </div>

                                <div class="col-md-12">
                                    <label for="message-field" class="pb-2">Message</label>
                                    <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">
                                        Your message has been sent. Thank you!
                                    </div>

                                    <button type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End Contact Form -->
                </div>
            </div>
        </section>
        <!-- /Contact Section -->
    </main>

    <footer id="footer" class="footer">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-6 col-md-6 footer-about">
                    <a href="{{ route('landingpage') }}" class="d-flex align-items-center">
                        <span class="sitename">Suratmi Homecare</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>{{ $companyInfo->address ?? '123 Company St, City, Country' }}</p>
                        <p class="mt-3">
                            <strong>Telepon:</strong> <span>{{ $companyInfo->phone ?? '08XXXXXXXXXX' }}</span>
                        </p>
                        <p><strong>Email:</strong> <span>{{ $companyInfo->email ?? 'info@example.com' }}</span></p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <h4>Follow Us</h4>
                    <div class="social-links d-flex">
                        @isset($companyInfo->facebook)
                            <a href="https://facebook.com/{{ $companyInfo->facebook }}" target="_blank"><i
                                    class="bi bi-facebook"></i></a>
                        @endisset
                        @isset($companyInfo->whatsapp)
                            <a href="https://api.whatsapp.com/send?phone={{ $companyInfo->whatsapp }}&text=Hallo"
                                target="_blank"><i class="bi bi-whatsapp"></i></a>
                        @endisset
                        @isset($companyInfo->instagram)
                            <a href="https://instagram.com/{{ $companyInfo->instagram }}" target="_blank"><i
                                    class="bi bi-instagram"></i></a>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('_landingpage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('_landingpage/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('_landingpage/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('_landingpage/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('_landingpage/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('_landingpage/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('_landingpage/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('_landingpage/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('_landingpage/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('_landingpage/assets/js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.swiper-comunity', {
                loop: true,
                speed: 600,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                slidesPerView: 'auto',
                pagination: {
                    el: '.swiper-comunity .swiper-pagination',
                    type: 'bullets',
                    clickable: true,
                    dynamicBullets: true
                },
                breakpoints: {
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 40
                    },
                    480: {
                        slidesPerView: 3,
                        spaceBetween: 60
                    },
                    640: {
                        slidesPerView: 4,
                        spaceBetween: 80
                    },
                    992: {
                        slidesPerView: 6,
                        spaceBetween: 120
                    }
                }
            });

            new Swiper('.swiper-testimoni', {
                loop: true,
                speed: 600,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                slidesPerView: 1,
                pagination: {
                    el: '.swiper-testimoni .swiper-pagination',
                    type: 'bullets',
                    clickable: true
                }
            });

        });
    </script>
</body>

</html>
