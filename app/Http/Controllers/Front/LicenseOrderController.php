<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\License;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LicenseOrderController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['prices'])->active()->get();

        return view('front.order-license', compact('products'));
    }

    public function bundleOrder(string $slug, ?int $priceId = null)
    {
        $product = Product::with(['prices', 'categories', 'latestVersion'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $selectedPrice = $priceId 
            ? $product->prices->find($priceId) 
            : $product->prices->first();

        $seoData = [
            'title' => "Beli {$product->name} - License Key & Product Bundle",
            'description' => Str::limit($product->description ?? "Dapatkan license key {$product->name} dengan harga terbaik. Termasuk akses penuh ke produk dan update.", 160),
            'keywords' => "{$product->name}, license key, {$product->type} app, beli aplikasi",
            'image' => $product->thumbnail,
            'url' => route('front.order.bundle', $product->slug),
        ];

        return view('front.order-bundle', compact('product', 'selectedPrice', 'seoData'));
    }

    public function licenseOnly()
    {
        $products = Product::with(['prices'])->active()->get();

        $seoData = [
            'title' => 'Order License Key - Aktivasi Produk Anda',
            'description' => 'Beli license key untuk mengaktifkan produk Anda. Proses cepat dan aman dengan berbagai metode pembayaran.',
            'keywords' => 'license key, aktivasi produk, beli license, kunci lisensi',
            'url' => route('front.order.license-only'),
        ];

        return view('front.order-license-only', compact('products', 'seoData'));
    }

    public function storeBundleOrder(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price_id' => 'required|exists:product_prices,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'domain' => 'nullable|string|max:255',
            'payment_method' => 'required|in:bank_transfer,ewallet,credit_card',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($validated['product_id']);
            $price = ProductPrice::findOrFail($validated['price_id']);

            $customer = Customer::firstOrCreate(
                ['email' => $validated['customer_email']],
                [
                    'name' => $validated['customer_name'],
                    'phone' => $validated['customer_phone'],
                ]
            );

            $order = Order::create([
                'customer_id' => $customer->id,
                'total' => $price->price,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'],
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_price_id' => $price->id,
                'product_name' => $product->name,
                'price_name' => $price->name,
                'price' => $price->price,
                'quantity' => 1,
                'subtotal' => $price->price,
            ]);

            $license = License::create([
                'customer_id' => $customer->id,
                'order_id' => $order->id,
                'key' => strtoupper(Str::random(8) . '-' . Str::random(8) . '-' . Str::random(8) . '-' . Str::random(8)),
                'product_name' => $product->name,
                'domain' => $validated['domain'],
                'max_activations' => 1,
                'status' => 'suspended',
                'purchase_code' => 'PUR-' . strtoupper(Str::random(8)),
            ]);

            DB::commit();

            return redirect()
                ->route('front.order.success', $order->order_number)
                ->with('success', 'Order berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeLicenseOrder(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'domain' => 'nullable|string|max:255',
            'license_type' => 'required|in:single,multi,unlimited',
            'payment_method' => 'required|in:bank_transfer,ewallet,credit_card',
            'notes' => 'nullable|string|max:500',
        ]);

        $prices = [
            'single' => 150000,
            'multi' => 350000,
            'unlimited' => 750000,
        ];

        $maxActivations = [
            'single' => 1,
            'multi' => 5,
            'unlimited' => 999,
        ];

        DB::beginTransaction();
        try {
            $customer = Customer::firstOrCreate(
                ['email' => $validated['customer_email']],
                [
                    'name' => $validated['customer_name'],
                    'phone' => $validated['customer_phone'],
                ]
            );

            $order = Order::create([
                'customer_id' => $customer->id,
                'total' => $prices[$validated['license_type']],
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'],
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => null,
                'product_price_id' => null,
                'product_name' => $validated['product_name'],
                'price_name' => 'License Key - ' . ucfirst($validated['license_type']),
                'price' => $prices[$validated['license_type']],
                'quantity' => 1,
                'subtotal' => $prices[$validated['license_type']],
            ]);

            $license = License::create([
                'customer_id' => $customer->id,
                'order_id' => $order->id,
                'key' => strtoupper(Str::random(8) . '-' . Str::random(8) . '-' . Str::random(8) . '-' . Str::random(8)),
                'product_name' => $validated['product_name'],
                'domain' => $validated['domain'],
                'max_activations' => $maxActivations[$validated['license_type']],
                'status' => 'suspended',
                'purchase_code' => 'PUR-' . strtoupper(Str::random(8)),
            ]);

            DB::commit();

            return redirect()
                ->route('front.order.success', $order->order_number)
                ->with('success', 'Order berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function orderSuccess(string $orderNumber)
    {
        $order = Order::with(['customer', 'items'])->where('order_number', $orderNumber)->firstOrFail();

        return view('front.order-success', compact('order'));
    }
}
