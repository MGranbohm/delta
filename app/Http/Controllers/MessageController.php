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
 * @resource Messages, responses and moods
 *
 * Contains methods that access, store and delete the messages, responses and mood data.
 *
 * @package App\Http\Controllers
 */
class MessageController extends Controller
{

    /**
     * Validates the response, gets a watson response for the input message and stores the message, the watson response
     * and the mood changes in the Database.
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
            'general_mood' => $moodHandler->getGeneralMood($result['intent']),
        ]);
        $message->watsonResponse()->create([
            'body' => $result['response'],
        ]);
        return $message;
    }

    /**
     * Get all messages
     *
     * Returns a json array with all messages and the corresponding response, mood change and the general mood at the
     * requests point in time.
     * @return mixed http response
     */
    public function allMessages()
    {
    	$messages = Message::orderBy('created_at', 'asc')->get();
        return response()->json($messages, 200);
    }

    /**
     * Get a specific message
     *
     * Returns the message, the corresponding response, mood change and the general mood at the
     * requests point in time.
     *
     * @param Message $message Input message id.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getMessage(Message $id)
    {
        $message = $id;
        $response = $message->watsonResponse;
        return response()->json(compact('message', 'response'), 200);
    }

    /**
     * Get specific response only
     *
     * Returns just the response for the input response id.
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     */

    public function getResponse(WatsonResponse $id)
    {
        $response = $id;
        return response()->json(compact('response'), 200);
    }
    
    /**
     * Add new message
     *
     * Adds a new input message and returns the input message, the response, the mood change factor
     * and the generalmood at the requests point in time.
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
     * Delete message
     *
     * Deletes a message and corresponding response and the mood changes from the database.
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
}
