<?php

use App\Context;
use Illuminate\Database\Seeder;


class ContextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $api = new \App\Watson\WatsonAPI();
        $api->createDummyData("hello");
    }
}
