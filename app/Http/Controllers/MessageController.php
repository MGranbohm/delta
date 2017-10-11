<?php

namespace App\Http\Controllers;

use App\Message\Message;
use App\Watson\WatsonResponse;
use Illuminate\Http\Request;

/**
 * Class MessageController
 * stores input message, watson response.
 * @package App\Http\Controllers
 */
class MessageController extends Controller
{
    public function testInput()
    {
        $messages = Message::all();
        $responses = WatsonResponse::all();
        return view( 'testInput', compact('messages'), compact('responses'));
    }

    /**
     * Validates the response, gets a watson response for the input message and stores both the message and the watson response in the Database.
     * @param Request $request The http request containg the input message.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $request->validate([
            'message'=>'required'
        ]);
        $userMessage = $request->message;
        $watsonResponse = $this->getWatsonResponse($userMessage);
        $responseModel = new WatsonResponse();
        $responseModel->body = $watsonResponse;
        $messageModel=Message::create([
            'message'=> $userMessage
        ]);
        $messageModel->watsonResponse()->save($responseModel);


        return $this->testInput();

    }

    /**
     * Gets a watson response depending on the input message.
     * @param $message inputmessage
     * @return string   watson response
     */
    public function getWatsonResponse($message)
    {
        if ($message=='You suck'){
            $message='Fuck off';
        }
        elseif ($message=='You rule'){
            $message='Sweet';
        }else{
            $message='meh';
        }
        return $message;


    }
}
