<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Api\UpdateRolePermissionsRequest;
use App\Http\Requests\Api\UpdateUserRolesRequest;
use App\Models\User;

class PermissionController extends Controller
{
    // Update Role Permission
    public function updateRolePermissions(UpdateRolePermissionsRequest $request) 
    {
        $validatedData = $request->validated();
        if (! isset($validatedData['permissions'])) {
            return response()->json(['status' => 'Permissions is required']);
        }
        $role = Role::find($validatedData['roleID']);
        $permissions = array_pluck($validatedData['permissions'], 'id');
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
        $roles = array_pluck($validatedData['roles'], 'id');
        $isUpdated = $user->syncRoles($roles);

        return response()->json(['status' => 'User Roles updated successfully']);
    }
}
