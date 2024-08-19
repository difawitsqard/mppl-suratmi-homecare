<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderServiceRequest;
use App\Models\OrderService;
use App\Models\Service;
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
                ->where('user_id', auth()->id())
                ->get(),
        ]);
    }

    public function store(OrderServiceRequest $request)
    {
        OrderService::create($request->validated());

        return redirect()->route('dashboard.order-service.index');
    }
}
