<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'shop'])
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $shops = Shop::where('status', 'active')->orderBy('name')->get();
        return view('shop.home', compact('products', 'categories', 'shops'));
    }
}
