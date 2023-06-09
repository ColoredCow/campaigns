<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index')->with([
            'users' => User::orderBy('name')->paginate(25),
        ]);
    }
}
