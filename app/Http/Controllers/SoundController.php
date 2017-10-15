<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoundAPI\VoiceRSS;
use App\Watson\WatsonResponse;

class SoundController extends Controller
{

	public function watsonSound($message_id)
	{
		$response = WatsonResponse::find($message_id);
		$tts = new VoiceRSS;
		$voice = $tts->speech([
			'key' => 'accee06bc1c84ae3919f4b87255c263c',
			'hl' => 'en-us',
			'src' => $response->body,
			'r' => '0',
			'c' => 'mp3',
			'f' => '44khz_16bit_stereo',
			'ssml' => 'false',
			'b64' => 'true'
		]);

		$voice = $voice['response']; 
		return $voice;
	}
}
