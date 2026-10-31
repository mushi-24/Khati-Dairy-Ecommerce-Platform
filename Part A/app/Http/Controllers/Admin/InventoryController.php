<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\Shop;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $q = InventoryItem::with('shop');
        if ($request->filled('location_type')) {
            $q->where('location_type', $request->location_type);
        }
        if ($request->get('filter') === 'low') {
            $q->whereColumn('quantity', '<=', 'low_threshold')->where('quantity', '>', 0);
        }
        if ($request->get('filter') === 'out') {
            $q->where('quantity', '<=', 0);
        }
        $items = $q->latest()->paginate(20);
        $shops = Shop::orderBy('name')->get();
        return view('admin.inventory.index', compact('items', 'shops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'location_type' => 'required|in:farm,shop,online',
            'product_name' => 'required|string|max:120',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:30',
            'low_threshold' => 'nullable|numeric|min:0',
            'shop_id' => 'nullable|exists:shops,id',
        ]);
        $data['low_threshold'] = $data['low_threshold'] ?? 10;
        InventoryItem::create($data);
        return back()->with('success', 'Inventory item added.');
    }
}
