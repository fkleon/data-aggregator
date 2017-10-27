<?php

use Illuminate\Database\Seeder;

class CollectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Dsc\Collector::class, 25)->create();
    }
}
