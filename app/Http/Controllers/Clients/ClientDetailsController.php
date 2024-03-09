<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Claims\ClaimResource;
use App\Http\Resources\Clients\ClientResource;
use App\Http\Resources\Payments\PaymentResource;
use App\Http\Resources\Results\ResultResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientDetailsController extends Controller
{
    public function __invoke($id): JsonResponse
    {
        $data = Client::query()
            ->where('id', $id)
            ->first();
        return response()->json([
            'success' => true,
            'data' => new ClientResource($data),
            'claims' => (ClaimResource::collection($data->claims->load(['client', 'payments', 'details'])))->resource,
            'results' => (ResultResource::collection($data->results->load(['client', 'resultDetails.sample', 'resultDetails.result', 'resultDetails.sampleDetail'])))->resource,
            'payments' => (PaymentResource::collection($data->payments->load(['claim.client', 'claim.payments'])))->resource
        ]);
    }
}
