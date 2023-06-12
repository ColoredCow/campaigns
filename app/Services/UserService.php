<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function create(array $data)
    {
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function update($userid,$name,$email,$password)
    {
        $user = User::findOrFail($userid);
        if (! $user) {
            return redirect()->route('user.index')->with('error', 'User not found');
        }
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        
        $user->save();
    }
}