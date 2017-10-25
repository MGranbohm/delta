<?php
/**
 * Created by PhpStorm.
 * User: Martin Granbohm
 * Date: 2017-10-15
 * Time: 15:44
 */

namespace App\Watson;

use App\Context;

/**
 * Class that handles message communication with
 * IBM Watson Conversation API using cURL.
 * Class WatsonAPI
 * @package App\Watson
 */
class WatsonAPI
{


    /**
     * Gets input message from user, stores values in db and
     * returns a message response from IBM Watson Conversation.
     * @param $input the input message
     * @return string
     */
    public function getMessage($input)
    {
        if($input == '-x'){
            return $this->createDummyData('hello');
        }
        else {
            $inputMessage = $input;
            $contextPrevious = $this->watsonDBgetContext();
            $output = $this->conversation($inputMessage, $contextPrevious);

            $context = $this->getContextObject($output);
            $intent = $this->getIntentObject($output);
            $entity = $this->getEntityObject($output);
            $this->watsonDBinsert($context, $intent, $entity);

            $response = $this->getAnswer($output);
            return compact('response', 'intent');
        }
    }

    public function createDummyData($input)
    {
        $inputMessage = $input;
        $output = $this->conversationContext($inputMessage);
        $context = $this->getContextObject($output);
        $intent = $this->getIntentObject($output);
        $entity = $this->getEntityObject($output);
        $this->watsonDBinsert($context, $intent, $entity);
        $response = $this->getAnswer($output);

        return compact('response', 'intent');
    }

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
        return $result;
    }
    /**
     * Stores response values in database.
     * @param $contextInput
     * @param $intentInput
     * @param $entityInput
     */
    public function watsonDBinsert($contextInput, $intentInput, $entityInput)
    {
        $context = Context::create([
            'context' => $contextInput,
            'intent' => $intentInput,
            'entity' => $entityInput
        ]);
    }

    /**
     * Gets Context from previous message exchanges
     * @return string
     */
    public function watsonDBgetContext()
    {
        $contextDB = Context::orderBy('created_at', 'dsc')->first();
        $res = (string)$contextDB->context;
        return $res;
    }

    /**
     * Gets Intent from previous message exchanges
     * @return string
     */
    public function watsonDBgetIntent()
    {
        $contextDB = Context::orderBy('created_at', 'dsc')->first();
        $res = (string)$contextDB->intent;
        return $res;
    }

    /**
     * Gets Entity from previous message exchanges
     * @return string
     */
    public function watsonDBgetEntity()
    {
        $contextDB = Context::orderBy('timestamps', 'DESC')->first();
        $res = (string)$contextDB->entity;
        return $res;
    }

    /**
     *  Returns a response JSON from IBM Watson Conversation with
     *  the input message and context object from previous communication.
     * @param $message
     * @param $context
     * @return mixed
     */
    public function conversation($message, $context)
    {

        $ch = curl_init();

        if($message === ''){
            curl_setopt($ch, CURLOPT_URL, "https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message?version=2017-05-26");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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
        else

            curl_setopt($ch, CURLOPT_URL, "https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message?version=2017-05-26");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"input": {"text": "'.$message.'"}, "context":'.$context.'}'); // med context objekt
//        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"input": {"text": "'.$message.'"}}'); // without context object
//        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"intents":['.$intent.'],"entities":'.$entity.',"input": {"text": "'.$message.'"}, "Context":'.$context.'}'); // with intents, entity and context

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
     * Returns the response message of an IBM Watson
     * Conversation JSON object as a String.
     * @param $messageJSON
     * @return string Response
     */
    public function getAnswer($messageJSON)
    {
        if($messageJSON === null){
            return "Input was an empty JSON, you get one more chance!";
        }
        $decoded = json_decode($messageJSON);
        $answer = $decoded->output->text;
        $text = json_encode($answer);
        $toReturn = substr($text, 2, -2);

        return $toReturn;
    }

    /**
     * Returns the intent of an IBM Watson Conversation JSON
     * object as a String.
     * @param $messageJSON
     * @return bool|string
     */
    public function getIntentObject($messageJSON)
    {
        if($messageJSON === null){
            return "Input was an empty JSON, you get one more chance!";
        }
        $decoded = json_decode($messageJSON);
        $intent = $decoded->intents;
        $intentObject = json_encode($intent);
        $toReturn = substr($intentObject, 1, -1);
        return $toReturn;
    }

    /**
     * Returns the entity of an IBM Watson Conversation JSON
     * object as a String.
     * @param $messageJSON
     * @return string
     */
    public function getEntityObject($messageJSON)
    {
        if($messageJSON === null){
            return "Input was an empty JSON, you get one more chance!";
        }
        $decoded = json_decode($messageJSON);
        $entity = $decoded->entities;
        $entityObject = json_encode($entity);
        return $entityObject;
    }

    /**
     * Returns the context of an IBM Watson Conversation JSON
     * object as a String.
     * @param $messageJSON
     * @return string
     */
    public function getContextObject($messageJSON)
    {
        if($messageJSON === null){
            return "Input was an empty JSON, you get one more chance!";
        }
        $decoded = json_decode($messageJSON);
        $context = $decoded->context;
        $contextObject = json_encode($context);
        $toReturn = (string)$contextObject;
        return $toReturn;
    }
}