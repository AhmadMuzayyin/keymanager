<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['categories', 'prices', 'latestVersion'])
            ->active()
            ->latest()
            ->paginate(20)
            ->onEachSide(2);

        $featuredProducts = Product::with(['categories', 'prices', 'latestVersion'])
            ->active()
            ->featured()
            ->take(6)
            ->get();

        $categories = ProductCategory::withCount(['products' => function ($query) {
            $query->where('is_active', true);
        }])->get();

        return view('front.home', compact('products', 'featuredProducts', 'categories'));
    }

    public function products(Request $request)
    {
        $query = Product::with(['categories', 'prices', 'latestVersion'])->active();

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $sortBy = $request->get('sort', 'latest');
        match ($sortBy) {
            'price_low' => $query->orderByRaw('(SELECT MIN(price) FROM product_prices WHERE product_id = products.id) ASC'),
            'price_high' => $query->orderByRaw('(SELECT MIN(price) FROM product_prices WHERE product_id = products.id) DESC'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->onEachSide(2)->withQueryString();

        $categories = ProductCategory::withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        $activeCategory = $request->category ? ProductCategory::where('slug', $request->category)->first() : null;

        return view('front.products', compact('products', 'categories', 'activeCategory'));
    }

    public function productDetail(string $slug)
    {
        $product = Product::with(['categories', 'prices', 'versions', 'requirements', 'images'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedProducts = Product::with(['categories', 'prices'])
            ->active()
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('product_categories.id', $product->categories->pluck('id'));
            })
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('front.product-detail', compact('product', 'relatedProducts'));
    }
}
