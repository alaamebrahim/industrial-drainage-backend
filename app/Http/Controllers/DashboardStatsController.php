<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardStatsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'clients' => Client::query()->count(),
                'claims' => Claim::query()->count(),
                'results' => Result::query()->count(),
                'total_amount' => number_format($totalAmount = Claim::query()->sum('total_amount'), 2),
                'amount_paid' =>  number_format($amountPaid = Payment::query()->sum('amount'), 2),
                'net_amount' => number_format($totalAmount - $amountPaid, 2),
            ],
        ]);
    }
}
