<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'department', 'hod'])->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();
        $hodRole = Role::where('name', 'HOD')->first();
        $hods = User::where(function($q) use ($hodRole) {
            if ($hodRole) {
                $q->where('role_id', $hodRole->id);
            }
            $q->orWhere('name', 'General Manager');
        })->get();
        // Get Department User role id for JS conditional logic
        $deptUserRoleId = Role::where('name', 'Department User')->first()?->id;
        return view('users.create', compact('roles', 'departments', 'hods', 'deptUserRoleId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
            'hod_id' => 'nullable|exists:users,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $departments = Department::all();
        $hodRole = Role::where('name', 'HOD')->first();
        $hods = User::where(function($q) use ($hodRole) {
            if ($hodRole) {
                $q->where('role_id', $hodRole->id);
            }
            $q->orWhere('name', 'General Manager');
        })->get();
        $deptUserRoleId = Role::where('name', 'Department User')->first()?->id;
        return view('users.edit', compact('user', 'roles', 'departments', 'hods', 'deptUserRoleId'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
            'hod_id' => 'nullable|exists:users,id',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $validated['password'] = Hash::make($request->password);
        }

        // Clear hod_id if role is not Department User
        $deptUserRole = Role::where('name', 'Department User')->first();
        if ($deptUserRole && $validated['role_id'] != $deptUserRole->id) {
            $validated['hod_id'] = null;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
