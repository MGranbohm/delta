<?php

namespace App\Message;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mood extends Model
{
	protected $guarded = [];
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

	public function message()
	{
		return $this->hasOne(Message::class);
	}

    public function context()
    {
        return $this->hasOne(Context::class);
    }
}
