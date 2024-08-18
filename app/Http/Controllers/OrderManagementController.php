<?php

namespace App\Http\Controllers;

use App\Models\OrderService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = is_numeric($request->perPage) ? $request->perPage :  10;
        if (!empty($request->search)) {
            $OrderServices = OrderService::filter()->orderBy('created_at', 'desc')->paginate($perPage);
            $OrderServices->appends(['search' => $request->search]);
        } else {
            $OrderServices = OrderService::orderBy('created_at', 'desc')->paginate($perPage);
        }
        $OrderServices->load('service', 'user');
        $OrderServices->appends(['perPage' => $perPage]);

        return view('dashboard.order-management.index', [
            'OrderServices' => $OrderServices,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $OrderService = OrderService::findOrFail($id);
        $OrderService->load('service', 'user');
        return response()->json($OrderService);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $validStatuses = ['pending', 'approved', 'completed', 'rejected', 'canceled'];

        $request->validate([
            'status' => ['required', 'string', Rule::in($validStatuses)],
        ]);

        $order = OrderService::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return  response()->json(['status' => 'success', 'message' => 'Status updated successfully']);
    }
}
