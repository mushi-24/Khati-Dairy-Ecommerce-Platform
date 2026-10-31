<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ProductionRecord;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $records = ProductionRecord::latest()->paginate(20);
        return view('admin.production.index', compact('records'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:120',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:30',
            'production_date' => 'required|date',
            'batch_reference' => 'nullable|string|max:80',
            'notes' => 'nullable|string',
        ]);
        $data['recorded_by'] = auth()->id();
        ProductionRecord::create($data);
        return back()->with('success', 'Production recorded.');
    }

    public function destroy(ProductionRecord $production)
    {
        $production->delete();
        return back()->with('success', 'Record deleted.');
    }
}
