<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\ValidateUser;

class UserController extends Controller
{
        /**
     * Store a new blog post.
     *
     * @param  \App\Http\Requests\ValidateUser  $request
     * @return Illuminate\Http\Response
     */

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

    public function create()
    {
        return view('users.createuser');
    }

    public function edit(Request $request, $userid)
    {
        $user = User::where('id', $userid)->first();
        return view('users.edit')->with([
            'user' => $user,
        ]);
    }

    public function update(ValidateUser $request, $userid)
    {
        $request->validated();
        if ($request->password)
        {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            $this->userService->update($userid, $name, $email, $password);

            return redirect()->route('user.index')->with('success', 'User updated successfully');
        }
    }

    public function registerUser(ValidateUser $request)
    {
        $request->validated();
        $this->userService->create($request->all());
        return redirect()->route('user.index')->with('success', 'Successfully registered new user!');
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
}
