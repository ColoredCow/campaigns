<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RolePermissionRequest;
use App\Http\Requests\Api\RoleRequest;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return response($roles);
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

    public function updateRolePermissions(RolePermissionRequest $request, Role $role)
    {
        $validated = $request->validated();
        $permissions = array_pluck($validated['permissions'], 'id');
        $isUpdated = $role->syncPermissions($permissions);

        return response($isUpdated);
    }
}
