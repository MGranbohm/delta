<?php

namespace App\Message;

use App\Watson\WatsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function watsonResponse()
    {
    	return $this->hasOne(WatsonResponse::class);
    }

    public function mood()
    {
    	return $this->hasOne(Mood::class);
    }

    public function toArray()
    {
    	return [
    		'id' => $this->id,
    	    'message' => $this->message,
		    'response' => $this->watsonResponse->body,
	    ];
    }
}
