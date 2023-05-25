<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Subscriber;

class ApiController extends Controller
{
    public function subscriber(Request $request)
    {
        $name = $request->query("name");
        $email = $request->query("Email");
        $phone = $request->query("phoneno");
        $list = $request->query("list");
    
        $emails = Subscriber::pluck('email'); 

        if ($emails->contains($email)) {
        
        




        } else {

        }



        return response()->json([
            "message" => "Data received successfully"], 200);
    }


}
