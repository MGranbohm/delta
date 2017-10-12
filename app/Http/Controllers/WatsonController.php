<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\copy_to_string;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use function MongoDB\BSON\toJSON;

class WatsonController extends Controller
{
    public function getMessage($inputMessage, $inputContext)
    {
//        $data = $this->fetchResponse();
//        $data = $this->fetchCounters();
        $data = $inputContext;
        $inputMessage = "hello";
//        $data = $this->convo($inputMessage, $context);
        return view('watson', compact('data'));
    }

    public function getMessageStart($input)
    {
//        $data = $this->fetchResponse();
//        $data = $this->fetchCounters();
        $inputMessage = $input;
        $data = $this->convo($inputMessage);
        $context = $this->getContext($data);
        $output = $this->conversation($inputMessage, $context);
        $outputput = $this->getAnswer($output);
        return view('watson', compact('outputput'));
    }

    public function convo($data)
    {

        $ch = curl_init();
//        $var = '{"input": {"text": "'.$data.'"}, "context": {"conversation_id": "1b7b67c0-90ed-45dc-8508-9488bc483d5b", "system": {"dialog_stack":[{"dialog_node":"root"}], "dialog_turn_counter": 1, "dialog_request_counter": 1}}}';

        curl_setopt($ch, CURLOPT_URL, "https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message?version=2017-05-26");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"input": {"text": "'.$data.'"}, "Context": {"conversation_id": "6db63f0d-c5ca-4d65-a309-69249f036d12", "system": {"dialog_stack":[{"dialog_node":"root"}], "dialog_turn_counter": 1, "dialog_request_counter": 1}}}');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "7eff2092-b37a-4b23-a754-48a6c83e4266" . ":" . "jK8hBg5gtQFa");
//        dd($ch);
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
//        $something = json_decode($result);
//        $context = $something->context;
//        dd($context);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
//        dd($result);
        return $result;
    }

    public function conversation($data, $context)
    {

        $ch = curl_init();
//        dd($context);
//        $var = '{"input": {"text": "'.$data.'"}, "context": {"conversation_id": "1b7b67c0-90ed-45dc-8508-9488bc483d5b", "system": {"dialog_stack":[{"dialog_node":"root"}], "dialog_turn_counter": 1, "dialog_request_counter": 1}}}';

        curl_setopt($ch, CURLOPT_URL, "https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message?version=2017-05-26");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"input": {"text": "'.$data.'"}, "Context": {"conversation_id": '.$context.', "system": {"dialog_stack":[{"dialog_node":"root"}], "dialog_turn_counter": 2, "dialog_request_counter": 2}}}');
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

    public function getContext($data)
    {
        if($data === null){
            return "context";
        }
        $something = json_decode($data);
        $context = $something->context->conversation_id;
//        dd($context);
        $contextReturn = json_encode($context);
        return $contextReturn;
    }

    public function getAnswer($data)
    {
        if($data === null){
            return "Dude you did something wrong!";
        }
        $something = json_decode($data);
        $context = $something->output->text;
//        dd($context);
        $contextReturn = json_encode($context);
        return $contextReturn;
    }

    public function fetchResponse()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message?version=2017-05-26");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"input": {"text": "hello"}, "context": {"conversation_id": "1b7b67c0-90ed-45dc-8508-9488bc483d5b", "system": {"dialog_stack":[{"dialog_node":"root"}], "dialog_turn_counter": 1, "dialog_request_counter": 1}}}');
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

    public function fetchCounters()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/counterexamples?version=2017-05-26");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_USERPWD, "7eff2092-b37a-4b23-a754-48a6c83e4266" . ":" . "jK8hBg5gtQFa");

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        return $result;
    }
}
