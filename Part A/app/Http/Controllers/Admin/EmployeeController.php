<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $q = Employee::with('user');
        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%$s%")->orWhere('employee_id', 'like', "%$s%");
            });
        }
        $employees = $q->latest()->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|string|max:40|unique:employees,employee_id',
            'name' => 'required|string|max:120',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email',
            'position' => 'nullable|string|max:80',
            'department' => 'nullable|string|max:80',
            'joining_date' => 'nullable|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'nullable|in:active,inactive,on_leave',
            'address' => 'nullable|string',
            'create_login' => 'nullable|boolean',
            'login_email' => 'nullable|email|unique:users,email',
            'login_password' => 'nullable|string|min:6',
        ]);
        $data['status'] = $data['status'] ?? 'active';

        try {
            DB::transaction(function () use ($data, $request) {
                $userId = null;
                if ($request->boolean('create_login')) {
                    $email = $data['login_email'] ?? $data['email'] ?? null;
                    $password = $data['login_password'] ?? null;
                    if (!$email || !$password) {
                        throw ValidationException::withMessages([
                            'login_email' => 'Login email and password required when creating login account.',
                        ]);
                    }
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $email,
                        'password' => Hash::make($password),
                        'role' => User::ROLE_EMPLOYEE,
                        'phone' => $data['phone'] ?? null,
                        'is_active' => true,
                    ]);
                    $userId = $user->id;
                }
                unset($data['create_login'], $data['login_email'], $data['login_password']);
                $data['user_id'] = $userId;
                Employee::create($data);
            });
        } catch (ValidationException $e) {
            throw $e;
        }

        return back()->with('success', 'Employee saved. If login was checked, they can login with that email/password.');
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email',
            'position' => 'nullable|string|max:80',
            'department' => 'nullable|string|max:80',
            'joining_date' => 'nullable|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,on_leave',
            'address' => 'nullable|string',
        ]);
        $employee->update($data);
        return back()->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Employee deleted.');
    }
}
