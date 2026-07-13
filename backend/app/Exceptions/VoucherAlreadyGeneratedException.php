<?php

namespace App\Exceptions;

use Exception;

class VoucherAlreadyGeneratedException extends Exception
{
    public function render()
    {
        return response()->json([
            "exists" => true,
            'message' => $this->getMessage()
        ], 409);
    }
}
