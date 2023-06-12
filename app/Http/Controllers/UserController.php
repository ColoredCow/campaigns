<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('users.index')->with([
            'users' => User::orderBy('name')->paginate(config('constants.paginate_value.paginate_value_for_user')),
        ]);
    }

    public function destroy(Request $request)
    {        
        $user = User::find($request->id);

        if ($user) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User removed successfully.');
        }

        return redirect()->route('user.index')->with('error', 'User not found.');
    }

    public function create()
    {
        return view('users.createuser');
    }

    public function registerUser(Request $request)
    {
        $validatedData = $this->userService->validator($request->all())->validate();
        if (!$validatedData) {
            return redirect()->route('user.index')->with('error', 'Registration unsuccessful');
        }

        $this->userService->create($validatedData);
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
        if ($request->password)
        {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            $this->userService->update($userid, $name, $email, $password);

            return redirect()->route('user.index')->with('success', 'User updated successfully');
        }
    }
}
