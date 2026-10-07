<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesActivePortfolio;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    use ResolvesActivePortfolio;

    public function index()
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $services = Service::where('portfolio_id', $portfolio->id)->get();

        return view('pages.admin.services.index', compact('services', 'portfolio'));
    }

    public function create()
    {
        if (!$this->activePortfolio()) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        return view('pages.admin.services.create');
    }

    public function store(Request $request)
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $request->validate([
            'icon' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
            'status' => 'required|boolean',
        ]);

        Service::create([
            'user_id' => Auth::id(),
            'portfolio_id' => $portfolio->id,
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

        $service->update($request->only(['icon', 'name', 'detail', 'status']));

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
