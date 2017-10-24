<?php

namespace App\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Watson\WatsonResponse;
use App\Message\Mood;
use Illuminate\Support\Facades\Log;

/**
* This Class sets moode of the watson dude.
*/
class MoodHandler
{
      /**
      * converts the responses to lowercase.
      */
      public function watsonLowerCase($response)
      {
        $watsonResponseBody = $response->intent;
        $watsonResponseBody = strtolower($watsonResponseBody);
        $response->intent=$watsonResponseBody;
        $response->save();
         
        $this->assignMood($response);
      }

      public function getRandomMood()
      {
        $moodLevel = rand(0,100);
        return $moodLevel;
      }

      /**
      * Checks if the user wrote something nice or mean.
      * Return possitive number for bad things and negative 
      * number for nice responses.
      */
      public function checkWatsonResponse($watsonAnswer)
      {	

        $bad_words = array("Intelligence_mean","Insults");
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

        //$result = $this->checkWatsonResponse($response->intent);
        //$message=$response->mood;
        $mood = new Mood();
        $mood->intent=$hej;
        $response->mood()->save($mood);
        //echo $result;
      }

      /**
      * Checks if the mood goes above or below maximum level.
      */
      public function checkLevels($generalMood)
      {
        if( $generalMood < 0)
        {
        
          $generalMood = 0;
        
        }
        if( $generalMood > 100)
        {

          $generalMood = 100;
      
        }
        return $generalMood;
      }

      /**
      * decodes json objects intent
      */
      public function getMood($intent)
      {

        $obj = json_decode($intent);
        $intent = $obj->{'intent'};
      
        return  $this->checkWatsonResponse($intent);
      }

      public function getGeneralMood()
      {

        $generalMood = 50;
        $moods = Mood::all();
        
        foreach($moods as  $mood)
        {
      
          $generalMood=$generalMood+$mood->mood;
          
        }

        $generalMood = $this->checkLevels($generalMood);

        return $generalMood;
      }
}