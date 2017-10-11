<?php

namespace App\Http\Controllers;

use App\Message\Message;
use App\Watson\WatsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function testInput()
    {
        $messages = Message::all();
        $responses = WatsonResponse::all();
        return view( 'testInput', compact('messages'), compact('responses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'message'=>'required'
        ]);
        $userMessage = $request->message;
        $watsonResponse = $this->getWatsonResponse($userMessage);
        $responseModel = new WatsonResponse();
        $responseModel->response = $watsonResponse;
        $messageModel=Message::create([
            'message'=> $userMessage
        ]);
        $messageModel->watsonResponse()->save($responseModel);


        return $this->testInput();

    }
    public function getWatsonResponse($message)
    {
        if ($message=='You suck'){
            $message='Fuck';
        }
        elseif ($message=='You rule'){
            $message='Sweet';
        }else{
            $message='meh';
        }
        return $message;


    }
}
