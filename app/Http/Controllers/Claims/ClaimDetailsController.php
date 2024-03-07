<?php

namespace App\Http\Controllers\Claims;

use App\Http\Controllers\Controller;
use App\Http\Resources\Claims\ClaimResource;
use App\Http\Resources\Results\ResultResource;
use App\Models\Claim;
use App\Models\Result;
use Illuminate\Http\JsonResponse;

class ClaimDetailsController extends Controller
{
    public function __invoke($id): JsonResponse
    {

        $data = Claim::query()
            ->with([
                'client',
                'result',
                'details',
            ])
            ->where('id', $id)
            ->first();
        return response()->json([
            'success' => true,
            'data' => new ClaimResource($data),
        ]);
    }
}
