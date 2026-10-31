<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $total = Order::where('status', '!=', 'cancelled')->sum('total');
        $count = Order::where('status', '!=', 'cancelled')->count();
        $byStatus = Order::select('status', DB::raw('count(*) as c'), DB::raw('sum(total) as t'))
            ->groupBy('status')->get();
        $daily = Order::select(DB::raw('date(created_at) as d'), DB::raw('count(*) as c'), DB::raw('sum(total) as t'))
            ->where('status', '!=', 'cancelled')
            ->groupBy('d')->orderByDesc('d')->limit(14)->get();
        return view('admin.sales.index', compact('total', 'count', 'byStatus', 'daily'));
    }
}
