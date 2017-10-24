<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message\Mood;
class Context extends Model
{
    protected $guarded = [];

    public function mood()
	{
		return $this->belongsTo(Mood::class);
	}
}
