<?php

namespace App\Http\Controllers;

use App\Message\Message;
use App\Message\Mood;
use App\Http\Requests\StorePostRequest;
use App\Watson\WatsonAPI;
use App\Watson\WatsonResponse;
use Illuminate\Http\Request;
use App\Message\MoodHandler;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @resource Messages and responses
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
            try
            {
                $response = $message->WatsonResponse;
                $c->push([$message->message, $response->body]);
            }
            catch (\Exception $e)
            {
            }
        }
        return view( 'testInput', compact('messages', 'responses', 'mood', 'c'));
    }

    /**
     * Validates the response, gets a watson response for the input message and stores both the message and the watson response in the Database.
     * @param Request $request The http request containg the input message.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StorePostRequest $request)
    {

        $api = new WatsonAPI();
        $moodHandler = new MoodHandler();
        $userMessage = $request->message;
        $result = $api->getMessage($userMessage);
        $message = Message::create([
            'message' => $userMessage
        ]);
        $message->mood()->create([
            'mood' => $moodHandler->getMood($result['intent']),
        ]);
        $message->watsonResponse()->create([
            'body' => $result['response'],
        ]);
        return $message;
    }

    /**
     * api/messages/all
     *
     * Returns a json array with all messages and the corresponding watsonResponse and mood change.
     * @return mixed http response
     */
    public function allMessages()
    {
    	$messages = Message::orderBy('created_at', 'asc')->get();
        return response()->json($messages, 200);
    }

    /**
     * api/messages/{id}
     *
     * Returns the message, the watsonResponse, the moodchange factor and the general mood for the input message id.
     *
     * @param Message $message Input message id.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getMessage(Message $id)
    {
        $message = $id;
        $response = $message->watsonResponse;
        $moodHandler = new MoodHandler();
        $generalMood = $moodHandler->getGeneralMood();


        return response()->json(compact('message', 'response', 'generalMood'), 200);
    }

    /**
     * api/responses/{id}
     *
     * Return just the watsonResponse for the input watsonResponse id.
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     */

    public function getResponse(WatsonResponse $id)
    {
        $response = $id;
        return response()->json(compact('response'), 200);
    }
    
    /**
     * api/message/
     *
     * Posts a message and returns the posted message, the watson response and the mood change factor;
     * @param Request $request
     * @return $message
     */
    public function postMessage(StorePostRequest $id)
    {
       $request = $id;
       $message = $this->store($request);
       return response()->json(compact('message'), 201);
    }



    /**
     * api/messages/{id}
     *
     * Deletes a message and corresponding response and mood change from the chat.
     * @param Message $message Message id of message to delete:
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteMessage(Message $id)
    {

        $message = $id;
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
        $test = new MoodHandler();
        $mood = $test->getGeneralMood();
        return response()->json($mood, 200);
    }
}
