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

        $test = new MoodHandler();
        $mood = $test->getGeneralMood();
        $c = collect();
        foreach( $messages as $message)
        {
            try {
                $response = $message->WatsonResponse;
                $c->push([$message->message, $response->body]);
            }catch (\Exception $e) {


            }

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
     
    }



    /** Returns a json array with all messages and the corresponding watsonResponse.
     * @return mixed http response
     */
    public function allMessages()
    {
    	$messages = Message::orderBy('created_at', 'asc')->get();
        return response()->json($messages, 200);
    }



    /**Returns the message, the watsonResponse, the moodchange factor and the general mood for the input message id.
     * @param Message $message Input message id.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getMessage(Message $message)
    {
        $response = $message->watsonResponse;
        $mood = $message->mood;
        $responses = WatsonResponse::all();
        $moodHandler = new MoodHandler();
        $generalMood = $moodHandler->getGeneralMood();

        return response([$message, $response, $mood,$generalMood], 200);
    }


    /**Posts a message and returns the posted message, the watson response and the mood change factor;
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postMessage(Request $request)
    {
        $request->validate([
            'message'=>'required'
        ]);

        $message = $this->getMessageApi($request->message);

        return response()->json($message, 201);
    }

//    /**Under construction.
//     * @param Request $request
//     * @param Message $message
//     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
//     */
//    public function update(Request $request,Message $message)
//    {
//        $request->validate([
//            'message'=>'required'
//        ]);
//
//        $response = $message->watsonResponse;
//        $mood = $message->mood;
//        $message->message=$request->message;
//        $response->body=$this->getWatsonResponse($message->message);
//        $responses = WatsonResponse::all();
//        $test = new MoodHandler();
//        $mood->mood=$test->checkWatsonResponse($response->body);
//        $message->save();
//        $response->save();
//        $mood->save();
//        return response($message, 200);
//    }

    /**Deletes a message and corresponding response and mood change from the chat.
     * @param Message $message Message id of message to delete:
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteMessage(Message $message)
    {
        $response = $message->watsonResponse;
        $mood = $message->mood;
        $message->delete();
        $response->delete();
        $mood->delete();
        return response(null, 204);
    }

    /**Returns the general mood at requests point in time.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function getGeneralMood()
    {
        $responses = WatsonResponse::all();
        $test = new MoodHandler();
        $mood = $test->getGeneralMood();
        return response($mood, 200);
    }

    /**Initializes the mood change for the watsonResponse.
     * @param $watsonResponse
     */
    public function setMood($watsonResponse){

        $test = new MoodHandler();
        $test->watsonLowerCase($watsonResponse);

    }

    /**
     * Gets a watson response depending on the input message.
     * @param $message inputmessage
     * @return string   watson response
     */

    public function getMessageApi($message)
    {
        $api = new WatsonAPI();
        $moodHandler = new MoodHander();

        $result = $api->getMessage($message);

        $message = Message::create([
            'message' => $message
        ]);

        $message->mood()->create([
            'mood' => $moodHandler->getMood($result->intent),
        ]);

        $message->watsonResponse()->create([
            'body' => $result->response,
        ]);

        return $message;
    }
}
