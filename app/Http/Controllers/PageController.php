<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Order;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class PageController extends Controller
{
    private function fallbackCollection(callable $callback): Collection
    {
        try {
            $result = $callback();
            return $result instanceof Collection ? $result : collect($result);
        } catch (Throwable $exception) {
            return collect();
        }
    }

    public function home()
    {
        try {
            $services = $this->fallbackCollection(fn () => Service::where('is_active', true)->take(6)->get());
            $portfolios = $this->fallbackCollection(fn () => Portfolio::where('is_featured', true)->take(3)->get());
            $testimonials = $this->fallbackCollection(fn () => Testimonial::approved()->latest()->get());

            return view('pages.home', compact('services', 'portfolios', 'testimonials'));
        } catch (Throwable $exception) {
            Log::error('Home page fallback triggered', [
                'message' => $exception->getMessage(),
            ]);

            return response('Website online. Sedang ada gangguan sementara pada halaman utama.', 200);
        }
    }

    public function services()
    {
        $allServices = $this->fallbackCollection(fn () => Service::where('is_active', true)->get());

        $academicServices = $allServices
            ->filter(function($service) {
                return stripos($service->category, 'academic') !== false || stripos($service->category, 'tugas') !== false;
            });
        
        $techServices = $allServices
            ->filter(function($service) {
                return stripos($service->category, 'tech') !== false || stripos($service->category, 'programming') !== false || stripos($service->category, 'web') !== false || stripos($service->category, 'iot') !== false;
            });

        // If no separation, show all as one category
        if ($academicServices->isEmpty() && $techServices->isEmpty()) {
            $academicServices = $allServices;
        }

        return view('pages.services', compact('academicServices', 'techServices'));
    }

    public function pricing()
    {
        $services = $this->fallbackCollection(fn () => Service::where('is_active', true)->get());
        return view('pages.pricing', compact('services'));
    }

    public function portfolio()
    {
        $portfolios = $this->fallbackCollection(fn () => Portfolio::orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get());
        $categories = ['academic', 'pcb', 'iot', 'webmonitoring', 'programming'];
        return view('pages.portfolio', compact('portfolios', 'categories'));
    }

    public function howToOrder()
    {
        return view('pages.how-to-order');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10'
        ]);

        // Store contact message to database
        $contact = Contact::create($validated);

        return redirect()->route('contact')->with('success', 'Pesan Anda telah dikirim! Kami akan menghubungi Anda segera.');
    }

    public function disclaimer()
    {
        return view('pages.disclaimer');
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10|max:1000'
        ]);

        $testimonial = Testimonial::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'is_approved' => true // Auto-approve for now, can be changed to require admin approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas feedback Anda!',
            'testimonial' => $testimonial
        ]);
    }

    public function checkout(Request $request)
    {
        $serviceId = $request->get('service');
        
        // If service ID provided, load service with packages and addons
        if ($serviceId) {
            try {
                $service = \App\Models\Service::with('activePackages')->findOrFail($serviceId);
                $addons = \App\Models\Addon::active()->get();

                return view('pages.checkout-package', compact('service', 'addons'));
            } catch (Throwable $exception) {
                return view('pages.checkout')->with('error', 'Layanan checkout sementara belum tersedia. Silakan coba lagi.');
            }
        }
        
        // Otherwise, show cart-based checkout (legacy)
        return view('pages.checkout');
    }
}
