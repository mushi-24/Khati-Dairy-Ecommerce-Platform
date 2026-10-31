<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $q = Attendance::with('employee')->latest('date');
        if ($request->filled('date')) $q->whereDate('date', $request->date);
        if ($request->filled('employee_id')) $q->where('employee_id', $request->employee_id);
        $records = $q->paginate(25);
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        return view('admin.attendance.index', compact('records', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,leave',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'note' => 'nullable|string',
        ]);
        Attendance::updateOrCreate(
            ['employee_id' => $data['employee_id'], 'date' => $data['date']],
            $data
        );
        return back()->with('success', 'Attendance saved.');
    }
}
