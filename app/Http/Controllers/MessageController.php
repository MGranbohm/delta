<?php

namespace App\Http\Controllers;

use App\Message\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function testInput()
    {
        return view( 'testInput');
    }
    public function store(Request $request)
    {
        $request->validate([
            'message'=>'required'
        ]);
        $message = $request->message;
        Message::create([
            'message'=> $message
        ]);


        return $this->testInput();

    }
}
