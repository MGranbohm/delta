<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Watson\WatsonResponse;
use App\Message\MoodHandler;

class MoodController extends Controller
{

	public function check()
	{
		$watsonResponse = WatsonResponse::all();
		$test = new MoodHandler($watsonResponse);
		$answer = $test->getGeneralMood();
		dd($answer);
		return view('mood');
	}
}
