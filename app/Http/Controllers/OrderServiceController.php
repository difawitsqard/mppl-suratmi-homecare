<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderServiceRequest;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class OrderServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.order-service.index', [
            'services' => Service::all(),
            'orderedServices' => OrderService::with('service')
                ->with('testimonial')
                ->where('customer_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    public function store(OrderServiceRequest $request)
    {
        OrderService::create($request->validated());

        return redirect()->route('dashboard.order-service.index');
    }

    public function rating(Request $request, $oderServiceId)
    {
        Testimonial::created([
            'order_service_id' => $oderServiceId,
            'rating' => $request->rating,
            'content' => $request->review,
        ]);

        return redirect()->route('dashboard.order-service.index');
    }
}
