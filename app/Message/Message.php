<?php

namespace App\Message;

use App\Watson\WatsonResponse;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function watsonResponse()
    {
    	return $this->hasOne(WatsonResponse::class);
    }

    public function mood()
    {
    	return $this->hasOne(Mood::class);
    }

}
