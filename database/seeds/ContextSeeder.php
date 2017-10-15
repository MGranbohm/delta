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
        Context::create([
            'context' => '{"conversation_id":"db326a5e-10a6-4c0d-b215-90d6264693c6","system":{"dialog_stack":[{"dialog_node":"node_1_1507672166718"}],"dialog_turn_counter":9,"dialog_request_counter":9,"_node_output_map":{"Welcome":[0],"node_2_1507672219352":[3,2,0,3,5,4,1],"node_1_150
8015181639":[0],"node_1_1508070933198":[0]}}}',
            'intent' => '{"intent":"hello","confidence":1}',
            'entity' => '[]'
        ]);
    }
}
