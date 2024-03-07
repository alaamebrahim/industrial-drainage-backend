<?php

namespace App\DataProcessors\Claims;

use App\Http\Controllers\Controller;
use App\Http\Resources\Results\ResultResource;
use App\Models\Claim;
use Illuminate\View\View;

class
PrintClaimController extends Controller
{
    public function __invoke(int $claimId): View
    {
        $claim = Claim::query()->findOrFail($claimId);

        return view('reports.claims.print', [
            'data' => $claim->load(['details']),
            'result' => $claim->result->load(['resultDetails.sample', 'resultDetails.sampleDetail']),
            'client' => $claim->client
        ]);
    }
}
