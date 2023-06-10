<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    public function index()
    {
        return view('users.index')->with([
            'users' => User::orderBy('name')->paginate(config('constants.paginate_value.paginate_value_for_user')),
        ]);
    }

    public function createUser()
    {
        return view('users.createUser');
    }

    public function registeruser(Request $request)
    {
        // dd('stop',$request->all());
        $validatedData = $this->validator($request->all())->validate();
        if (!$validatedData) {
            return redirect()->route('user.index')->with('error', 'Registration unsuccessful');
        }
    
        $this->create($validatedData);
        return redirect()->route('user.index')->with('success', 'Successfully registered new user!');
    }


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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
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
