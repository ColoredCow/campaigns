<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $numberOfUsers = config('constants.paginate_value.paginate_value_for_user');
        return view('users.index')->with([
            'users' => User::orderBy('name')->paginate($numberOfUsers),
        ]);
    }
}
