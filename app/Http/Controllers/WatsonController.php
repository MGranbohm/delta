<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WatsonController extends Controller
{
    public function getMessage()
    {
        $data = 'wazzup';
        return view('watson', compact('data'));
    }
}
