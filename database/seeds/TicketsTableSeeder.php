<?php

use App\Ticket;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < random_int(3, 10); $i++) {
            factory(Ticket::class)->create([
                'created_at' => now()->subMinutes(random_int(0, 420)),
            ]);
        }
    }
}
