<?php

use App\Models\Voucher;

test('validation_required_fields', function () {
    $response = $this->postJson('/api/generate', []);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'name',
            'id',
            'flightNumber',
            'date',
            'aircraft',
        ]);
});

test('check_existing_voucher', function () {
    Voucher::create([
        'crew_name' => 'Sarah',
        'crew_id' => '98123',
        'flight_number' => 'GA102',
        'flight_date' => '2025-07-12',
        'aircraft_type' => 'ATR',
        'seat1' => '1A',
        'seat2' => '2C',
        'seat3' => '3D',
    ]);

    $response = $this->postJson('/api/check', [
        'flightNumber' => 'GA102',
        'date' => '2025-07-12',
    ]);

    $response->assertJson([
        'exists' => true,
    ]);
});

test('can_generate_voucher', function () {
    $response = $this->postJson('/api/generate', [
        'name' => 'Sarah',
        'id' => '98123',
        'flightNumber' => 'GA102',
        'date' => '2025-07-12',
        'aircraft' => 'Airbus 320',
    ]);

    $response
        ->assertStatus(201)
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonCount(3, 'seats');

    $this->assertDatabaseHas('vouchers', [
        'flight_number' => 'GA102',
        'flight_date' => '2025-07-12',
    ]);
});

test('cannot_generate_duplicate_voucher', function () {
    Voucher::create([
        'crew_name' => 'Sarah',
        'crew_id' => '98123',
        'flight_number' => 'GA102',
        'flight_date' => '2025-07-12',
        'aircraft_type' => 'Airbus 320',
        'seat1' => '1A',
        'seat2' => '2A',
        'seat3' => '3A',
    ]);

    $response = $this->postJson('/api/generate', [
        'name' => 'John',
        'id' => '12345',
        'flightNumber' => 'GA102',
        'date' => '2025-07-12',
        'aircraft' => 'Airbus 320',
    ]);

    $response
        ->assertStatus(409);
});

test('atr_generates_valid_seats', function () {
    $response = $this->postJson('/api/generate', [
        'name' => 'Sarah',
        'id' => '98123',
        'flightNumber' => 'GA200',
        'date' => '2025-07-12',
        'aircraft' => 'ATR',
    ]);

    $seats = $response->json('seats');

    foreach ($seats as $seat) {
        $this->assertMatchesRegularExpression(
            '/^(?:[1-9]|1[0-8])[ACDF]$/',
            $seat
        );
    }
});