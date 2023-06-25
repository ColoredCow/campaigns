<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Http\Requests\Api\UpdateRolePermissionsRequest;
use App\Http\Requests\Api\UpdateUserRolesRequest;
use App\Models\User;

class PermissionController extends Controller
{
    // Update Role Permission
    public function updateRolePermissions(UpdateRolePermissionsRequest $request) {
        $validatedData = $request->validated();
        if (! isset($request['permissions'])) {
            return response()->json(['status' => 'Permissions is required']);
        }
        $role = Role::find($validatedData['roleID']);
        $permissions = collect($validatedData['permissions'], 'id');
        $isUpdated = $role->syncPermissions($permissions);

        return response()->json(['status' => 'Role Permission updated successfully']);
    }

    // Update the User roles
    public function updateUserRoles(UpdateUserRolesRequest $request)
    {
        $validatedData = $request->validated();
        if (! isset($validatedData['roles'])) {
            return response()->json(['status' => 'Roles is required']);
        }
        $user = User::find($validatedData['userID']);
        $roles = collect($validatedData['roles'], 'id');
        $isUpdated = $user->syncRoles($roles);

        return response()->json(['status' => 'User Roles updated successfully']);
    }
}
