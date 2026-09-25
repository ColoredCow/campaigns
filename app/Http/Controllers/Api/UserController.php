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
        $validated = $request->validated();
        $updatedPassword = Hash::make($validated['password']);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $updatedPassword,
        ]);

        return response($user);
    }

    public function show(User $user): Response
    {
        return response($user);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }

    public function updateUserRoles(UserRoleRequest $request, User $user): Response
    {
        $validated = $request->validated();
        $roles = $validated['roles'];
        $userWithUpdatedRoles = $user->syncRoles($roles);

        return response($userWithUpdatedRoles);
    }
}
