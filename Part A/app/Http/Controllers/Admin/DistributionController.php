<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Models\Shop;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $records = Distribution::with('shop')->latest()->paginate(20);
        $shops = Shop::where('status', 'active')->orderBy('name')->get();
        return view('admin.distribution.index', compact('records', 'shops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:120',
            'shop_id' => 'required|exists:shops,id',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:30',
            'distribution_date' => 'required|date',
            'remaining_farm_stock' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        $data['recorded_by'] = auth()->id();
        Distribution::create($data);
        return back()->with('success', 'Distribution recorded.');
    }
}
