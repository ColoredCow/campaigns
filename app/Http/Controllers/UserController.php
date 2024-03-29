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

        if (request()->has('name') && !is_null(request()->get('name'))) {
            $search = request()->get('name');
            $users = User::where('name', 'like', "%$search%")->latest()->paginate($paginationSize);
        } else {
            $users = User::orderBy('name')->paginate($paginationSize);
        }

        return view('users.index')->with([
            'users' => $users->appends(request()->except('page')),
            'filters' => [
                'name' => $search,
            ],
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit($userid)
    {
        $user = User::where('id', $userid)->first();
        return view('users.edit')->with([
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $validate = $request->validated();
        $this->userService->update($user->id, $validate['name'], $validate['email'], $validate['password']);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
        
    }

    public function store(UserRequest $request)
    {
        $request->validated();
        $this->userService->create($request->all());
        return redirect()->route('user.index')->with('success', 'Successfully registered new user!');
    }

    public function destroy(Request $request,User $user)
    {
        if ($user) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User removed successfully.');
        }

        return redirect()->route('user.index')->with('error', 'User not found.');
    }
}
