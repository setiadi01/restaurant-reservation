<?php

use App\Domain\Restaurant\Models\BusinessHour;
use Illuminate\Support\Facades\Artisan;

test('form online reservation can be rendered', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('can make online reservation', function () {
    Artisan::call('db:seed');
    $businessHour = BusinessHour::where('day_of_week', now()->dayOfWeek)->first();
    $response = $this->post('/online-reservations', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '1234567',
        'date' => now()->format('Y-m-d'),
        'time' => date('H:i', strtotime($businessHour->closing_time)),
        'special_request' => 'lorem ipsum',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');
});
