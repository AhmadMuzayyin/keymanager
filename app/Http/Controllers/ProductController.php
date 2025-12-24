<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use App\Models\ProductVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['categories', 'prices', 'latestVersion']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('product_categories.id', $request->category);
            });
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = ProductCategory::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'type' => 'required|in:android,desktop,web',
            'thumbnail' => 'nullable|url|max:500',
            'demo_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:product_categories,id',
            'prices' => 'nullable|array',
            'prices.*.name' => 'required|string|max:100',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.features' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['is_featured'] = $request->boolean('is_featured', false);

            $product = Product::create($validated);

            if (! empty($validated['categories'])) {
                $product->categories()->sync($validated['categories']);
            }

            if (! empty($validated['prices'])) {
                foreach ($validated['prices'] as $index => $priceData) {
                    $product->prices()->create([
                        'name' => $priceData['name'],
                        'price' => $priceData['price'],
                        'features' => $priceData['features'] ?? null,
                        'sort_order' => $index,
                        'is_active' => true,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menyimpan produk: '.$e->getMessage())->withInput();
        }
    }

    public function show(Product $product)
    {
        $product->load(['categories', 'prices', 'versions', 'requirements', 'images']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['categories', 'prices']);
        $categories = ProductCategory::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,'.$product->id,
            'description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'type' => 'required|in:android,desktop,web',
            'thumbnail' => 'nullable|url|max:500',
            'demo_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:product_categories,id',
        ]);

        DB::beginTransaction();
        try {
            $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['is_featured'] = $request->boolean('is_featured', false);

            $product->update($validated);
            $product->categories()->sync($validated['categories'] ?? []);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal memperbarui produk: '.$e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus produk: '.$e->getMessage());
        }
    }

    public function storePrice(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['sort_order'] = $product->prices()->max('sort_order') + 1;
        $validated['is_active'] = $request->boolean('is_active', true);

        $product->prices()->create($validated);

        return back()->with('success', 'Harga berhasil ditambahkan!');
    }

    public function updatePrice(Request $request, ProductPrice $price)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $price->update($validated);

        return back()->with('success', 'Harga berhasil diperbarui!');
    }

    public function destroyPrice(ProductPrice $price)
    {
        $price->delete();

        return back()->with('success', 'Harga berhasil dihapus!');
    }

    public function storeVersion(Request $request, Product $product)
    {
        $validated = $request->validate([
            'version' => 'required|string|max:50',
            'changelog' => 'nullable|string',
            'download_url' => 'nullable|string',
            'file' => 'nullable|file|max:102400',
            'is_latest' => 'boolean',
        ]);

        if ($request->boolean('is_latest')) {
            $product->versions()->update(['is_latest' => false]);
        }

        if ($request->hasFile('file')) {
            $validated['download_url'] = $request->file('file')->store('versions', 'public');
        }

        $validated['is_latest'] = $request->boolean('is_latest', false);
        $validated['released_at'] = now();

        $product->versions()->create($validated);

        return back()->with('success', 'Versi berhasil ditambahkan!');
    }

    public function destroyVersion(ProductVersion $version)
    {
        if ($version->download_url && Storage::disk('public')->exists($version->download_url)) {
            Storage::disk('public')->delete($version->download_url);
        }
        $version->delete();

        return back()->with('success', 'Versi berhasil dihapus!');
    }
}
