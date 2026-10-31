<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Shop;
use App\Models\Employee;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders' => Order::count(),
            'products' => Product::count(),
            'customers' => User::where('role', 'customer')->count(),
            'shops' => Shop::count(),
            'employees' => Employee::count(),
            'sales' => Order::where('status', '!=', 'cancelled')->sum('total'),
        ];
        $recentOrders = Order::latest()->take(8)->get();
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
