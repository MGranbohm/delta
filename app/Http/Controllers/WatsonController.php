<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Context;

/**
 * Class that handles message communication with
 * IBM Watson Conversation API using cURL.
 *
 * Class WatsonController
 * @package App\Http\Controllers
 */
class WatsonController extends Controller
{
    /**
     * Gets input message from user and returns a view with a message response
     * returned from IBM Watson Conversation.
     * @param $input
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMessage($input)
    {
        $inputMessage = $input;

        $contextPrevious = $this->watsonDBgetContext();
//        $intentPrevious = $this->watsonDBgetIntent();
//        $intent = $this->getIntentObject($output);
//        dd($intentPrevious);

//        $output = $this->conversation($inputMessage, $contextPrevious, $intentPrevious);
//        dd($output);
        $output = $this->conversationContext($inputMessage);
//        dd($output);
        $context = $this->getContextObject($output);
        $intent = $this->getIntentObject($output);
//        dd($intent);

        $this->watsonDBinsert($context, $intent);

        $response = $this->getAnswer($output);
        return view('watson', compact('response'));
    }

    public function watsonDBinsert($contextInput, $intentInput)
    {
        Context::create([
            'context' => $contextInput,
            'intent' => $intentInput
        ]);
    }

    public function watsonDBgetContext()
    {
        $contextDB = Context::orderBy('timestamps')->first();
//        $contextDB = Context::
        $res = (string)$contextDB->id;
        dd($res);
        return $res;
    }

    public function watsonDBgetIntent()
    {
        $contextDB = Context::orderBy('created_at')->first();
        $res = (string)$contextDB;
        return $res;
    }

    /**
     * Returns a response JSON from IBM Watson Conversation with
     * the input data as message.
     * @param $message input
     * @return response as JSON object
     */
    public function conversationContext($message)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message?version=2017-05-26");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"input": {"text": "'.$message.'"}, "Context": {"conversation_id": "6db63f0d-c5ca-4d65-a309-69249f036d12", "system": {"dialog_stack":[{"dialog_node":"root"}], "dialog_turn_counter": 1, "dialog_request_counter": 1}}}');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "7eff2092-b37a-4b23-a754-48a6c83e4266" . ":" . "jK8hBg5gtQFa");
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        return $result;
    }

    /**
     * Returns a response JSON from IBM Watson Conversation with
     * the input data and conversation_id from previous communication.
     * @param $message input
     * @param $conversation_id from previous conversation
     * @return response as JSON object
     */
    public function conversation($message, $context, $intent)
    {

        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, "https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message?version=2017-05-26");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"input": {"text": "'.$message.'"}, "Context":'.$context.'}');
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"input": {"text": "'.$message.'"}, "Context":'.$context.'}'.$intent.'');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "7eff2092-b37a-4b23-a754-48a6c83e4266" . ":" . "jK8hBg5gtQFa");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        $result = curl_exec($ch);

//        dd($result);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        return $result;
    }

    /**
     * Returns the $conversation_id part of an IBM Watson Conversation JSON
     * object as a String.
     * @param $messageJSON
     * @return string conversation_id
     */
    public function getContext($messageJSON)
    {
        if($messageJSON === null){
            return "context";
        }
        $something = json_decode($messageJSON);
        $context = $something->context->conversation_id;
        $contextReturn = json_encode($context);
        return $contextReturn;
    }

    /**
     * Returns the response part of an IBM Watson Conversation JSON
     * object as a String.
     * @param $messageJSON
     * @return string Response
     */
    public function getAnswer($messageJSON)
    {
        if($messageJSON === null){
            return "Dude you did something wrong!";
        }
        $something = json_decode($messageJSON);
        $context = $something->output->text;
        $text = json_encode($context);
        $toReturn = substr($text, 2, -2);

        return $toReturn;
    }

    public function getIntentObject($messageJSON)
    {
        if($messageJSON === null){
            return "intent";
        }
        $something = json_decode($messageJSON);
        $intent = $something->intents;
        $intentObject = json_encode($intent);
        $toReturn = substr($intentObject, 1, -1);
        return $toReturn; // returnerar intent rätt
    }

    public function getContextObject($messageJSON)
    {
        if($messageJSON === null){
            return "context";
        }
//        dd($messageJSON);
        $decoded = json_decode($messageJSON);
        $context = $decoded->context;
        $contextObject = json_encode($context);
        $toReturn = (string)$contextObject;
        return $toReturn;
    }
}