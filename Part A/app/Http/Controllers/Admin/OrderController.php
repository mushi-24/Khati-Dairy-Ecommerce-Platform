<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::with('user')->latest();
        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        $orders = $q->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:'.implode(',', array_keys(Order::statuses())),
        ]);
        $order->status = $data['status'];
        if ($data['status'] === 'delivered') {
            $order->delivered_at = now();
        }
        $order->save();
        return back()->with('success', 'Order status updated.');
    }
}
