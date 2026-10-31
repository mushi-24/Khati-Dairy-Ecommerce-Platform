<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query();
        if ($request->filled('role')) $q->where('role', $request->role);
        $users = $q->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:customer,admin,manager,employee,shop_owner',
            'phone' => 'nullable|string|max:30',
            'shop_id' => 'nullable|exists:shops,id',
            'is_active' => 'nullable|boolean',
        ]);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone' => $data['phone'] ?? null,
            'shop_id' => $data['shop_id'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return back()->with('success', 'User created.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'role' => 'required|in:customer,admin,manager,employee,shop_owner',
            'phone' => 'nullable|string|max:30',
            'shop_id' => 'nullable|exists:shops,id',
            'is_active' => 'nullable|boolean',
            'password' => 'nullable|string|min:6',
        ]);
        $user->name = $data['name'];
        $user->role = $data['role'];
        $user->phone = $data['phone'] ?? null;
        $user->shop_id = $data['shop_id'] ?? null;
        $user->is_active = $request->boolean('is_active', true);
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        return back()->with('success', 'User updated.');
    }
}
