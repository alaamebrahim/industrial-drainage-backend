<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AppInfoController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [

            ],
        ]);
    }
}
