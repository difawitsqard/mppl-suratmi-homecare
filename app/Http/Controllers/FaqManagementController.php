<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqManagementRequest;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = is_numeric($request->perPage) ? $request->perPage :  10;

        if (!empty($request->search)) {
            $faqs = Faq::filter()->orderBy('id', 'desc')->paginate($perPage);
            $faqs->appends(['search' => $request->search]);
        } else {
            $faqs = Faq::orderBy('id', 'desc')->paginate($perPage);
        }
        $faqs->appends(['perPage' => $perPage]);

        return view('dashboard.faq-management.index', compact('faqs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqManagementRequest $request)
    {
        Faq::create($request->validated());
        return redirect()->route('dashboard.faq-management.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $FAQ = FAQ::findOrFail($id);
        return response()->json($FAQ);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqManagementRequest $request, string $id)
    {
        // Retrieve the specific service instance
        $FAQ = Faq::findOrFail($id);
        // Update the service instance with the validated request data
        $FAQ->update($request->validated());
        // Save the updated service instance
        $FAQ->save();

        return redirect()->route('dashboard.faq-management.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Retrieve the specific service instance
        $FAQ = Faq::findOrFail($id);

        // Delete the service instance
        $FAQ->delete();

        return redirect()->route('dashboard.faq-management.index');
    }
}
