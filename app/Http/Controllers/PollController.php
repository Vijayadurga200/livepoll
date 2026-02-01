<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
    public function index()
    {
        $polls = DB::table('polls')->where('status', 'active')->get();
        return view('polls.index', compact('polls'));
    }
    public function show($id)
{
    $poll = DB::table('polls')->where('id', $id)->first();
    $options = DB::table('poll_options')->where('poll_id', $id)->get();

    return view('polls.show', compact('poll', 'options'));
}


}
