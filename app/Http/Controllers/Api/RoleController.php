<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RolesRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return response()->json([
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function store(RolesRequest $request)
    {
        $validated = $request->validated();
        $role = Role::create($validated);

        return response()->json(['status' => 'Role created successfully']);
    }

    public function show(Role $role)
    {
        return $role;
    }

    public function update(RolesRequest $request, Role $role)
    {
        $validated = $request->validated();
        $role->update($validated);

        return response()->json(['status' => 'Role updated successfully']);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['status' => 'Role deleted successfully']);
    }
}
