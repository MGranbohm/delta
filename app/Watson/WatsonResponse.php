<?php

namespace App\Watson;

use Illuminate\Database\Eloquent\Model;

class WatsonResponse extends Model
{
    protected $guarded = [];

    public function message()
    {
    	return $this->belongsTo(Message::class);
    }
}
