<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('owner')->latest()->paginate(15);
        return view('admin.shops.index', compact('shops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:80',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active,suspended',
        ]);
        $data['slug'] = Str::slug($data['name']).'-'.Str::random(3);
        $data['is_verified'] = $request->boolean('is_verified');
        Shop::create($data);
        return back()->with('success', 'Shop created.');
    }

    public function update(Request $request, Shop $shop)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:80',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active,suspended',
        ]);
        $data['is_verified'] = $request->boolean('is_verified');
        $shop->update($data);
        return back()->with('success', 'Shop updated.');
    }
}
