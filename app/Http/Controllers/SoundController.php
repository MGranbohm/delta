<?php

namespace App\Http\Controllers;

use App\Message\Message;
use Illuminate\Http\Request;
use App\SoundAPI\VoiceRSS;
use App\Watson\WatsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @resource sound
 *
 * Class SoundController
 * @package App\Http\Controllers
 */

class SoundController extends Controller
{
    /**
     * api/sound/{id}
     *
     * Returns mp3 file in raw base 64 encoded data.
     * @param $message_id
     * @return array
     */
	public function watsonSound($id)
	{
		
		$message = Message::find($id);
		$response = $message->watsonResponse;
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
