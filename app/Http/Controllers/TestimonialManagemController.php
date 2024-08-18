<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialManagemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = is_numeric($request->perPage) ? $request->perPage :  10;
        if (!empty($request->search)) {
            $Testimonials = Testimonial::filter()->with(['orderService.user'])->orderBy('created_at', 'desc')->paginate($perPage);
            $Testimonials->appends(['search' => $request->search]);
        } else {
            $Testimonials = Testimonial::with(['orderService.user'])->orderBy('created_at', 'desc')->paginate($perPage);
        }
        $Testimonials->appends(['perPage' => $perPage]);

        return view('dashboard.testimonial-management.index', [
            'Testimonials' => $Testimonials,
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
        $Testimonial = Testimonial::with(['orderService.user', 'orderService.service'])->findOrFail($id);
        return response()->json($Testimonial);
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
}
