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
        $bad_words = array("intelligence_mean","insults");
        $nice_words = array("flirting","inteligence_nice");

        foreach($bad_words as $bad_word) {
            if ($watsonAnswer == $bad_word) {
                return 100;
            }
        }

        foreach($nice_words as $nice_word ) {
            if ($watsonAnswer == $nice_word) {
                return -40;
            }
        }

        return 0;
    }

    /**
     * Checks if the mood goes above or below maximum level.
     */
    public function checkLevels($generalMood)
    {
        if( $generalMood < 0 ) {
            $generalMood = 0;
        }

        if( $generalMood > 255 ) {
            $generalMood = 255;
        }

        return $generalMood;
    }

    /**
     * decodes json objects intent
     */
    public function getMood($intent)
    {
        $obj = json_decode($intent);
        if(! $obj) {
            return 0;
        }

        $intent = $obj->{'intent'};

        return $this->checkWatsonResponse($intent);
    }

    public function getGeneralMood($intent)
    {
        $rows = Mood::count();

        $obj = json_decode($intent);

        if(! $obj) {
            return 0;
        }

        $intent = $obj->{'intent'};
        
        if( $rows == 0  ){
            $generalMood = 100;
        }else{
            $latestGeneralMood = Mood::latest()->first()->general_mood;
            $differenceMood = $this->checkWatsonResponse($intent);
            $generalMood = $latestGeneralMood + $differenceMood;
        }

        return $this->checkLevels($generalMood);
    }
}