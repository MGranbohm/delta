<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Watson\WatsonResponse;
use App\Message\MoodHandler;
use App\Context;

class MoodController extends Controller
{

	public function check()
	{
		$watsonResponse = Context::all();
		$test = new MoodHandler($watsonResponse);
		$answer = $test->getGeneralMood();
		dd($answer);
		return view('mood');
	}
}
