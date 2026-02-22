<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $allowedStatuses = ['pending', 'accepted', 'in_progress', 'completed', 'rejected'];
        $allowedPeriods = ['today', '7days', '30days', 'overdue'];

        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');
        $period = (string) $request->query('period', '');

        $query = Order::with('service');

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('client_name', 'like', "%{$search}%")
                    ->orWhere('client_email', 'like', "%{$search}%")
                    ->orWhere('client_phone', 'like', "%{$search}%")
                    ->orWhere('project_title', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if (in_array($status, $allowedStatuses, true)) {
            $query->where('status', $status);
        } else {
            $status = '';
        }

        if (in_array($period, $allowedPeriods, true)) {
            if ($period === 'today') {
                $query->whereDate('created_at', now()->toDateString());
            }

            if ($period === '7days') {
                $query->where('created_at', '>=', now()->subDays(7));
            }

            if ($period === '30days') {
                $query->where('created_at', '>=', now()->subDays(30));
            }

            if ($period === 'overdue') {
                $query->whereNotNull('deadline')
                    ->where('deadline', '<', now())
                    ->whereNotIn('status', ['completed', 'rejected']);
            }
        } else {
            $period = '';
        }

        $filteredCount = (clone $query)->count();

        $orders = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'accepted' => Order::where('status', 'accepted')->count(),
            'in_progress' => Order::where('status', 'in_progress')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'rejected' => Order::where('status', 'rejected')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'search', 'status', 'period', 'filteredCount'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,in_progress,completed,rejected',
            'notes' => 'nullable|string'
        ]);

        $order->update([
            'status' => $request->status,
            'notes' => $request->notes ?? $order->notes
        ]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan dihapus!');
    }

    public function updatePaymentStatus(Order $order, Request $request)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:waiting,paid',
        ]);

        $order->update([
            'payment_status' => $validated['payment_status'],
            'paid_at' => $validated['payment_status'] === 'paid' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
