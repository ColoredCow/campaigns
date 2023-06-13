<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $search = null;
        $paginationSize = config('constants.paginate_value.paginate_value_for_user');
        if (request()->has('s') && !is_null(request()->get('s'))) {
            $paginationSize = 100;
            $search = request()->get('s');
            $users = User::where('name', 'like', "%$search%")->latest()->paginate($paginationSize);
        } else {
            $users = User::orderBy('name')->paginate($paginationSize);
        }

        return view('users.index')->with([
            'users' => $users,
            'filters' => [
                's' => $search,
            ],
        ]);
    }

    public function create()
    {
        return view('users.createuser');
    }

    public function edit($userid)
    {
        $user = User::where('id', $userid)->first();
        return view('users.edit')->with([
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, $userid)
    {
        $request->validated();
        if ($request->password) {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            $this->userService->update($userid, $name, $email, $password);

            return redirect()->route('user.index')->with('success', 'User updated successfully');
        }
    }

    public function store(UserRequest $request)
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
