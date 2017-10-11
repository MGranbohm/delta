<?php

namespace App\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Watson\WatsonResponse;

/*
* This Class sets moode of the watson dude.
*/
 class MoodHandler
 {
 	private $moodLevel = 50;
 	
 	/*
 	*Construct goes through an array of Strings
 	 from the database and then passes
 	*the data. 
 	*/
 	public function __construct($watsonResponse)
 	{
 		foreach ($watsonResponse as $object){
 			$response = $object->body;
 			var_dump($response);
 			$this->watsonLowerCase($response);
 			$this->checkLevels();
 		}
 	}
 	public function watsonLowerCase($watsonResponse){
 		$watsonResponse = strtolower($watsonResponse);
 		echo $watsonResponse;
 		$this->assignMood($watsonResponse);
 	}

 	public function getRandomMood()
 	{
 		$moodLevel = rand(0,100);
 		return $moodLevel;
 	}

 	public function getLastMood()
 	{

 	}

 	public function checkWatsonResponse($watsonAnswer)
 	{		
 		$bad_words = array("fuck","cunt");
 		foreach($bad_words as $bad_word)
		{
    		if (strpos($watsonAnswer, $bad_word) !== false)
    		{
        		return 3;
    		}else{
    			return -1;
    		}
		}
	}

	public function assignMood($watsonAnswer){
		$result = $this->checkWatsonResponse($watsonAnswer);
		$this->moodLevel += $result;
		echo $result;
	}

 	//Checks if the String contains a specific word, then assisning the mood.
/* 	public function assignMood($watsonAnswer)
 	{		
 		$bad_words = array("fuck","cunt");
 		foreach($bad_words as $bad_word)
		{
    		if (strpos($watsonAnswer, $bad_word) !== false)
    		{
        		echo ' one of the bad words was found';
        		$this->moodLevel += 3;
        		break;
    		}
		}
    	
    	$good_words = array("sweetie");
   		foreach($good_words as $good_word)
		{
    		if (strpos($watsonAnswer, $good_word) !== false)
    		{
        		echo ' one of the good good was found';
        		$this->moodLevel -= 1;
        		break;
    		}
  		}
	}*/

 	//Check if the dude reached maxiumum happiness or anger.
 	public function checkLevels(){
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
 		return $this->moodLevel;
 	}

//skicka in en string. få tillbaka ett värde.

 }