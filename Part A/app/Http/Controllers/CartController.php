<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('shop.cart', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);
        $id = (string) $product->id;
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $qty,
                'image' => $product->image,
            ];
        }
        session(['cart' => $cart]);
        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        foreach ($request->input('qty', []) as $id => $qty) {
            if (isset($cart[$id])) {
                $qty = (int) $qty;
                if ($qty <= 0) unset($cart[$id]);
                else $cart[$id]['quantity'] = $qty;
            }
        }
        session(['cart' => $cart]);
        return back()->with('success', 'Cart updated.');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Item removed.');
    }
}
