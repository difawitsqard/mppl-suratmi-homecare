<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceManagementRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceManagementController extends Controller
{
    public function __construct(private readonly Service $service) {}

    public function index(Request $request)
    {
        $perPage = is_numeric($request->perPage) ? $request->perPage :  10;

        if (!empty($request->search)) {
            $services = Service::filter()->orderBy('id', 'desc')->paginate($perPage);
            $services->appends(['search' => $request->search]);
        } else {
            $services = Service::orderBy('id', 'desc')->paginate($perPage);
        }
        $services->appends(['perPage' => $perPage]);

        return view('dashboard.service-management.index', compact('services'));
    }

    public function store(ServiceManagementRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('dashboard.service-management.index');
    }

    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(ServiceManagementRequest $request, $id)
    {
        // Retrieve the specific service instance
        $service = $this->service->findOrFail($id);

        // Update the service instance with the validated request data
        $service->update($request->validated());

        // Save the updated service instance
        $service->save();

        return redirect()->route('dashboard.service-management.index');
    }


    public function destroy($id)
    {
        // Retrieve the specific service instance
        $service = $this->service->findOrFail($id);

        // Delete the service instance
        $service->delete();

        return redirect()->route('dashboard.service-management.index');
    }
}
