<?php

namespace App\Watson;

use Illuminate\Database\Eloquent\Model;
use App\Message\Message;
use Illuminate\Database\Eloquent\SoftDeletes;

class WatsonResponse extends Model
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
    	return $this->belongsTo(Message::class);
    }


    public function toArray()
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
        ];
    }



}
