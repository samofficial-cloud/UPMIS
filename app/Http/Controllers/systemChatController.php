<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\system_chat;
use DB;
use App\User;
use Auth;

class systemChatController extends Controller
{
    //
    public function index(){
    	$name=User::orderby('name','asc')->get();
    	//$chats=system_chat::select("IF('sender'= 'Arnold Matemu', 'receiver')")->get();

        $chats = system_chat::select("sender","receiver",
                    \DB::raw('(CASE 
                        WHEN system_chats.sender = "Arnold Matemu" THEN "sender" 
                        WHEN system_chats.receiver = "Arnold Matemu" THEN "receiver" 
                        ELSE "SuperAdmin" 
                        END) AS status_lable'))
        ->distinct('status_lable')
                ->get();
        $chats1=system_chat::select('sender')->where('receiver',Auth::user()->name)->distinct()->get();
        $chats2=system_chat::select('receiver')->where('sender',Auth::user()->name)
         ->whereNotIn('receiver',DB::table('system_chats')->select('sender')->where('receiver',Auth::user()->name)->distinct()->pluck('sender')->toArray())->distinct()->get();

        $received='Arnold Matemu';
                //dd($chats);
         
         return view('notifications',compact('name','chats','received','chats1','chats2'));
    }

    public function sendMessage(Request $request){
    	$receiver=$request->get('receiver_name');
        $sender=$request->get('sender_name');
        $content=$request->get('mcontent');
        $date=date('Y-m-d');
        $time=$request->get('time');
        $data=array('sender'=>$sender,"receiver"=>$receiver,'content'=>$content,'date'=>$date,'time'=>$time);

    DB::table('system_chats')->insert($data);

    $previousUrl = app('url')->previous();
    $prev_url = strtok($previousUrl, '?');

   return redirect()->to($prev_url.'?'. http_build_query(['id'=>$receiver]));

   // return redirect()->route('chatindex')->with('success', 'Message Sent Successfully')->with('received',$receiver);
    }

    public function viewchat($name){
        $today=date('Y-m-d');
        $dates=system_chat::select('date')->where('receiver',$name)->where('sender',Auth::user()->name)->orwhere('sender',$name)->where('receiver',Auth::user()->name)->distinct()->orderBy('date','dsc')->get();

    	$chat=system_chat::where('receiver',$name)->where('sender',Auth::user()->name)->orwhere('sender',$name)->where('receiver',Auth::user()->name)->get();

        $chat1=system_chat::where('receiver',$name)->where('sender',Auth::user()->name)->wheredate('date',$today)->orwhere('sender',$name)->where('receiver',Auth::user()->name)->wheredate('date',$today)->get();

        $chat2=system_chat::where('receiver',$name)->where('sender',Auth::user()->name)->wheredate('date',date('Y-m-d', strtotime("-1 days")))->orwhere('sender',$name)->where('receiver',Auth::user()->name)->wheredate('date',date('Y-m-d', strtotime("-1 days")))->get();

        $chat3=system_chat::where('receiver',$name)->where('sender',Auth::user()->name)->wheredate('date',date('Y-m-d', strtotime("-2 days")))->orwhere('sender',$name)->where('receiver',Auth::user()->name)->wheredate('date',date('Y-m-d', strtotime("-2 days")))->get();
        foreach ($chat1 as $chat) {
            # code...
            DB::table('system_chats')
                ->where('id', $chat->id)
                ->where('receiver',Auth::user()->name)
                ->update(['flag' => '0']);
        }

        foreach ($chat2 as $chat) {
            # code...
            DB::table('system_chats')
                ->where('id', $chat->id)
                ->where('receiver',Auth::user()->name)
                ->update(['flag' => '0']);
        }
        foreach ($chat3 as $chat) {
            # code...
            DB::table('system_chats')
                ->where('id', $chat->id)
                ->where('receiver',Auth::user()->name)
                ->update(['flag' => '0']);
        }
        // foreach ($chat as $chat) {
        //     # code...
        //     DB::table('system_chats')
        //         ->where('id', $chat->id)
        //         ->update(['flag' => '0']);
        // }

    	$receiver=$name;
    	return view('chat',compact('chat','receiver','chat1','chat2','chat3'));
    }
}
