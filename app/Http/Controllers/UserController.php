<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

 public function index() {
    $users = User::with('roles')->get();
    $roles = \App\Models\Role::all();  
    return view('users.index', compact('users', 'roles')); 
}


 

    public function store(Request $request) {

        echo json_encode($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone'=>'required|string|max:255',
            'roles' => 'required|array'
        ]);
      
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone'=>$request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
        'phone' => 'required|string|max:255',
        'roles' => 'required|array'
    ]);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();
    $user->roles()->sync($request->roles);

    return redirect()->route('users.index')->with('success', 'User updated successfully!');
}


    public function destroy(User $user) {
        // $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
   public function createRole(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:roles,name',
        'permissions' => 'array', 
        'permissions.*' => 'exists:permissions,id'
    ]);
    echo json_encode($request->all());
    $role = Role::create([
        'name' => $request->name
    ]);
    if ($request->has('permissions')) {
        $role->permissions()->sync($request->permissions);
    }

    return redirect()->back()->with('success', 'Role created with permissions!');
}

public function updateRole(Request $request, Role $role)
    {

        
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);
        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);
        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    // Assign roles to user
    public function assignToUser(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array'
        ]);

        $user->roles()->sync($request->roles ?? []); // sync will assign/unassign automatically

        return redirect()->back()->with('success', 'User roles updated successfully.');
    }
}