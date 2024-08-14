<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceManagementRequest;
use App\Models\Service;

class ServiceManagementController extends Controller
{
    public function __construct(private readonly Service $service)
    {
    }

    public function index()
    {
        return view('service-management.index', [
            'services' => $this->service->getAll(),
        ]);
    }

    public function store(ServiceManagementRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('dashboard.service-management.index');
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
