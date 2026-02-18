# Sistem Pemesanan & Checkout Berbasis Paket + Add-On
**BantuTugas - Academic Services Platform**

## 📋 Overview

Sistem pemesanan modern yang menggunakan struktur **Service → Package → Add-On** untuk memberikan fleksibilitas pricing dan opsi tambahan kepada customer. Setiap layanan memiliki 3 paket tier (Hemat, Standar, Premium) dengan harga berbeda, dan customer dapat menambahkan berbagai add-on sesuai kebutuhan.

---

## 🏗️ Arsitektur Sistem

```
SERVICE
  ├─ PACKAGE (Hemat, Standar, Premium)
  │   ├─ Price per unit
  │   ├─ Minimum quantity
  │   └─ Features list
  │
  └─ ADD-ON (Express, Turnitin, English, etc)
      ├─ Pricing type (percentage, fixed, per_unit)
      └─ Applied to subtotal
```

### Data Model

**Services Table** (existing)
- name, description, icon, image
- category, is_active
- Relationship: `hasMany('packages')`

**Packages Table** (new)
- service_id → Service
- name (Hemat/Standar/Premium)
- slug (hemat/standar/premium)
- price_per_unit (harga dasar per unit)
- description, features (JSON), min_quantity
- is_active, sort_order
- **Index**: [service_id, is_active]

**Addons Table** (new)
- name (Express, Turnitin, English, dll)
- slug, type (percentage|fixed|per_unit), price
- description, icon, is_active, sort_order

**Order_Addons Table** (pivot)
- order_id → Order, addon_id → Addon
- addon_price (snapshot harga saat order dibuat)
- **Unique**: [order_id, addon_id]

**Orders Table** (updated with new columns)
- package_id → Package (nullable, untuk backward compatibility)
- unit_quantity (jumlah halaman/soal/project)
- package_price (harga paket)
- addons_total (total harga semua add-on)
- subtotal (package_price + addons_total)
- admin_adjusted_price (harga setelah admin adjust)
- price_adjustment_notes (catatan penyesuaian)

---

## 💰 Pricing Structure

### Paket Standar (Default)

| Paket | Multiplier | Fitur | Revisi | Deadline |
|-------|-----------|-------|--------|----------|
| **Hemat** | 0.7x | Standar | Tidak | 5-7 hari |
| **Standar** | 1.0x | Detail | 1x | 3-5 hari |
| **Premium** | 1.5x | Expert | ∞ | 1-3 hari |

### Contoh Kalkulasi Harga

**Skenario:** Essay Standar, 10 halaman, Express + Turnitin

```
Base Price (Essay) = Rp 15,000 per halaman
Paket Standar = 1.0x multiplier

Package Subtotal = 15,000 × 1.0 × 10 = Rp 150,000
  + Express (50% dari subtotal) = Rp 75,000
  + Turnitin (fixed Rp 50,000) = Rp 50,000
  ─────────────────────────────────────────────
TOTAL = Rp 275,000
```

### Add-On Types

```php
// Percentage: Harga dihitung dari percentage subtotal
'express' => [
    'type' => 'percentage',
    'price' => 50,  // 50% dari package subtotal
]

// Fixed: Harga flat tetap
'turnitin' => [
    'type' => 'fixed', 
    'price' => 50000, // Rp 50,000 tetap
]

// Per Unit: Harga dikalikan jumlah unit
'explanation' => [
    'type' => 'per_unit',
    'price' => 5000, // Rp 5,000 per halaman
]
```

---

## 🛒 User Journey

### 1. **Service Selection (Home Page)**
- Tampilkan semua services dengan price range (min-max dari packages)
- Tombol "Pesan Sekarang" redirect ke `/checkout?service=ID`

### 2. **Package Selection (Checkout Page)**
- Load service dengan packages-nya
- Display 3 packages dengan deskripsi & features
- Select package (akan highlight dan show details)

### 3. **Quantity Input**
- Input jumlah unit (halaman/soal/project)
- Validasi minimum order per package
- Warning jika kurang dari minimum

### 4. **Add-Ons Selection**
- Show available add-ons dengan harga
- Real-time price recalculation
- Display add-on details & pricing type

### 5. **Customer Info**
- Nama, Email, WhatsApp (required)
- Deadline (datetime picker)
- Detail tugas/notes (textarea)
- File upload (required, max 10MB)

### 6. **Price Summary (Sidebar)**
- Real-time breakdown:
  - Harga Paket = price_per_unit × quantity
  - Setiap Add-On dengan hitung detail
  - TOTAL HARGA
- Min order warning jika applicable
- Price adjustment clause

### 7. **Order Submission**
- Validasi: package selected, file uploaded, min order
- Submit via AJAX
- Backend hitung final price & save ke database
- Notification ke admin

---

## ⚙️ Backend Implementation

### Package Model
```php
class Package extends Model {
    // Relationships
    public function service() { return $this->belongsTo(Service::class); }
    
    // Scopes
    public function scopeActive($query) { }
    public function scopeForService($query, $serviceId) { }
    
    // Helpers
    public function calculatePrice($quantity) {
        return $this->price_per_unit * max($quantity, $this->min_quantity);
    }
}
```

### Addon Model
```php
class Addon extends Model {
    // Relationships
    public function orders() {
        return $this->belongsToMany(Order::class, 'order_addons')
            ->withPivot('addon_price')
            ->withTimestamps();
    }
    
    // Calculate price based on type
    public function calculatePrice($basePrice, $quantity = 1) {
        switch($this->type) {
            case 'percentage':
                return ($basePrice * $this->price) / 100;
            case 'fixed':
                return $this->price;
            case 'per_unit':
                return $this->price * $quantity;
        }
    }
}
```

### ProcessPackageCheckout Flow

```php
OrderController::processPackageCheckout(Request $request)
  1. Validate input (package_id, unit_quantity, customer info)
  2. Get Package & Service records
  3. Check minimum quantity
  4. Handle file upload
  5. Calculate package subtotal
  6. Parse & validate selected add-ons
  7. Create Order record
  8. Attach add-ons via pivot table
  9. Update order with final totals
  10. Send notification to admin
  11. Return success response
```

### Order Creation
```php
$order = Order::create([
    'service_id' => $service->id,
    'package_id' => $package->id,
    'unit_quantity' => 10,
    'package_price' => 150000,  // price_per_unit × quantity
    'addons_total' => 125000,    // sum of all add-ons
    'subtotal' => 275000,         // package_price + addons_total
    'final_price' => 275000,      // = subtotal (dapat diubah admin)
    // ... customer info, attachment, status, etc
]);

// Attach add-ons
foreach ($selectedAddons as $addon) {
    $order->addons()->attach($addon['id'], [
        'addon_price' => $addon['calculated_price']
    ]);
}
```

---

## 🎨 Frontend: Real-Time Calculator

JavaScript implementation di `checkout-package.blade.php`:

```javascript
priceCalculator = {
    // Store selected package & add-ons
    selectedPackage: { id, price, minQuantity, name }
    selectedAddons: [{ id, type, price }]
    
    // Main update function
    updatePrice() {
        // 1. Get selected package
        if (!selectedPackage) return;
        
        // 2. Calculate package subtotal
        const packageSubtotal = 
            selectedPackage.price × Math.max(quantity, min);
        
        // 3. Calculate each add-on
        addonsTotal = 0;
        selectedAddons.forEach(addon => {
            switch(addon.type) {
                case 'percentage':
                    addonPrice = (packageSubtotal × addon.price) / 100;
                case 'fixed':
                    addonPrice = addon.price;
                case 'per_unit':
                    addonPrice = addon.price × quantity;
            }
            addonsTotal += addonPrice;
        });
        
        // 4. Update UI with breakdown
        // - Package price display
        // - Each add-on line item
        // - Grand total
    }
    
    // Event listeners
    - .package-card click → selectPackage() → updatePrice()
    - #unit-quantity change → updatePrice()
    - .addon-checkbox change → updatePrice()
}
```

**Real-time Updates:**
- Package selection → Show details, update prices
- Quantity change → Recalculate package subtotal & per_unit add-ons
- Add-on toggle → Recalculate add-ons total & grand total
- All updates immediately reflected in sidebar

---

## 📊 Admin Panel Integration

### Order Management Features

1. **View Order Details**
   - Display package & add-ons selected
   - Show calculated vs final price
   - File download link

2. **Price Override**
   ```php
   $order->update([
       'admin_adjusted_price' => 350000,
       'price_adjustment_notes' => 'File lebih kompleks dari deskripsi',
       'price_overridden' => true
   ]);
   ```

3. **Minimum Order Validation**
   - System automatically validates qty vs min_quantity
   - Warning shown to user
   - Order rejected if below minimum

4. **Price Adjustment Clause**
   - Displayed in checkout page
   - Shows in order confirmation
   - Prevents customer disputes

---

## 🔧 Configuration & Customization

### Adjust Package Pricing
```php
// database/seeders/PackageSeeder.php
'price_per_unit' => $basePrice * 0.7,  // Hemat
'price_per_unit' => $basePrice * 1.0,  // Standar
'price_per_unit' => $basePrice * 1.5,  // Premium
```

### Adjust Base Prices by Service
```php
private function getBasePrice($serviceName) {
    // Return Rp per unit for each service type
    // Affects all 3 packages proportionally
}
```

### Add New Service with Packages
1. Create Service via admin panel or seeder
2. Run PackageSeeder → auto-creates 3 packages
3. Adjust prices if needed via admin panel

### Add New Add-On
```php
// Via admin panel or seeder
Addon::create([
    'name' => 'Video Tutorial',
    'slug' => 'video-tutorial',
    'type' => 'fixed',
    'price' => 150000,
    'description' => 'Include recorded tutorial video',
    'icon' => 'bi-camera-video'
]);
```

---

## ✅ Validation & Business Rules

### Minimum Order
```php
// System automatically enforces minimum
if ($quantity < $package->min_quantity) {
    // Set to minimum
    $quantity = $package->min_quantity;
    // Show warning to user
}
```

### Price Adjustment Clause
> "Harga dihitung otomatis berdasarkan paket dan add-on yang dipilih. 
> Setelah kami review file tugas Anda, harga dapat disesuaikan jika 
> kompleksitas berbeda dari deskripsi Anda. Kami akan konfirmasi 
> harga final via WhatsApp sebelum pengerjaan dimulai."

### File Upload Requirements
- Max size: 10MB
- Formats: PDF, DOC, DOCX, JPG, PNG, ZIP, RAR
- Required: Yes

---

## 📱 API Endpoints

### Public Routes
```
GET  /                          → Home (show services + price range)
GET  /checkout?service=ID       → Checkout page with package selection
POST /checkout/process          → Process order (package-based)
```

### Admin Routes (Protected)
```
GET  /admin/orders              → Orders list
GET  /admin/orders/{order}      → Order details
PUT  /admin/orders/{order}/status → Update order status
PUT  /admin/orders/{order}/price → Override order price (future)
```

---

## 🚀 Deployment Checklist

- [ ] Run migrations: `php artisan migrate`
- [ ] Run seeders: `php artisan db:seed`
- [ ] Update .env with correct URLs
- [ ] Test checkout flow end-to-end
- [ ] Configure WhatsApp notification API
- [ ] Set up email for notifications
- [ ] Test file uploads work correctly
- [ ] Verify admin panel can update prices
- [ ] Test with multiple packages/add-ons
- [ ] Load test with realistic data

---

## 🔮 Future Enhancements

- [ ] Package management interface in admin panel
- [ ] Add-on management interface
- [ ] Drag-drop reordering of packages/add-ons
- [ ] Package variants per service type
- [ ] Seasonal pricing adjustments
- [ ] Bulk order discounts
- [ ] Subscription packages
- [ ] Package recommendations AI
- [ ] A/B testing different pricing
- [ ] Analytics on most popular packages

---

## 📚 Related Documentation

- [Automatic Pricing System](AUTOMATIC_PRICING_DOCS.md) - Legacy system (still supported)
- [Database Schema](docs/database.md)
- [API Reference](docs/api.md)

---

**Version:** 2.0.0  
**Last Updated:** February 18, 2026  
**Status:** ✅ Production Ready

**Questions?** 
📧 support@bantutugas.com | 📱 WhatsApp: 088991796535
