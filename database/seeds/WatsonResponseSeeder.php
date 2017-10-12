<?php

use Illuminate\Database\Seeder;
use App\Message\Message;

class WatsonResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $message = Message::create([]);
        $message->watsonResponse()->create([
            'body' => "Thank you SWEETIE",
        ]);
    }
}
