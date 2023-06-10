<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function index()
    {
        return view('users.index')->with([
            'users' => User::orderBy('name')->paginate(config('constants.paginate_value.paginate_value_for_user')),
        ]);
    }

    public function edit(Request $request, $userid)
    {
       
        $user = User::where('id',$userid)->first();
        return view('users.edit')->with([
            'user' => $user,
        ]);
    }

    public function update(Request $request,$userid)
    {
        $user = User::findOrFail($userid);
        if (! $user) {
            return redirect()->route('user.index')->with('error', 'User not found');
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->save();

    return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
}
