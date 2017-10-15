<?php

namespace App\Http\Controllers;

use App\Message\Message;
use App\Message\Mood;
use App\Watson\WatsonAPI;
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

        $message = Message::create([
            'message' => $userMessage
        ]);

	    $watsonResponse = $this->getWatsonResponse($userMessage);

	    $message->watsonResponse()->create([
		    'body' => $watsonResponse,
	    ]);

        return $message;

    }

    public function allMessages()
    {
        return Message::orderBy('created_at', 'asc')->get();
    }

    public function allResponses()
    {
        return WatsonResponse::orderBy('created_at', 'asc')->get();
    }

    public function postMessage(Request $request)
    {
        $message = $this->store($request);
        $response = $message->watsonResponse;
        $mood = $message->mood;

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
        $api = new WatsonAPI();
		return $api->getMessage($message);
    }
}
