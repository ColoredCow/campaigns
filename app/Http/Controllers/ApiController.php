<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function subscriber(Request $request)
    {
        $name = $request->query("name");
        $email = $request->query("Email");
        $phone = $request->query("phone");
        $lists = $request->query("list");
    
        $emails = Subscriber::pluck('email'); 
        $names = Subscriber::pluck('name'); 

        if ($emails->contains($email) && $names->contains($name)) {
            foreach ($lists as $list) {
                $this->addSubscriberToList($list, $email);
            }
        } else {
            $newSubscriber = Subscriber::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ]);

            foreach ($lists as $list) {
                $this->addSubscriberToList($list, $email);
            }
        }

        return response()->json([
            "message" => "Data received successfully",
            "mails" => $email,
            "name" => $name,
            "phone" => $phone,
        ], 200);
    }

    public function addSubscriberToList($list, $email) {

        $list = DB::table('lists')->where('name', $list)->first();
        if ($list) {
            $subscriber = Subscriber::where('email', $email)->first();
            $subscriberId = $subscriber->id;
            $listSubscriber = DB::table('list_subscriber')->where('subscriber_id', $subscriberId)->first();

            if ( $listSubscriber ) {
                return;
            } else {
                $this->addingSubscriberToList($list->id, $subscriberId);  
            }

        } else {
            DB::table('list')->insert([
                'name' => $list,
            ]);
            $subscriber = Subscriber::where('email', $email)->first();
            $list = DB::table('lists')->where('name', $list)->first();
            $this->addingSubscriberToList($list->id, $subscriber->id); // this need to be optimize
        }

        return;
    }

    public function addingSubscriberToList($listid, $subscriberId) {
        DB::table('list_subscriber')->insert([
            'list_id' => $listid,
            'subscriber_id' =>$subscriberId,
        ]);
        return;
    }
}


