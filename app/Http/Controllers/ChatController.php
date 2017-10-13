<?php

namespace App\Http\Controllers;

use App\Message\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

class ChatController extends Controller
{
    public function index()
    {
    	return view('chat');
    }

}
