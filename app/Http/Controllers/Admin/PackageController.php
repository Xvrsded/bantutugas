<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use App\Models\Service;
use App\Models\Addon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    /**
     * Display all packages grouped by service
     */
    public function index()
    {
        $services = Service::with(['packages' => function($query) {
            $query->orderBy('sort_order');
        }])->get();
        
        return view('admin.packages.index', compact('services'));
    }

    /**
     * Show form to create new package
     */
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        return view('admin.packages.form', compact('services'));
    }

    /**
     * Store new package
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:packages',
            'price_per_unit' => 'required|numeric|min:0|decimal:0,2',
            'description' => 'required|string',
            'features' => 'required|array|min:1',
            'min_quantity' => 'required|integer|min:1',
        ]);

        $validated['features'] = $request->features;
        
        Package::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil dibuat!');
    }

    /**
     * Show edit form for package
     */
    public function edit(Package $package)
    {
        $services = Service::where('is_active', true)->get();
        return view('admin.packages.form', compact('package', 'services'));
    }

    /**
     * Update package
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:packages,slug,' . $package->id,
            'price_per_unit' => 'required|numeric|min:0|decimal:0,2',
            'description' => 'required|string',
            'features' => 'required|array|min:1',
            'min_quantity' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['features'] = $request->features;
        
        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil diperbarui!');
    }

    /**
     * Delete package
     */
    public function destroy(Package $package)
    {
        // Check if package has active orders
        if ($package->orders()->where('status', '!=', 'completed')->exists()) {
            return back()->with('error', 'Tidak bisa menghapus paket yang masih ada ordernya!');
        }

        $package->delete();
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil dihapus!');
    }

    /**
     * Bulk update package prices (yearly adjustment, seasonal, etc)
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'multiplier' => 'required|numeric|min:0.1|max:5',
            'apply_to' => 'required|in:all,hemat,standar,premium',
        ]);

        $query = Package::query();

        if ($request->service_id) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->apply_to !== 'all') {
            $query->where('slug', $request->apply_to);
        }

        // Update prices
        $packages = $query->get();
        foreach ($packages as $package) {
            $package->price_per_unit = round($package->price_per_unit * $request->multiplier, 2);
            $package->save();
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Harga paket berhasil diperbarui untuk ' . count($packages) . ' paket!');
    }
}
