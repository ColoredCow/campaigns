<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Api\UserRoleRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): Response
    {
        return response(User::orderBy('name')->paginate(100));
    }

    public function update(UserRequest $request, User $user): Response
    {
        $updatedPassword = Hash::make($request->password);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $updatedPassword,
        ]);

        return response($user);
    }

    public function updateUserRoles(UserRoleRequest $request, User $user)
    {
        $validated = $request->validated();
        $roles = array_pluck($validated['roles'], 'id');
        $isUpdated = $user->syncRoles($roles);

        return response($isUpdated);
    }
}
