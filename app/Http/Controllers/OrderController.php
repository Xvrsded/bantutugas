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

    // ===== Package-based checkout router =====
    public function processCheckout(Request $request)
    {
        // Check if this is a package-based order
        if ($request->has('package_id') && $request->filled('package_id')) {
            return $this->processPackageCheckout($request);
        }
        
        // Otherwise, use old cart-based logic
        return $this->processLegacyCheckout($request);
    }

    private function processPackageCheckout(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'package_id' => 'required|exists:packages,id',
            'unit_quantity' => 'required|integer|min:1',
            'selected_addons' => 'nullable|json',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'deadline' => 'required|date|after:now',
            'notes' => 'required|string|max:2000',
            'attachment' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar',
        ]);

        // Get package and service
        $package = \App\Models\Package::findOrFail($validated['package_id']);
        $service = \App\Models\Service::findOrFail($validated['service_id']);

        // Validate minimum quantity
        if ($validated['unit_quantity'] < $package->min_quantity) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order untuk paket {$package->name} adalah {$package->min_quantity} unit."
            ], 400);
        }

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $attachmentPath = $file->storeAs('orders', $filename, 'public');
        }

        // Calculate prices
        $packageSubtotal = $package->price_per_unit * $validated['unit_quantity'];
        $addonsTotal = 0;
        $selectedAddons = json_decode($validated['selected_addons'] ?? '[]', true);

        // Create order
        $order = Order::create([
            'client_name' => $validated['name'],
            'client_email' => $validated['email'],
            'client_phone' => $validated['whatsapp'],
            'service_id' => $validated['service_id'],
            'package_id' => $validated['package_id'],
            'project_title' => $service->name . ' - ' . $package->name,
            'description' => $validated['notes'],
            'deadline' => $validated['deadline'],
            'unit_quantity' => $validated['unit_quantity'],
            'attachment' => $attachmentPath,
            'status' => 'pending',
            'notes' => 'Pesanan baru dari checkout package.',
            'package_price' => $packageSubtotal,
            'addons_total' => 0, // Will be updated when addons are linked
            'subtotal' => $packageSubtotal,
            'is_notified' => false
        ]);

        // Attach add-ons and calculate total
        if (!empty($selectedAddons)) {
            foreach ($selectedAddons as $addon) {
                $addonModel = \App\Models\Addon::findOrFail($addon['id']);
                $addonPrice = $addon['price'] ?? 0;
                
                $order->addons()->attach($addonModel->id, ['addon_price' => $addonPrice]);
                $addonsTotal += $addonPrice;
            }
        }

        // Update order with final amounts
        $order->update([
            'addons_total' => $addonsTotal,
            'subtotal' => $packageSubtotal + $addonsTotal,
            'final_price' => $packageSubtotal + $addonsTotal,
            'budget' => $packageSubtotal + $addonsTotal // For legacy compatibility
        ]);

        // Send notification
        $this->sendPackageCheckoutNotification($order);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat! Kami akan segera menghubungi Anda via WhatsApp.',
            'order_id' => $order->id
        ]);
    }

    private function processLegacyCheckout(Request $request)
    {
        // Legacy code for cart-based checkout
        // (keeping old processCheckout logic here)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'notes' => 'required|string|max:2000',
            'attachment' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar',
            'cart_items' => 'required|json',
            'question_type' => 'nullable|string',
            'subject' => 'nullable|string',
            'question_count' => 'nullable|integer|min:1',
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

        // Calculate deadline in hours
        $deadlineDate = new \DateTime($validated['deadline']);
        $now = new \DateTime();
        $interval = $now->diff($deadlineDate);
        $deadlineHours = ($interval->days * 24) + $interval->h;

        // Use PriceCalculator if parameters provided
        $calculation = null;
        if ($validated['question_type'] ?? false) {
            $calculator = new \App\Services\PriceCalculator();
            $calculation = $calculator->calculate(
                $validated['question_type'],
                $validated['subject'],
                $validated['question_count'],
                $validated['needs_explanation'] ?? false,
                $deadlineHours
            );
        }

        // Create orders for each service in cart
        $orders = [];
        
        foreach ($cartItems as $item) {
            $service = \App\Models\Service::find($item['id']);
            
            if (!$service) {
                continue;
            }

            $orderData = [
                'client_name' => $validated['name'],
                'client_email' => $validated['email'],
                'client_phone' => $validated['whatsapp'],
                'service_id' => $service->id,
                'project_title' => $service->name . ' - Order #' . time(),
                'description' => $validated['notes'],
                'deadline' => $validated['deadline'],
                'budget' => $calculation['calculated_price'] ?? ($item['price'] * $item['quantity']),
                'quantity' => $item['quantity'],
                'payment_method' => null,
                'attachment' => $attachmentPath,
                'status' => 'pending',
                'notes' => 'Pesanan dari checkout legacy.',
                'is_notified' => false
            ];

            // Add calculation fields if available
            if ($calculation) {
                $orderData = array_merge($orderData, [
                    'question_type' => $validated['question_type'],
                    'subject' => $validated['subject'],
                    'question_count' => $validated['question_count'],
                    'needs_explanation' => $validated['needs_explanation'] ?? false,
                    'deadline_hours' => $deadlineHours,
                    'difficulty_score' => $calculation['difficulty_score'],
                    'difficulty_level' => $calculation['difficulty_level'],
                    'base_price' => $calculation['base_price'],
                    'multiplier' => $calculation['multiplier'],
                    'calculated_price' => $calculation['calculated_price'],
                    'final_price' => $calculation['calculated_price'],
                    'price_overridden' => false,
                ]);
            }

            $order = Order::create($orderData);
            $orders[] = $order;
        }

        // Send notification
        $this->sendLegacyCheckoutNotification($orders, $validated, $attachmentPath, $calculation);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil! Kami akan menghubungi Anda via WhatsApp untuk konfirmasi.',
            'order_count' => count($orders)
        ]);
    }

    private function sendPackageCheckoutNotification($order)
    {
        $message = "🔔 *PESANAN BARU - CHECKOUT PACKAGE*\n\n";
        $message .= "👤 *Pelanggan:* {$order->client_name}\n";
        $message .= "📧 *Email:* {$order->client_email}\n";
        $message .= "📱 *WhatsApp:* {$order->client_phone}\n\n";
        
        $message .= "📦 *DETAIL PESANAN:*\n";
        $message .= "• *Layanan:* {$order->service->name}\n";
        $message .= "• *Paket:* {$order->package->name}\n";
        $message .= "• *Jumlah Unit:* {$order->unit_quantity}\n";
        $message .= "• *Harga Paket:* Rp " . number_format($order->package_price, 0, ',', '.') . "\n";
        
        if ($order->addons_total > 0) {
            $message .= "\n*ADD-ONS:*\n";
            foreach ($order->addons as $addon) {
                $message .= "• {$addon->name}: Rp " . number_format($addon->pivot->addon_price, 0, ',', '.') . "\n";
            }
        }
        
        $message .= "\n💰 *TOTAL:* Rp " . number_format($order->final_price, 0, ',', '.') . "\n";
        $message .= "📅 *Deadline:* {$order->deadline}\n\n";
        
        $message .= "📝 *Detail Tugas:*\n{$order->description}\n";
        
        if ($order->attachment) {
            $message .= "\n📎 *File Terlampir:* " . basename($order->attachment) . "\n";
            $message .= "🔗 *Download:* " . asset('storage/' . $order->attachment) . "\n";
        }
        
        $message .= "\n⚠️ *LANGKAH SELANJUTNYA:*\n";
        $message .= "1️⃣ Review file tugas\n";
        $message .= "2️⃣ Verifikasi kesesuaian dengan order\n";
        $message .= "3️⃣ Hubungi customer via WhatsApp\n";
        $message .= "4️⃣ Konfirmasi jadwal & detail\n";
        $message .= "5️⃣ Mulai pengerjaan\n";

        \Log::info('New Package Order:', [
            'customer' => $order->client_name,
            'package' => $order->package->name,
            'total_price' => $order->final_price,
            'file' => $order->attachment,
            'message' => $message
        ]);

        $order->update(['is_notified' => true]);
    }

    private function sendLegacyCheckoutNotification($orders, $customerData, $attachmentPath, $calculation = null)
    {
        $message = "🔔 *PESANAN BARU*\n\n";
        $message .= "👤 *Pelanggan:* {$customerData['name']}\n";
        $message .= "📧 *Email:* {$customerData['email']}\n";
        $message .= "📱 *WhatsApp:* {$customerData['whatsapp']}\n\n";

        if ($calculation) {
            $difficultyLabel = ['easy' => '🟢 MUDAH', 'medium' => '🟡 SEDANG', 'hard' => '🔴 SULIT'];
            $message .= "📊 *KALKULASI OTOMATIS:*\n";
            $message .= "• *Kesulitan:* " . ($difficultyLabel[$calculation['difficulty_level']] ?? $calculation['difficulty_level']) . "\n";
            $message .= "• *Skor:* {$calculation['difficulty_score']}/100\n";
            $message .= "• *Harga:* Rp " . number_format($calculation['calculated_price'], 0, ',', '.') . "\n\n";
        }

        $message .= "📋 *Detail Pesanan:*\n";
        foreach ($orders as $order) {
            $message .= "• {$order->service->name}\n";
        }
        
        $message .= "\n📝 *Catatan:*\n{$customerData['notes']}\n";
        
        if ($attachmentPath) {
            $message .= "\n📎 *File:* " . basename($attachmentPath) . "\n";
            $message .= "🔗 *Download:* " . asset('storage/' . $attachmentPath) . "\n";
        }

        \Log::info('New Legacy Order:', [
            'customer' => $customerData['name'],
            'orders' => count($orders),
            'file' => $attachmentPath,
            'message' => $message
        ]);

        foreach ($orders as $order) {
            $order->update(['is_notified' => true]);
        }
    }
}
