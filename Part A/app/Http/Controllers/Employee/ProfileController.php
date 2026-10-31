<?php
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $employee = Employee::with([
            'attendances' => fn ($q) => $q->latest('date')->limit(30),
            'salaries' => fn ($q) => $q->latest()->limit(12),
        ])->where('user_id', $user->id)->first();

        if (!$employee) {
            $employee = Employee::with([
                'attendances' => fn ($q) => $q->latest('date')->limit(30),
                'salaries' => fn ($q) => $q->latest()->limit(12),
            ])->where('email', $user->email)->first();
        }

        return view('employee.profile', compact('employee', 'user'));
    }
}
