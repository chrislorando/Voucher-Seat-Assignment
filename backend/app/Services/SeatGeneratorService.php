<?php

namespace App\Services;

use App\Exceptions\VoucherAlreadyGeneratedException;
use App\Models\Voucher;
use InvalidArgumentException;

class SeatGeneratorService
{
    public function generate(array $data): Voucher
    {    
        return \DB::transaction(function () use ($data) {

            $seats = $this->generateSeats($data['aircraft']);

            try {
                return Voucher::create([
                    'crew_name' => $data['name'],
                    'crew_id' => $data['id'],
                    'flight_number' => $data['flightNumber'],
                    'flight_date' => $data['date'],
                    'aircraft_type' => $data['aircraft'],
                    'seat1' => $seats[0],
                    'seat2' => $seats[1],
                    'seat3' => $seats[2],
                ]);
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                throw new VoucherAlreadyGeneratedException(
                    'Voucher already generated for this flight and date.'
                );
            }
        });
    }

    private function generateSeats(string $aircraft): array
    {
        $seatMap = match ($aircraft) {
            'ATR' =>
                $this->createSeatMap(
                    18,
                    ['A', 'C', 'D', 'F']
                ),

            'Airbus 320',
            'Boeing 737 Max' =>
                $this->createSeatMap(
                    32,
                    ['A', 'B', 'C', 'D', 'E', 'F']
                ),

            default =>
                throw new InvalidArgumentException(
                    'Invalid aircraft type.'
                )
        };


        shuffle($seatMap);
        return array_slice($seatMap, 0, 3);
    }

    private function createSeatMap(int $rows, array $letters): array
    {
        $seats = [];

        for ($row = 1; $row <= $rows; $row++) {
            foreach ($letters as $letter) {
                $seats[] = $row . $letter;
            }
        }

        return $seats;
    }
}