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
		$watsonContains = WatsonResponse::where('body','=','Fuck off')->first();
		
		$answer= '';

		$test = new MoodHandler($watsonResponse);
		//$test->assignMood($watsonContains);
		$answer = $test->getGeneralMood();
		$answer2 = $test->getRandomMood();
		dd($answer);
	//	dd($answer2);

		return view('mood' , compact('watsonContains'));
	}
}
