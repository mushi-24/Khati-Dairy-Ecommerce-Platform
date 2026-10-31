<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('employee')->latest()->paginate(20);
        $employees = Employee::orderBy('name')->get();
        return view('admin.salary.index', compact('salaries', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string|max:7',
            'basic_salary' => 'required|numeric|min:0',
            'days_present' => 'nullable|integer|min:0',
            'days_absent' => 'nullable|integer|min:0',
            'days_late' => 'nullable|integer|min:0',
            'days_leave' => 'nullable|integer|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,processing,paid',
            'payment_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);
        $bonus = $data['bonus'] ?? 0;
        $deduction = $data['deduction'] ?? 0;
        $data['bonus'] = $bonus;
        $data['deduction'] = $deduction;
        $data['days_present'] = $data['days_present'] ?? 0;
        $data['days_absent'] = $data['days_absent'] ?? 0;
        $data['days_late'] = $data['days_late'] ?? 0;
        $data['days_leave'] = $data['days_leave'] ?? 0;
        // Net stored as recorded: basic + bonus - deduction (attendance days for reference)
        $data['net_salary'] = $data['basic_salary'] + $bonus - $deduction;
        Salary::create($data);
        return back()->with('success', 'Salary record saved.');
    }
}
