<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $shopId = $user->shop_id;

        $products = Product::with('category')
            ->when($shopId, fn ($q) => $q->where('shop_id', $shopId))
            ->latest()->paginate(15);

        $orders = Order::with('items')
            ->when($shopId, fn ($q) => $q->where('shop_id', $shopId))
            ->latest()->paginate(10);

        $stats = [
            'products' => Product::when($shopId, fn ($q) => $q->where('shop_id', $shopId))->count(),
            'orders' => Order::when($shopId, fn ($q) => $q->where('shop_id', $shopId))->count(),
            'sales' => Order::when($shopId, fn ($q) => $q->where('shop_id', $shopId))
                ->where('status', '!=', 'cancelled')->sum('total'),
        ];

        return view('shop.panel.dashboard', compact('products', 'orders', 'stats', 'shopId'));
    }
}
