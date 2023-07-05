<?php

namespace App\Http\Controllers\Api;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return response()->json([
            'permissions' => $permissions,
        ]);
    }
}
