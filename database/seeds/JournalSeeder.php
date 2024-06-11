<?php

namespace Database\Seeders;

use App\Client;
use App\Journal;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();

        factory(Journal::class, 500)->create([
            'client_id' => function () use ($clients) {
                return $clients->random()->id;
            },
        ]);
    }
}
