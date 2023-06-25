<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;

class PermissionController extends Controller
{
    // Update Role and Permission
    public function store(Request $request) {
        if (! isset($request['permissions'])) {
            return response()->json(['status' => 'Permissions is required']);
        }
        $role = Role::find($request->roleID);
        $permissions = collect($request['permissions'], 'id');
        $isUpdated = $role->syncPermissions($permissions);

        return response()->json(['status' => 'Role Permission updated successfully']);
    }

    // Update the User roles
    public function update(Request $request)
    {
        if (! isset($request['roles'])) {
            return response()->json(['status' => 'Roles is required']);
        }
        $user = User::find($request->userID);
        $roles = collect($request['roles'], 'id');
        $isUpdated = $user->syncRoles($roles);
        dd($isUpdated);

        return response()->json(['status' => 'User Roles updated successfully']);
    }
}
