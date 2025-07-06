<?php

// app/Http/Controllers/Admin/ServiceController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('user_id', Auth::id())->get();
        return view('pages.admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('pages.admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
            'status' => 'required|boolean',
        ]);

        Service::create([
            'user_id' => Auth::id(),
            'icon' => $request->icon,
            'name' => $request->name,
            'detail' => $request->detail,
            'status' => $request->status,
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('pages.admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'icon' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function show(Service $service)
    {
        return view('pages.admin.services.show', compact('service'));
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}


