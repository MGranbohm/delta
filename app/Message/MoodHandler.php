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
 			$this->assignMood($response);
 			$this->checkLevels();
 		}
 	}

 	public function getRandomMood()
 	{
 		$moodLevel = rand(0,100);
 		return $moodLevel;
 	}

 	public function getLastMood()
 	{

 	}
 	//Checks if the String contains a specific word, then assisning the mood.
 	public function assignMood($watsonAnswer)
 	{		
 		if(strpos($watsonAnswer, 'Fuck') !== false)
 		{
 			$this->moodLevel += 3;
 		}
 		if(strpos($watsonAnswer, 'Sweet') !== false)
 		{
 			$this->moodLevel += -1;
 		}
 	}
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