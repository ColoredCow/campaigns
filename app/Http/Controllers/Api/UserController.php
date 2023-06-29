<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): Response
    {
        return response(User::paginate(100));
    }

    public function update(Request $request, User $user)
    {
        $updatedPassword = Hash::make($request->password);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $updatedPassword,
        ]);

        return response()->json(['status' => 'User updated successfully']);
    }
}
