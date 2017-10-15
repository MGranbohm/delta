<?php

namespace App\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Watson\WatsonResponse;

/**
* This Class sets moode of the watson dude.
*/
 class MoodHandler
 {
 	private $moodLevel = 50;
     /**
 	*Construct goes through an array of Strings
 	*from the database and then passes
 	*the data. 
 	*/
     public function __construct($watsonResponses)
 	{
 		foreach ($watsonResponses as $response)
 		{
// 			$response = $object->body;

// 			var_dump($response);
 			$this->watsonLowerCase($response);
 			$this->checkLevels();
 		}
 	}

     /**
      * @param $watsonResponse
      */
     public function watsonLowerCase($response)
    {
        $watsonResponseBody = $response->body;
 		$watsonResponseBody = strtolower($watsonResponseBody);
 		$response->body=$watsonResponseBody;
 		$response->save();
 		echo $response;
 		$this->assignMood($response);
 	}

     public function getRandomMood()
 	{
 		$moodLevel = rand(0,100);
 		return $moodLevel;
 	}

     /**
      *
      */
     public function getLastMood()
 	{

 	}

     /**
      * @param $watsonAnswer
      * @return int
      */
     public function checkWatsonResponse($watsonAnswer)
 	{		
 		$bad_words = array("fuck","cunt");
 		foreach($bad_words as $bad_word)
		{
    		if (strpos($watsonAnswer, $bad_word) !== false)
    		{
        		return 3;
    		}else
            {
    			return -1;
    		}
		}
	}

     /**
      * @param $watsonAnswer
      */
     public function assignMood($response)
    {
		$result = $this->checkWatsonResponse($response->body);


		$message=$response->message;
		$mood = new Mood();
		$mood->mood=$result;
		$message->mood()->save($mood);
		echo $result;
	}

     /**
      * Checks if the String contains a specific word, then assisning the mood.
      */
     public function checkLevels()
    {
 		if($this->moodLevel < 0)
 		{
 			$this->moodLevel = 0;
 		}
 		if($this->moodLevel > 100)
 		{
 			$this->moodLevel = 100;
 		}
 	}


 	public function getGeneralMood(){
         $generalMood = 50;
         $moods = Mood::all();
         foreach($moods as  $mood)
         {
            $generalMood=$generalMood+$mood->mood;
         }
 		return $generalMood;
 	}

//skicka in en string. få tillbaka ett värde.

 }