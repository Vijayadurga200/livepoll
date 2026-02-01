<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Request $request)
{
 $ip = request()->ip();

 $exists = DB::table('votes')
  ->where('poll_id',$request->poll_id)
  ->where('ip_address',$ip)
  ->exists();

 if($exists){
  return response()->json(['error'=>'Already voted from this IP']);
 }

 DB::table('votes')->insert([
  'poll_id'=>$request->poll_id,
  'option_id'=>$request->option_id,
  'ip_address'=>$ip
 ]);

 DB::table('vote_history')->insert([
  'poll_id'=>$request->poll_id,
  'ip_address'=>$ip,
  'new_option_id'=>$request->option_id,
  'action'=>'voted'
 ]);

 return response()->json(['success'=>'Vote counted']);
}
use Illuminate\Support\Facades\DB;

public function results($id)
{
    return DB::table('votes')
        ->select('option_id', DB::raw('count(*) as total'))
        ->where('poll_id', $id)
        ->groupBy('option_id')
        ->get();
}

}
public function release($poll_id,$ip)
{
 $vote = DB::table('votes')
  ->where('poll_id',$poll_id)
  ->where('ip_address',$ip)
  ->first();

 DB::table('vote_history')->insert([
  'poll_id'=>$poll_id,
  'ip_address'=>$ip,
  'old_option_id'=>$vote->option_id,
  'action'=>'released'
 ]);

 DB::table('votes')
  ->where('poll_id',$poll_id)
  ->where('ip_address',$ip)
  ->delete();

 return response()->json(['success'=>'Released']);
}
