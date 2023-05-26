<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Models\Lists;
use App\Models\SubscriptionList;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function subscriber(Request $request)
    {
        $name = $request->query("name");
        $email = $request->query("Email");
        $phone = $request->query("phone");
        $stringlists = $request->query("list");
        $lists = explode(',', $stringlists);

        $emails = Subscriber::pluck('email'); 
        
        if ($emails->contains($email)) {
            foreach ($lists as $list) {
                $this->addSubscriberToList($list, $email);
            }
        } else {
            Subscriber::create([
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
        $existingList = SubscriptionList::where('name', $list)->first();
        if ($existingList) {
            $subscriber = Subscriber::where('email', $email)->first();
            $subscriberId = $subscriber->id;
            $listSubscriber = DB::table('list_subscriber')->where('subscriber_id', $subscriberId)->first();

            if ($listSubscriber) {
                return;
            } else {
                $this->addingSubscriberToList($existingList->id, $subscriberId);
            }

        } else {
            SubscriptionList::create([
                'name' => $list,
            ]);

            $subscriber = Subscriber::where('email', $email)->first();
            $list = DB::table('lists')->where('name', $list)->first();

            $this->addingSubscriberToList($list->id, $subscriber->id);
        }
    }


    public function addingSubscriberToList($listid, $subscriberId) {
        DB::table('list_subscriber')->insert([
            'list_id' => $listid,
            'subscriber_id' =>$subscriberId,
        ]);
    }

}
