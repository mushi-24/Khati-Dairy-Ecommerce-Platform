<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::with(['category', 'shop'])->where('status', 'active');

        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%{$s}%")->orWhere('description', 'like', "%{$s}%");
            });
        }
        if ($request->filled('category')) {
            $q->where('category_id', $request->category);
        }
        if ($request->filled('shop')) {
            $q->where('shop_id', $request->shop);
        }

        match ($request->get('sort', 'newest')) {
            'price_asc' => $q->orderBy('price', 'asc'),
            'price_desc' => $q->orderBy('price', 'desc'),
            'name' => $q->orderBy('name', 'asc'),
            default => $q->latest(),
        };

        $products = $q->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $shops = Shop::where('status', 'active')->orderBy('name')->get();

        return view('shop.products', compact('products', 'categories', 'shops'));
    }

    public function show(Product $product)
    {
        abort_unless($product->status === 'active', 404);
        $product->load(['category', 'shop']);
        return view('shop.product-show', compact('product'));
    }
}
