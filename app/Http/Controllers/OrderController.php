<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Service $service)
    {
        return view('order.create', compact('service'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'project_title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
            'budget' => 'nullable|numeric|min:0',
            'attachment' => 'nullable|file|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $validated['attachment'] = $file->store('orders', 'public');
        }

        $order = Order::create($validated);

        // Send WhatsApp notification
        $this->sendWhatsAppNotification($order);

        return redirect()->route('order.success', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success(Order $order)
    {
        return view('order.success', compact('order'));
    }

    private function sendWhatsAppNotification(Order $order)
    {
        // This will be implemented with actual WhatsApp API integration
        // For now, we'll store the notification state
        $service = $order->service;
        
        $message = "Halo! Pesanan baru dari {$order->client_name}\n";
        $message .= "Layanan: {$service->name}\n";
        $message .= "Judul: {$order->project_title}\n";
        $message .= "Deadline: {$order->deadline}\n";
        $message .= "Budget: Rp " . number_format($order->budget ?? 0, 0, ',', '.') . "\n";
        $message .= "Link: " . route('admin.orders.show', $order->id);

        // TODO: Implement actual WhatsApp sending
        // You can use services like Twilio, WhatsApp Business API, or other providers
        
        $order->update(['is_notified' => true]);
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|string',
            'cart_items' => 'required|json',
        ]);

        // Parse cart items
        $cartItems = json_decode($validated['cart_items'], true);
        
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong!'
            ], 400);
        }

        // Create orders for each service in cart
        $orders = [];
        foreach ($cartItems as $item) {
            $service = Service::find($item['id']);
            
            if (!$service) {
                continue;
            }

            $order = Order::create([
                'client_name' => $validated['name'],
                'client_email' => $validated['email'],
                'client_phone' => $validated['whatsapp'],
                'service_id' => $service->id,
                'project_title' => $service->name . ' - Order dari Cart',
                'description' => $validated['notes'] ?? 'Order melalui keranjang belanja',
                'deadline' => now()->addDays(7), // Default 7 days
                'budget' => $item['price'] * $item['quantity'],
                'quantity' => $item['quantity'],
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]);

            $orders[] = $order;
        }

        // Send WhatsApp notification for all orders
        $this->sendCheckoutNotification($orders, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat! Kami akan menghubungi Anda melalui WhatsApp.',
            'order_count' => count($orders)
        ]);
    }

    private function sendCheckoutNotification($orders, $customerData)
    {
        $message = "Halo Admin! Pesanan baru dari keranjang:\n\n";
        $message .= "Pelanggan: {$customerData['name']}\n";
        $message .= "Email: {$customerData['email']}\n";
        $message .= "WhatsApp: {$customerData['whatsapp']}\n";
        $message .= "Metode Pembayaran: {$customerData['payment_method']}\n";
        $message .= "\nDaftar Layanan:\n";
        
        $total = 0;
        foreach ($orders as $order) {
            $message .= "- {$order->service->name} (Qty: {$order->quantity}) - Rp " . number_format($order->budget, 0, ',', '.') . "\n";
            $total += $order->budget;
        }
        
        $message .= "\nTotal: Rp " . number_format($total, 0, ',', '.') . "\n";
        $message .= "\nCatatan: " . ($customerData['notes'] ?? '-');

        // TODO: Implement actual WhatsApp sending
        // Mark all orders as notified
        foreach ($orders as $order) {
            $order->update(['is_notified' => true]);
        }
    }
}
