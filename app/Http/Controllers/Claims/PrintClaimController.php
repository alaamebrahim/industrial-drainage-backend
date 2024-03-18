<?php

namespace App\Http\Controllers\Claims;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Result;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class PrintClaimController extends Controller
{
    public function __invoke(int $claimId): View
    {

        $claim = Claim::query()->with(['details'])->findOrFail($claimId);

        $details = [];

        $claim->details->groupBy('key')->each(function ($item, $name) use (&$details) {
            $details[] = (object) [
                'name' => $name,
                'value' => $item->sum('value'),
            ];
        });

        return view('reports.claims.print', [
            'data' => $claim->load(['details']),
            'results' => Result::query()
                ->with(['resultDetails.sample', 'resultDetails.result', 'resultDetails.sampleDetail'])
                ->whereHas('resultDetails', function (Builder $builder) use ($claim) {
                    $builder->whereIn('result_details.id', $claim->details()?->pluck('result_detail_id'));
                })
                ->orderBy('id', 'asc')
                ->get(),
            'client' => $claim->client,
            'details' => $details,
        ]);
    }
}
