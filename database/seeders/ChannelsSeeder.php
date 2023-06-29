<?php

namespace Database\Seeders;

use App\Models\Post\Channel;
use Illuminate\Database\Seeder;

class ChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Channel::factory()->count(5)->create();
    }
}
