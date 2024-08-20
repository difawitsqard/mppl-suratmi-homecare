<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\CompanyInfo;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $companyInfo = CompanyInfo::first();
        $services = Service::all();
        $testimonials = Testimonial::where('rating', 5)
            ->with([
                'orderService.customer.roles',
                'orderService.therapist.roles',
                'orderService.service'
            ])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $galleries = Gallery::all();
        $faqs = Faq::all();

        return view(
            'landingpage',
            [
                'companyInfo' => $companyInfo,
                'services' => $services,
                'testimonials' => $testimonials,
                'galleries' => $galleries,
                'faqs' => $faqs,
            ]
        );
    }
}
