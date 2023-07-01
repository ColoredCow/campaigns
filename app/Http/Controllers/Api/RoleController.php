<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RoleRequest;
use Illuminate\Http\Request;
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

    public function store(RoleRequest $request)
    {
        $validated = $request->validated();
        $role = Role::create($validated);

        return response($role);
    }

    public function show(Role $role)
    {
        return $role;
    }

    public function update(RoleRequest $request, Role $role)
    {
        $validated = $request->validated();
        $role->update($validated);

        return response($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->noContent();
    }

    // Update Role Permission
    public function updateRolePermissions(Request $request)
    {
        if (! isset($request->permissions)) {
            return response()->json(['status' => 'Permissions is required']);
        }
        $role = Role::find($request->roleID);
        $permissions = array_pluck($request->permissions, 'id');
        $isUpdated = $role->syncPermissions($permissions);

        return response()->json(['status' => 'Role Permission updated successfully']);
    }
}
