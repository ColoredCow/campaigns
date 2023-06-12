<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\UsersService;


class UsersController extends Controller
{
    protected $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index()
    {
        return view('users.index')->with([
            'users' => User::orderBy('name')->paginate(config('constants.paginate_value.paginate_value_for_user')),
        ]);
    }

    public function removeUser(Request $request)
    {        
        $user = User::find($request->id);

        if ($user) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User removed successfully.');
        }

        return redirect()->route('user.index')->with('error', 'User not found.');
    }

    public function createUser()
    {
        return view('users.createuser');
    }


    public function registerUser(Request $request)
    {
        $validatedData = $this->usersService->validator($request->all())->validate();
        if (!$validatedData) {
            return redirect()->route('user.index')->with('error', 'Registration unsuccessful');
        }

        $this->usersService->create($validatedData);
        return redirect()->route('user.index')->with('success', 'Successfully registered new user!');
    }

    public function edit(Request $request, $userid)
    {
        $user = User::where('id', $userid)->first();
        return view('users.edit')->with([
            'user' => $user,
        ]);
    }

    public function update(Request $request, $userid)
    {
        if ($request->password !== $request->password_confirmation) {
            return redirect()->route('user.edit', ['user' => $userid])->with('error', 'Passwords do not match');
        }
        if ($request->password)
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $this->usersService->update($userid,$name,$email,$password);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
}
