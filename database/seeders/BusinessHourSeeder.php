<?php

namespace Database\Seeders;

use App\Domain\Restaurant\Models\BusinessHour;
use Illuminate\Database\Seeder;

class BusinessHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0 for Sunday until 6 for Saturday

        // Saturday, late closing
        BusinessHour::create([
            'day_of_week' => 6,
            'opening_time' => '09:00',
            'closing_time' => '23:00',
        ]);

        // Sunday, early opening
        BusinessHour::create([
            'day_of_week' => 0,
            'opening_time' => '07:00',
            'closing_time' => '21:00',
        ]);

        // weekdays, normal
        for ($i = 1; $i <= 5; $i++) {
            BusinessHour::create([
                'day_of_week' => $i,
                'opening_time' => '09:00',
                'closing_time' => '21:00',
            ]);
        }
    }
}
