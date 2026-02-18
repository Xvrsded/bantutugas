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
            'cart_items' => 'required|json',
            // Parameter kalkulasi
            'question_type' => 'required|string|in:multiple_choice,essay,calculation,project,coding',
            'subject' => 'required|string|max:255',
            'question_count' => 'required|integer|min:1',
            'needs_explanation' => 'nullable|boolean',
            'deadline' => 'required|date|after:now',
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

        // Hitung deadline dalam jam
        $deadlineDate = new \DateTime($validated['deadline']);
        $now = new \DateTime();
        $interval = $now->diff($deadlineDate);
        $deadlineHours = ($interval->days * 24) + $interval->h;

        // Gunakan PriceCalculator service
        $calculator = new \App\Services\PriceCalculator();
        $calculation = $calculator->calculate(
            $validated['question_type'],
            $validated['subject'],
            $validated['question_count'],
            $validated['needs_explanation'] ?? false,
            $deadlineHours
        );

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
                'project_title' => $service->name . ' - Order #' . time(),
                'description' => $validated['notes'],
                'deadline' => $validated['deadline'],
                'budget' => $calculation['calculated_price'], // Harga hasil kalkulasi otomatis
                'quantity' => $item['quantity'],
                'payment_method' => null, // Will be determined after confirmation
                'attachment' => $attachmentPath,
                'status' => 'pending',
                'notes' => 'Menunggu konfirmasi dari admin via WhatsApp.',
                // Parameter kalkulasi
                'question_type' => $validated['question_type'],
                'subject' => $validated['subject'],
                'question_count' => $validated['question_count'],
                'needs_explanation' => $validated['needs_explanation'] ?? false,
                'deadline_hours' => $deadlineHours,
                // Hasil kalkulasi
                'difficulty_score' => $calculation['difficulty_score'],
                'difficulty_level' => $calculation['difficulty_level'],
                'base_price' => $calculation['base_price'],
                'multiplier' => $calculation['multiplier'],
                'calculated_price' => $calculation['calculated_price'],
                'final_price' => $calculation['calculated_price'], // Default sama dengan calculated
                'price_overridden' => false,
            ]);

            $orders[] = $order;
        }

        // Send WhatsApp notification for all orders
        $this->sendCheckoutNotification($orders, $validated, $attachmentPath, $calculation);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil! Harga otomatis telah dihitung. Kami akan hubungi Anda via WhatsApp untuk konfirmasi.',
            'order_count' => count($orders),
            'calculated_price' => $calculation['calculated_price']
        ]);
    }

    private function sendCheckoutNotification($orders, $customerData, $attachmentPath, $calculation)
    {
        $difficultyLabel = [
            'easy' => '🟢 MUDAH',
            'medium' => '🟡 SEDANG',
            'hard' => '🔴 SULIT'
        ];

        $questionTypeLabel = [
            'multiple_choice' => 'Pilihan Ganda',
            'essay' => 'Esai/Uraian',
            'calculation' => 'Hitungan/Matematika',
            'project' => 'Project/Tugas Besar',
            'coding' => 'Coding/Pemrograman'
        ];

        $message = "🔔 *PESANAN BARU dengan Kalkulasi Otomatis*\n\n";
        $message .= "👤 *Pelanggan:* {$customerData['name']}\n";
        $message .= "📧 *Email:* {$customerData['email']}\n";
        $message .= "📱 *WhatsApp:* {$customerData['whatsapp']}\n\n";
        
        $message .= "📊 *PARAMETER KALKULASI:*\n";
        $message .= str_repeat("─", 30) . "\n";
        $message .= "• *Jenis:* " . ($questionTypeLabel[$customerData['question_type']] ?? $customerData['question_type']) . "\n";
        $message .= "• *Mata Pelajaran:* {$customerData['subject']}\n";
        $message .= "• *Jumlah:* {$customerData['question_count']} soal/halaman\n";
        $message .= "• *Penjelasan:* " . (($customerData['needs_explanation'] ?? false) ? 'Ya' : 'Tidak') . "\n";
        $message .= "• *Deadline:* {$customerData['deadline']}\n";
        $message .= str_repeat("─", 30) . "\n\n";
        
        $message .= "💰 *HASIL KALKULASI HARGA:*\n";
        $message .= "• *Kesulitan:* " . ($difficultyLabel[$calculation['difficulty_level']] ?? $calculation['difficulty_level']) . "\n";
        $message .= "• *Skor:* {$calculation['difficulty_score']}/100\n";
        $message .= "• *Harga Dasar:* Rp " . number_format($calculation['base_price'], 0, ',', '.') . "\n";
        $message .= "• *Pengali:* {$calculation['multiplier']}x\n";
        $message .= "• *Harga per Unit:* Rp " . number_format($calculation['pricePerUnit'], 0, ',', '.') . "\n";
        $message .= "• *TOTAL HARGA:* *Rp " . number_format($calculation['calculated_price'], 0, ',', '.') . "*\n\n";
        
        $message .= "📋 *Detail Pesanan:*\n";
        $message .= str_repeat("─", 30) . "\n";
        
        foreach ($orders as $order) {
            $message .= "• {$order->service->name}\n";
            $message .= "  Qty: {$order->quantity}\n";
        }
        
        $message .= str_repeat("─", 30) . "\n";
        
        $message .= "\n📝 *Catatan Customer:*\n{$customerData['notes']}\n";
        
        if ($attachmentPath) {
            $message .= "\n📎 *File Terlampir:* " . basename($attachmentPath) . "\n";
            $message .= "🔗 *Download:* " . asset('storage/' . $attachmentPath) . "\n";
        }
        
        $message .= "\n" . str_repeat("─", 30) . "\n";
        $message .= "⚠️ *ACTION REQUIRED:*\n\n";
        $message .= "1️⃣ Review file tugas customer\n";
        $message .= "2️⃣ Verifikasi apakah file sesuai parameter\n";
        $message .= "3️⃣ Jika perlu adjustment harga, gunakan admin override\n";
        $message .= "4️⃣ Hubungi customer di: {$customerData['whatsapp']}\n";
        $message .= "5️⃣ Konfirmasi harga dan detail\n";
        $message .= "6️⃣ Update status di admin panel setelah deal\n";
        $message .= "\n💡 *Harga sudah dihitung otomatis berdasarkan parameter objektif*\n";
        $message .= "⏰ *Response Time:* Hubungi dalam 1-2 jam\n";

        // TODO: Implement actual WhatsApp sending
        // For now, log the message
        \Log::info('New Order Notification:', [
            'customer' => $customerData['name'],
            'orders' => count($orders),
            'calculated_price' => $calculation['calculated_price'],
            'difficulty_level' => $calculation['difficulty_level'],
            'file' => $attachmentPath,
            'message' => $message
        ]);

        // Mark all orders as notified
        foreach ($orders as $order) {
            $order->update(['is_notified' => true]);
        }
    }
}
