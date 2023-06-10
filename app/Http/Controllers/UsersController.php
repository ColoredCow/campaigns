<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('Users.index')->with([
            'users' => User::orderBy('name')->paginate(config('constants.paginate_value.paginate_value_for_user')),
        ]);
    }
}
