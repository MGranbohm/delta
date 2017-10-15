<?php

namespace App\Http\Controllers;

use App\Watson\WatsonAPI;
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
    private $apiConnection;

    public function __construct()
    {
        $this->apiConnection = new WatsonAPI();
    }
    public function getResponse($input)
    {
        $response = $this->apiConnection->getMessage($input);

        return view('watson', compact('response'));
    }
}