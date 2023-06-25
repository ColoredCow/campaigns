<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return $roles;
    }

    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return response()->json(['status' => 'Role created successfully']);
    }

    public function show(Role $role)
    {
        return $role;
    }

    public function update(Request $request, Role $role)
    {

        $role->update([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return response()->json(['status' => 'Role updated successfully']);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['status' => 'Role deleted successfully']);
    }
}
