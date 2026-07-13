<?php

namespace App\Http\Controllers;

use App\Exceptions\VoucherAlreadyGeneratedException;
use App\Http\Requests\CheckVoucherRequest;
use App\Http\Requests\GenerateVoucherRequest;
use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use App\Services\SeatGeneratorService;

class VoucherController extends Controller
{
    public function check(CheckVoucherRequest $request)
    {
        $data = $request->validated();

        $exists = Voucher::where('flight_number', $data['flightNumber'])
            ->where('flight_date', $data['date'])
            ->exists();

        if ($exists) {
            throw new VoucherAlreadyGeneratedException(
                'Voucher already generated for this flight and date.'
            );
        }

        return response()->json([
            'exists' => false,
            'message' => 'No voucher found for this flight and date.',
        ]);
    }

    public function generate(GenerateVoucherRequest $request, SeatGeneratorService $service)
    {
        $seats = $service->generate($request->validated());

        return new VoucherResource($seats);
    }
}
