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
     * Return negative numbers for bad things and possitive
     * number for nice responses.
     */
    public function checkWatsonResponse($watsonAnswer)
    {
        $bad_words = array("intelligence_mean","insults","skynet");
        $nice_words = array("flirting","inteligence_nice");
        
        foreach($bad_words as $bad_word) {
            if (strpos($watsonAnswer, $bad_word) !== false) {
                return -40;
            }
        }

        foreach($nice_words as $nice_word ) {
            if (strpos($watsonAnswer, $nice_word) !== false) {
                return 4;
            } else {
                return 1;
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
        if( $generalMood < 0 ) {
            $generalMood = 0;
        }

        if( $generalMood > 100 ) {
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

    public function getGeneralMood($intent)
    {
        $rows = Mood::count();
        
        if( $rows == 0  ){
            $generalMood = 50;    
        }else{
            $latestGeneralMood = Mood::latest()->first()->general_mood;
            $differenceMood = $this->checkWatsonResponse($intent);
            $generalMood = $latestGeneralMood + $differenceMood;
        }

        return $this->checkLevels($generalMood);
    }
}