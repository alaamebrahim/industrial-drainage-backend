<?php

namespace App\Http\Controllers\Claims;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Result;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class
PrintClaimController extends Controller
{
    public function __invoke(int $claimId): View
    {
        $claim = Claim::query()->findOrFail($claimId);

        return view('reports.claims.print', [
            'data' => $claim->load(['details']),
            'results' => Result::query()
                ->with(['resultDetails.sample', 'resultDetails.result', 'resultDetails.sampleDetail'])
                ->whereHas('resultDetails', function (Builder $builder) use ($claim) {
                    $builder->whereIn('result_details.id', $claim->details()?->pluck('result_detail_id'));
                })
                ->orderBy('id', 'asc')
                ->get()
            ,
            'client' => $claim->client
        ]);
    }
}
