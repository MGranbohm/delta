<?php

namespace App\Message;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
	protected $guarded = [];

	public function message()
	{
		return $this->belongsTo(Message::class);
	}
}
