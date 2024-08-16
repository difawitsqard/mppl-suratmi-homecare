<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\GalleryManagementRequest;

class GalleryManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = is_numeric($request->perPage) ? $request->perPage :  10;

        if (!empty($request->search)) {
            $galleries = Gallery::filter()->orderBy('id', 'desc')->paginate($perPage);
            $galleries->appends(['search' => $request->search]);
        } else {
            $galleries = Gallery::orderBy('id', 'desc')->paginate($perPage);
        }
        $galleries->appends(['perPage' => $perPage]);

        return view('dashboard.gallery-management.index', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryManagementRequest $request)
    {
        $validated = $request->validated();

        $gallery = new Gallery();
        $gallery->title = $validated['title'];
        $gallery->description = $validated['description'];

        if ($request->hasFile('image')) {
            // //upload stroage 'php artisan storage:link'
            // $imagePath = $request->file('image')->store('images', 'public');
            // $gallery->image_path = $imagePath;

            //upload public
            $image = $validated['image'];
            $imageName = md5(time() . '_' . $image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/images');

            // Periksa apakah folder tujuan ada, jika tidak buat foldernya
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);
            $gallery->image_path = 'images/' . $imageName;
        }

        $gallery->save();

        return redirect()->route('dashboard.gallery-management.index')->with('success', 'Gallery created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json($gallery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryManagementRequest $request, string $id)
    {
        $validated = $request->validated();

        $gallery = Gallery::findOrFail($id);
        $gallery->title = $validated['title'];
        $gallery->description = $validated['description'];

        if ($request->hasFile('image')) {
            if ($gallery->image_path) {
                $imagePath = public_path($gallery->image_path);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $image = $validated['image'];
            $imageName = md5(time() . '_' . $image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/images');

            // Periksa apakah folder tujuan ada, jika tidak buat foldernya
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);
            $gallery->image_path = 'images/' . $imageName;
        }

        $gallery->save();

        return redirect()->route('dashboard.gallery-management.index')->with('success', 'Gallery updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Retrieve the specific service instance
        $gallery = Gallery::findOrFail($id);
        if ($gallery->image_path) {
            $imagePath = public_path($gallery->image_path);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $gallery->delete();
        return redirect()->route('dashboard.gallery-management.index')->with('success', 'Gallery deleted successfully');
    }
}
