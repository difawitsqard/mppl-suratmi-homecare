<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\CompanyInfo;
use App\Models\Testimonial;
use App\Models\OrderService;
use Illuminate\Http\Request;
use App\Http\Requests\OrderServiceRequest;

class OrderServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.order-service.index', [
            'services' => Service::all(),
            'companyInfo' => CompanyInfo::first(),
        ]);
    }

    public function store(OrderServiceRequest $request)
    {
        OrderService::create($request->validated());
        return redirect()->back()->with('success', 'Pesanan berhasil dibuat.');
    }

    function history(Request $request)
    {
        $perPage = is_numeric($request->perPage) ? $request->perPage :  10;

        if (!empty($request->search)) {
            $orderedServices = OrderService::where('customer_id', auth()->user()->id)->filter()->orderBy('id', 'desc')->paginate($perPage);
            $orderedServices->appends(['search' => $request->search]);
        } else {
            $orderedServices = OrderService::where('customer_id', auth()->user()->id)->orderBy('id', 'desc')->paginate($perPage);
        }
        $orderedServices->load('service', 'testimonial');
        $orderedServices->appends(['perPage' => $perPage]);

        return view('dashboard.order-service.history', [
            'services' => Service::all(),
            'orderedServices' => $orderedServices
        ]);
    }

    public function show(string $id)
    {
        $OrderService = OrderService::where('customer_id', auth()->user()->id)->with('service', 'testimonial')->findOrFail($id);
        return response()->json($OrderService);
    }

    public function update(OrderServiceRequest $request, $id)
    {
        if (!auth()->user()->address || !auth()->user()->phone_number) {
            return redirect()->back()->withErrors(['customer' => 'Lengkapi alamat dan nomor telepon terlebih dahulu.']);
        }

        $OrderService = OrderService::findOrFail($id);
        if ($OrderService->status != 'pending') {
            return redirect()->back()->withErrors(['status' => 'Pesanan sudah di proses, tidak bisa diubah.']);
        }
        $OrderService->update($request->validated());
        return redirect()->back()->with('success', 'Pesanan berhasil diubah.');
    }

    public function rating(Request $request, $oderServiceId)
    {
        Testimonial::create([
            'order_service_id' => $oderServiceId,
            'rating' => $request->rating,
            'content' => $request->content ? $request->content : "",
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Rating berhasil ditambahkan.');
    }
}
