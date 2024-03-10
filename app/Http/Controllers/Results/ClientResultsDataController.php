<?php

namespace App\Http\Controllers\Results;

use App\DataProcessors\Claims\ClaimDataProcess;
use App\Http\Controllers\Controller;
use App\Http\Resources\Clients\ClientResource;
use App\Http\Resources\Results\ResultDetailResource;
use App\Http\Resources\Results\ResultResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientResultsDataController extends Controller
{
    public function __invoke($id): JsonResponse
    {
        $data = Client::query()
            ->where('id', $id)
            ->first();

        $resultDetails = ClaimDataProcess::prepareResultDetails(
            resultId: null,
            clientId: $id,
            endDate: now()->format('Y-m-d')
        );


        return response()->json([
            'success' => true,
            'data' => new ClientResource($data),
            'results' => ResultResource::collection($data->results->load(['client', 'resultDetails.sample', 'resultDetails.result', 'resultDetails.sampleDetail'])),
            'resultDetails' => ResultDetailResource::collection($resultDetails)
        ]);
    }
}
