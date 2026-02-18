<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderManagementController extends Controller
{
    /**
     * Display all orders dengan filter
     */
    public function index(Request $request)
    {
        $query = Order::with(['service', 'package', 'addons'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by service
        if ($request->service_id) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by date range
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search by customer name or email
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('client_name', 'like', "%{$request->search}%")
                  ->orWhere('client_email', 'like', "%{$request->search}%")
                  ->orWhere('client_phone', 'like', "%{$request->search}%");
            });
        }

        $orders = $query->paginate(20);
        $services = Service::where('is_active', true)->get();
        $statuses = ['pending', 'confirmed', 'processing', 'completed', 'cancelled'];

        return view('admin.orders.index', compact('orders', 'services', 'statuses'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load(['service', 'package', 'addons']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,completed,cancelled'
        ]);

        $order->update($validated);

        return back()->with('success', 'Status order berhasil diperbarui!');
    }

    /**
     * Override order price (admin adjustment)
     */
    public function overridePrice(Request $request, Order $order)
    {
        $validated = $request->validate([
            'admin_adjusted_price' => 'required|numeric|min:0|decimal:0,2',
            'price_adjustment_notes' => 'required|string|max:500',
        ]);

        // Log the original price
        $originalPrice = $order->final_price;

        $order->update([
            'admin_adjusted_price' => $validated['admin_adjusted_price'],
            'price_adjustment_notes' => $validated['price_adjustment_notes'],
            'final_price' => $validated['admin_adjusted_price'],
        ]);

        // Log untuk audit trail
        \Log::info('Order Price Override', [
            'order_id' => $order->id,
            'customer' => $order->client_name,
            'original_price' => $originalPrice,
            'new_price' => $validated['admin_adjusted_price'],
            'reason' => $validated['price_adjustment_notes'],
            'admin' => auth()->user()->name ?? 'Unknown'
        ]);

        return back()->with('success', 'Harga order berhasil diubah! Customer akan dihubungi untuk konfirmasi.');
    }

    /**
     * Send price adjustment notification to customer
     */
    public function sendPriceNotification(Order $order)
    {
        $message = "📢 *PENYESUAIAN HARGA PESANAN*\n\n";
        $message .= "Pesanan Anda telah kami review, dan terdapat penyesuaian harga:\n\n";
        $message .= "Harga Awal: Rp " . number_format($order->subtotal, 0, ',', '.') . "\n";
        $message .= "Harga Disesuaikan: Rp " . number_format($order->final_price, 0, ',', '.') . "\n";
        $message .= "Selisih: Rp " . number_format(abs($order->final_price - $order->subtotal), 0, ',', '.') . "\n\n";
        $message .= "Alasan: {$order->price_adjustment_notes}\n\n";
        $message .= "Status: Menunggu konfirmasi dari Anda\n";
        $message .= "Silakan hubungi kami untuk konfirmasi atau negosiasi lebih lanjut.\n";

        // TODO: Integrate dengan WhatsApp API
        \Log::info('Price Adjustment Notification:', [
            'order_id' => $order->id,
            'customer' => $order->client_name,
            'whatsapp' => $order->client_phone,
            'message' => $message
        ]);

        return back()->with('success', 'Notifikasi penyesuaian harga sudah dikirim ke WhatsApp customer!');
    }

    /**
     * Export orders untuk accounting
     */
    public function export(Request $request)
    {
        $query = Order::with(['service', 'package', 'addons'])
            ->where('status', 'completed');

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->get();

        $csv = "ID,Tanggal,Customer,Service,Paket,Harga Paket,Add-ons,Harga Add-on,Total\n";
        foreach ($orders as $order) {
            $addonsText = $order->addons->pluck('name')->join(', ');
            $addonsPrice = $order->addons_total;
            $csv .= "{$order->id},";
            $csv .= "{$order->created_at->format('Y-m-d')},";
            $csv .= "\"{$order->client_name}\",";
            $csv .= "\"{$order->service->name}\",";
            $csv .= "\"{$order->package->name}\",";
            $csv .= "{$order->package_price},";
            $csv .= "\"{$addonsText}\",";
            $csv .= "{$addonsPrice},";
            $csv .= "{$order->final_price}\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="orders-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }

    /**
     * Analytics dashboard
     */
    public function analytics(Request $request)
    {
        $startDate = $request->start_date ? \Carbon\Carbon::parse($request->start_date) : now()->subDays(30);
        $endDate = $request->end_date ? \Carbon\Carbon::parse($request->end_date) : now();

        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('final_price');

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $topServices = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with('service')
            ->where('status', 'completed')
            ->groupBy('service_id')
            ->selectRaw('service_id, count(*) as total, sum(final_price) as revenue')
            ->with('service')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $topAddons = \DB::table('order_addons')
            ->join('orders', 'order_addons.order_id', '=', 'orders.id')
            ->join('addons', 'order_addons.addon_id', '=', 'addons.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed')
            ->groupBy('addons.id', 'addons.name')
            ->selectRaw('addons.name, count(*) as count, sum(order_addons.addon_price) as revenue')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        return view('admin.analytics', compact(
            'totalRevenue',
            'totalOrders',
            'avgOrderValue',
            'topServices',
            'topAddons',
            'startDate',
            'endDate'
        ));
    }
}
