<?php

namespace App\Http\Controllers\Results;

use App\Http\Controllers\Controller;
use App\Http\Resources\Claims\ClaimResource;
use App\Http\Resources\Clients\ClientResource;
use App\Http\Resources\Payments\PaymentResource;
use App\Http\Resources\Results\ResultResource;
use App\Models\Client;
use App\Models\Result;
use Illuminate\Http\JsonResponse;

class ResultDetailsController extends Controller
{
    public function __invoke($id): JsonResponse
    {

        $data = Result::query()
            ->where('id', $id)
            ->select(['id', 'client_id', 'result_date'])
            ->with([
                'resultDetails.sample',
                'resultDetails.result',
                'resultDetails.sampleDetail',
            ])
            ->first();
        return response()->json([
            'success' => true,
            'data' => new ResultResource($data),
        ]);
    }
}
