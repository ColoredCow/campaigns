<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiController extends Controller
{
    public function subscriber(Request $request)
    {
        // $name = $request->query("name");
        // $email = $request->query("Email");
        // $phone = $request->query("phoneno");
        // $list = $request->query("list");
        
        return response()->json([
            "message" => "Data received successfully"], 200);
    }
}
