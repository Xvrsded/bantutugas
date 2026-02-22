<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $completedOrders = Order::where('status', 'completed')->get();
        $completedRevenue = $completedOrders->sum(function (Order $order) {
            if (!is_null($order->admin_adjusted_price)) {
                return (float) $order->admin_adjusted_price;
            }

            if (!is_null($order->final_price)) {
                return (float) $order->final_price;
            }

            if (!is_null($order->subtotal)) {
                return (float) $order->subtotal;
            }

            return (float) ($order->budget ?? 0);
        });

        $totalOrders = Order::count();
        $completedOrdersCount = Order::where('status', 'completed')->count();

        $stats = [
            'total_orders' => $totalOrders,
            'pending_orders' => Order::where('status', 'pending')->count(),
            'in_progress_orders' => Order::where('status', 'in_progress')->count(),
            'completed_orders' => $completedOrdersCount,
            'total_services' => Service::count(),
            'total_portfolios' => Portfolio::count(),
            'total_users' => User::count(),
            'today_orders' => Order::whereDate('created_at', now()->toDateString())->count(),
            'overdue_orders' => Order::whereNotNull('deadline')
                ->where('deadline', '<', now())
                ->whereNotIn('status', ['completed', 'rejected'])
                ->count(),
            'completed_revenue' => $completedRevenue,
            'completion_rate' => $totalOrders > 0 ? round(($completedOrdersCount / $totalOrders) * 100, 1) : 0,
        ];

        $recent_orders = Order::with('service')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $order_status_data = [
            'pending' => Order::where('status', 'pending')->count(),
            'accepted' => Order::where('status', 'accepted')->count(),
            'in_progress' => Order::where('status', 'in_progress')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'rejected' => Order::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'recent_orders', 'order_status_data'));
    }
}
