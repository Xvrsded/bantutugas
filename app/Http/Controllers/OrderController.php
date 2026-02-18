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
            'notes' => 'required|string|max:2000',
            'attachment' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar',
            'payment_method' => 'required|string',
            'cart_items' => 'required|json',
        ]);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $attachmentPath = $file->storeAs('orders', $filename, 'public');
        }

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
        $totalEstimation = 0;
        
        foreach ($cartItems as $item) {
            $service = Service::find($item['id']);
            
            if (!$service) {
                continue;
            }

            $itemPrice = $item['price'] * $item['quantity'];
            $totalEstimation += $itemPrice;

            $order = Order::create([
                'client_name' => $validated['name'],
                'client_email' => $validated['email'],
                'client_phone' => $validated['whatsapp'],
                'service_id' => $service->id,
                'project_title' => $service->name . ' - Order #' . time(),
                'description' => $validated['notes'],
                'deadline' => now()->addDays(7), // Default 7 days, will be confirmed via WhatsApp
                'budget' => $itemPrice, // Use estimated price from cart
                'quantity' => $item['quantity'],
                'payment_method' => $validated['payment_method'],
                'attachment' => $attachmentPath,
                'status' => 'pending',
                'notes' => 'Menunggu review file dan konfirmasi harga final dari admin.',
            ]);

            $orders[] = $order;
        }

        // Send WhatsApp notification for all orders
        $this->sendCheckoutNotification($orders, $validated, $attachmentPath, $totalEstimation);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil! Tim kami akan review file dan menghubungi Anda via WhatsApp dengan harga final.',
            'order_count' => count($orders)
        ]);
    }

    private function sendCheckoutNotification($orders, $customerData, $attachmentPath, $totalEstimation)
    {
        $message = "🔔 *PESANAN BARU dari Keranjang*\n\n";
        $message .= "👤 *Pelanggan:* {$customerData['name']}\n";
        $message .= "📧 *Email:* {$customerData['email']}\n";
        $message .= "📱 *WhatsApp:* {$customerData['whatsapp']}\n";
        $message .= "💳 *Metode Pembayaran:* " . strtoupper($customerData['payment_method']) . "\n\n";
        
        $message .= "📋 *Detail Pesanan:*\n";
        $message .= str_repeat("─", 30) . "\n";
        
        foreach ($orders as $order) {
            $message .= "• {$order->service->name}\n";
            $message .= "  Qty: {$order->quantity} | Estimasi: Rp " . number_format($order->budget, 0, ',', '.') . "\n";
        }
        
        $message .= str_repeat("─", 30) . "\n";
        $message .= "💰 *Total Estimasi:* Rp " . number_format($totalEstimation, 0, ',', '.') . "\n";
        
        $message .= "\n📝 *Detail Tugas:*\n{$customerData['notes']}\n";
        
        if ($attachmentPath) {
            $message .= "\n📎 *File Terlampir:* " . basename($attachmentPath) . "\n";
            $message .= "🔗 *Download:* " . asset('storage/' . $attachmentPath) . "\n";
        }
        
        $message .= "\n" . str_repeat("─", 30) . "\n";
        $message .= "⚠️ *ACTION REQUIRED - Proses Ini:*\n\n";
        $message .= "1️⃣ Download & review file tugas customer\n";
        $message .= "2️⃣ Analisa kompleksitas dan waktu pengerjaan\n";
        $message .= "3️⃣ Tentukan harga final yang sesuai\n";
        $message .= "4️⃣ Hubungi customer di: {$customerData['whatsapp']}\n";
        $message .= "5️⃣ Konfirmasi harga, deadline, dan detail lainnya\n";
        $message .= "6️⃣ Setelah deal, update status di admin panel\n";
        $message .= "\n⏰ *Response Time:* Hubungi dalam 1-2 jam\n";

        // TODO: Implement actual WhatsApp sending
        // For now, log the message
        \Log::info('New Order Notification:', [
            'customer' => $customerData['name'],
            'orders' => count($orders),
            'total_estimation' => $totalEstimation,
            'file' => $attachmentPath,
            'message' => $message
        ]);

        // Mark all orders as notified
        foreach ($orders as $order) {
            $order->update(['is_notified' => true]);
        }
    }
}
