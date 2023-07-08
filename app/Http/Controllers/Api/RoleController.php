<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RolePermissionRequest;
use App\Http\Requests\Api\RoleRequest;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): Response
    {
        $roles = Role::all();

        return response($roles);
    }

    public function store(RoleRequest $request): Response
    {
        $validated = $request->validated();
        $role = Role::create($validated);

        return response($role);
    }

    public function show(Role $role): Response
    {
        return response($role);
    }

    public function update(RoleRequest $request, Role $role): Response
    {
        $validated = $request->validated();
        $role->update($validated);

        return response($role);
    }

    public function destroy(Role $role): Response
    {
        $role->delete();

        return response()->noContent();
    }

    public function updateRolePermissions(RolePermissionRequest $request, Role $role): Response
    {
        $validated = $request->validated();
        $permissions = $validated['permissions'];
        $roleWithUpdatedPermission = $role->syncPermissions($permissions);

        return response($roleWithUpdatedPermission);
    }
}
