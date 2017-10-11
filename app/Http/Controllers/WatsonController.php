<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class WatsonController extends Controller
{
    public function getMessage()
    {
        $data = $this->fetchResponse();
        return view('watson', compact('data'));
    }

    public function fetchResponse()
    {
//        $client = new Client(['base_uri' => 'https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message/']);
//        $auth = [
//            'username' => env('WATSON_API_USERNAME'),
//            'password' => env('WATSON_API_PASSWORD')
//        ];
//        $client->
//        $response = $client->post('hi', $auth)->withHeader('authentication', 'auth');
//
//        $response = Curl::to('https://gateway-fra.watsonplatform.net/conversation/api/v1/workspaces/5f1d789d-abff-4597-880f-faa758f553b7/message/')
//            ->withData( array( 'username' => env('WATSON_API_USERNAME'), 'password' => env('WATSON_API_PASSWORD'),'workspace_id' => '5f1d789d-abff-4597-880f-faa758f553b7', 'version' => '2017-05-26' ) )
//            ->post();

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
}
