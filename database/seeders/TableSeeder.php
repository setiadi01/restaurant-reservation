<?php

namespace Database\Seeders;

use App\Domain\Reservation\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Table::factory()->create([
                'number' => $i,
            ]);
        }
    }
}
