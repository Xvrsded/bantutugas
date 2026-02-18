# VERIFICATION TEST SCRIPT

Mari kita verifikasi setiap halaman langkah demi langkah:

## PAGE 1: HOME (/)

### Controller Check:
```php
public function home()
{
    $services = Service::where('is_active', true)->take(6)->get();     // ✓ Query DB
    $portfolios = Portfolio::where('is_featured', true)->take(3)->get(); // ✓ Query DB
    $testimonials = Testimonial::approved()->latest()->get();            // ✓ Query DB
    return view('pages.home', compact('services', 'portfolios', 'testimonials')); // ✓ Pass data
}
```
**Status:** ✅ Controller queries 3 tables

### View Check (home.blade.php):
- Line 95: `@forelse ($services as $service)` ✓ Displays services
- Line 144: `@forelse ($portfolios as $portfolio)` ✓ Displays portfolios
- Line 355: `@forelse ($testimonials as $testimonial)` ✓ Displays testimonials
- Line 396+: Feedback form saves to DB ✓

**Status:** ✅ View uses all 3 data variables

### Data Flow:
```
Controller queries → Service, Portfolio, Testimonial tables
                 ↓
          Pass to view
                 ↓
          View displays with @forelse loops
                 ↓
          User submits feedback → Saves to testimonials table
                 ↓
          Page refreshes → New testimonial appears
```

**Status:** ✅ FULL INTEGRATION

---

## PAGE 2: SERVICES (/services)

### Controller Check:
```php
public function services()
{
    $academicServices = Service::where('is_active', true)->get() // ✓ Query DB
        ->filter(...academic category...);
    
    $techServices = Service::where('is_active', true)->get()    // ✓ Query DB
        ->filter(...tech category...);
    
    return view('pages.services', compact('academicServices', 'techServices')); // ✓ Pass data
}
```
**Status:** ✅ Controller queries services table

### View Check (services.blade.php):
- Line 23: `@forelse ($academicServices as $service)` ✓
- Line 87: `@forelse ($techServices as $service)` ✓
- Shows pricing from packages ✓
- Shows features from JSON ✓
- "Pesan" button links to checkout ✓

**Status:** ✅ View uses services and packages data

### Data Flow:
```
Controller filters services by category
         ↓
 Queries from services table
         ↓
Pass to view
         ↓
View displays with price range from packages
         ↓
User clicks "Pesan" → Goes to checkout
```

**Status:** ✅ FULL INTEGRATION

---

## PAGE 3: PORTFOLIO (/portfolio)

### Controller Check:
```php
public function portfolio()
{
    $portfolios = Portfolio::orderBy('is_featured', 'desc')    // ✓ Query DB
        ->orderBy('created_at', 'desc')
        ->get();
    $categories = ['academic', 'pcb', 'iot', 'webmonitoring', 'programming'];
    return view('pages.portfolio', compact('portfolios', 'categories')); // ✓ Pass data
}
```
**Status:** ✅ Controller queries portfolios table

### View Check (portfolio.blade.php):
- Line 28: `@forelse ($portfolios as $portfolio)` ✓
- Displays title, description, image ✓
- Shows technologies (normalized from JSON) ✓
- Category filtering works ✓

**Status:** ✅ View uses portfolios data

### Data Flow:
```
Controller queries portfolios table
         ↓
Order by featured & created_at
         ↓
Pass to view
         ↓
View displays with all details
```

**Status:** ✅ FULL INTEGRATION

---

## PAGE 4: HOW TO ORDER (/how-to-order)

### Controller Check:
```php
public function howToOrder()
{
    return view('pages.how-to-order');  // Static, no DB needed
}
```
**Status:** ✅ No database needed (static guide)

---

## PAGE 5: CONTACT (/contact)

### Controller Check - GET:
```php
public function contact()
{
    return view('pages.contact');  // Display form
}
```
**Status:** ✅ Display form

### Controller Check - POST:
```php
public function sendContact(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10'
    ]);
    
    $contact = Contact::create($validated);  // ✓ SAVE TO DB
    return redirect()->route('contact')->with('success', 'Pesan Anda telah dikirim!');
}
```
**Status:** ✅ Saves to contacts table

### Data Flow:
```
User fills form
     ↓
Submit POST /contact
     ↓
Validate data
     ↓
Contact::create() → SAVE TO contacts table ✓
     ↓
Return with success message
```

**Status:** ✅ FULL INTEGRATION

---

## PAGE 6: CHECKOUT (/checkout?service=ID)

### Controller Check:
```php
public function checkout(Request $request)
{
    $serviceId = $request->get('service');
    
    if ($serviceId) {
        $service = Service::with('activePackages')->findOrFail($serviceId); // ✓ Query DB
        $addons = Addon::active()->get();                                   // ✓ Query DB
        return view('pages.checkout-package', compact('service', 'addons')); // ✓ Pass data
    }
}
```
**Status:** ✅ Controller queries services, packages, addons tables

### View Check (checkout-package.blade.php):
- Displays service name ✓
- Shows all packages ✓
- Shows all addons ✓
- Form submission saves order ✓

**Status:** ✅ View uses service, packages, addons data

### Order Save Check:
```php
private function processPackageCheckout(Request $request)
{
    // ... validation ...
    
    $order = Order::create([         // ✓ CREATE in orders table
        'client_name' => $validated['name'],
        'client_email' => $validated['email'],
        'client_phone' => $validated['whatsapp'],
        'service_id' => $validated['service_id'],
        'package_id' => $validated['package_id'],
        'unit_quantity' => $validated['unit_quantity'],
        'payment_choice' => $paymentChoice,
        'dp_percentage' => $dpPercentage,
        'dp_amount' => $dpAmount,
        'remaining_amount' => $remainingAmount,
        // ... more fields ...
    ]);
    
    if (!empty($selectedAddons)) {
        foreach ($selectedAddons as $addon) {
            $order->addons()->attach($addonModel->id, ['addon_price' => $addonPrice]); // ✓ SAVE to order_addons
        }
    }
}
```
**Status:** ✅ Saves to orders table and order_addons pivot table

### Data Flow:
```
User goes to /checkout?service=ID
         ↓
Controller loads Service, Packages, Addons from DB
         ↓
View displays form with dynamic data
         ↓
User selects package + addons + fills form
         ↓
Submit → processPackageCheckout()
         ↓
Order::create() → SAVE to orders table ✓
         ↓
$order->addons()->attach() → SAVE to order_addons table ✓
         ↓
Redirect to /order/success
```

**Status:** ✅ FULL INTEGRATION

---

## PAGE 7: ORDER SUCCESS (/order/success/ID)

### Controller Check:
```php
public function success(Order $order)  // Route model binding
{
    return view('order.success', compact('order'));  // ✓ Pass order from DB
}
```
**Status:** ✅ Loads order from database via route binding

### View Check (order/success.blade.php):
- Displays Order ID: `{{ $order->id }}` ✓
- Displays customer name: `{{ $order->client_name }}` ✓
- Displays service: `{{ $order->service->name }}` ✓
- Displays deadline: `{{ $order->deadline->format(...) }}` ✓
- Displays status: `{{ $order->status }}` ✓

**Status:** ✅ View displays all order data from DB

### Data Flow:
```
After order creation
         ↓
Redirect to /order/success/{id}
         ↓
Route model binding loads Order from DB
         ↓
View displays all order details
         ↓
User sees confirmation
```

**Status:** ✅ FULL INTEGRATION

---

## SPECIAL: FEEDBACK/TESTIMONIAL

### Form Location: Home page
### Submission: AJAX via JavaScript
### Route: POST /testimonial

### Controller Check:
```php
public function storeTestimonial(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'message' => 'required|string|min:10|max:1000'
    ]);

    $testimonial = Testimonial::create([  // ✓ SAVE to testimonials table
        'name' => $validated['name'],
        'email' => $validated['email'],
        'rating' => $validated['rating'],
        'message' => $validated['message'],
        'is_approved' => true  // Auto-approve
    ]);

    return response()->json([
        'success' => true,
        'testimonial' => $testimonial
    ]);
}
```
**Status:** ✅ Saves to testimonials table

### JavaScript Check (home.blade.php):
- Line 506+: AJAX form submission ✓
- Line 515: `fetch('{{ route("testimonial.store") }}')` ✓
- Line 522+: Response handling ✓
- Line 534+: HTML generation & insertion to DOM ✓
- Testimonial appears immediately on page ✓

**Status:** ✅ Real-time display after save

### Data Flow:
```
User fills feedback form
         ↓
Submit via AJAX (no page reload)
         ↓
POST /testimonial
         ↓
Testimonial::create() → SAVE to testimonials table ✓
         ↓
JSON response with new testimonial
         ↓
JavaScript adds to DOM
         ↓
User sees testimonial on page instantly ✓
```

**Status:** ✅ FULL INTEGRATION WITH REAL-TIME DISPLAY

---

## SUMMARY: DATABASE CONNECTIVITY

```
✅ HOME          → Queries: services, portfolios, testimonials (3 tables)
✅ SERVICES      → Queries: services, packages (2 tables)
✅ PORTFOLIO     → Queries: portfolios (1 table)
✅ HOW TO ORDER  → No DB (static)
✅ CONTACT       → Saves: contacts (1 table)
✅ CHECKOUT      → Queries: services, packages, addons (3 tables)
                → Saves: orders, order_addons (2 tables)
✅ ORDER SUCCESS → Queries: orders, services (2 tables)
✅ TESTIMONIAL   → Saves: testimonials (1 table)
               → Displays: Real-time on home
```

## ALL PAGES: ✅ FULLY INTEGRATED WITH DATABASE

