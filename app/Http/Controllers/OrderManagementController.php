<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OrderService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
        $OrderServices->load('service', 'customer', 'therapist');
        $OrderServices->appends(['perPage' => $perPage]);

        return view('dashboard.order-management.index', [
            'OrderServices' => $OrderServices,
            'therapists' => User::role('therapist')->get()
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
        $OrderService->load('service', 'customer', 'therapist');
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

        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string', Rule::in($validStatuses)],
            'therapist_id' => ['required_if:status,approved', 'exists:users,id']
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 400);
        }

        $order = OrderService::findOrFail($id);
        $order->status = $request->status;
        if ($request->status === 'approved') {
            $order->therapist_id = $request->therapist_id;
        }
        $order->save();

        return response()->json(['status' => 'success', 'message' => 'Status updated successfully']);
    }
}
