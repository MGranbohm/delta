<?php

namespace App\Http\Controllers;

use App\Message\Message;
use App\Message\Mood;
use App\Watson\WatsonResponse;
use Illuminate\Http\Request;
use App\Message\MoodHandler;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

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

        $test = new MoodHandler($responses);
        $mood = $test->getGeneralMood();
        $c = collect();
        foreach( $messages as $message)
        {
            $response = $message->WatsonResponse;
//            var_dump($response);
            $c->push([$message->message, $response->body]);
        }




        return view( 'testInput', compact('messages', 'responses', 'mood', 'c'));
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
        $messageModel = Message::create([
            'message'=> $userMessage
        ]);
        $messageModel->watsonResponse()->save($responseModel);




    }
    public function allMessages()
    {
        return Message::all();
    }
    public function allResponses()
    {
        return WatsonResponse::all();
    }
    public function postMessage(Request $request)
    {
        $this->store($request);
        $message= Message::where('message','=', $request->message)->first();
        $response =$message->watsonResponse;
        $mood= $message->mood;

        return response(compact('response','mood'), 201);
    }

    public function update(Request $request,Message $message)
    {
        $request->validate([
            'message'=>'required'
        ]);

        $response= $message->watsonResponse;
        $mood = $message->mood;
        $message->message=$request->message;
        $response->body=$this->getWatsonResponse($message->message);
        $responses = WatsonResponse::all();
        $test = new MoodHandler($responses);
        $mood->mood=$test->checkWatsonResponse($response->body);
        $message->save();
        $response->save();
        $mood->save();
        return response($message, 200);
    }

    public function deleteMessage(Message $message)
    {

        $response= $message->watsonResponse;
        $mood = $message->mood;
        $message->delete();
        $response->delete();
        $mood->delete();
        return response(null, 204);
    }

    public function getResponse(Message $message)
    {
        $response= $message->watsonResponse;
        return response($response, 200);
    }
    public function getGeneralMood()
    {
        $responses = WatsonResponse::all();
        $test = new MoodHandler($responses);
        $mood = $test->getGeneralMood();
        return response($mood, 200);
    }

    /**
     * Gets a watson response depending on the input message.
     * @param $message inputmessage
     * @return string   watson response
     */
    public function getWatsonResponse($message)
    {
        if ($message == 'You suck')
        {
            $message = 'Fuck';
        }
        elseif ($message == 'You rule')
        {
            $message = 'Sweet';
        }else
        {
            $message = 'meh';
        }
        return $message;


    }
}
