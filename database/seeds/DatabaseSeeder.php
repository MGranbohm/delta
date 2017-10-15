<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContextSeeder::class);
//        $this->call(WatsonResponseSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
