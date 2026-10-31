<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty.');
        }
        return view('shop.checkout', compact('cart'));
    }

    public function place(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty.');
        }

        $data = $request->validate([
            'customer_name' => 'required|string|max:120',
            'customer_phone' => 'required|string|max:30',
            'customer_email' => 'nullable|email',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $order = DB::transaction(function () use ($data, $cart, $request) {
                $subtotal = 0;
                $lines = [];

                foreach ($cart as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);
                    if (!$product || $product->status !== 'active') {
                        throw new \RuntimeException('Product unavailable: ' . ($item['name'] ?? 'item'));
                    }
                    $qty = (int) $item['quantity'];
                    if ($qty < 1 || $product->stock < $qty) {
                        throw new \RuntimeException('Insufficient stock for ' . $product->name);
                    }
                    $price = (float) $product->price;
                    $lineTotal = $price * $qty;
                    $subtotal += $lineTotal;
                    $lines[] = compact('product', 'qty', 'price', 'lineTotal');
                }

                $delivery = 50;
                $order = Order::create([
                    'order_number' => 'KD-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
                    'user_id' => $request->user()->id,
                    'customer_name' => $data['customer_name'],
                    'customer_phone' => $data['customer_phone'],
                    'customer_email' => $data['customer_email'] ?? $request->user()->email,
                    'shipping_address' => $data['shipping_address'],
                    'subtotal' => $subtotal,
                    'delivery_fee' => $delivery,
                    'total' => $subtotal + $delivery,
                    'payment_method' => 'cod',
                    'status' => 'pending',
                    'notes' => $data['notes'] ?? null,
                ]);

                foreach ($lines as $line) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $line['product']->id,
                        'product_name' => $line['product']->name,
                        'price' => $line['price'],
                        'quantity' => $line['qty'],
                        'line_total' => $line['lineTotal'],
                    ]);
                    $line['product']->decrement('stock', $line['qty']);
                    if ($line['product']->fresh()->stock <= 0) {
                        $line['product']->update(['status' => 'out_of_stock']);
                    }
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        session()->forget('cart');
        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully (COD).');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('shop.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id() || auth()->user()?->canAccessAdminPanel(), 403);
        $order->load('items');
        return view('shop.order-show', compact('order'));
    }

    public function payslip(\App\Models\Order $order)
    {
        abort_unless($order->user_id === auth()->id() || auth()->user()?->canAccessAdminPanel(), 403);
        $order->load('items');
        return view('shop.payslip', compact('order'));
    }
}
