<?php

namespace App\Http\Controllers\Claims;

use App\DataProcessors\Claims\ClaimDataProcess2;
use App\Http\Controllers\Controller;
use App\Http\Requests\Claims\StoreClaimRequest;
use App\Http\Resources\Claims\ClaimResource;
use App\Models\Claim;
use App\Models\ClaimDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = Claim::query()
            ->when($request->filled('is_active'), fn($query) => $query->whereHas('client', fn($query) => $query->where('is_active', $request->boolean('is_active'))))
            ->when($request->filled('end_date_from'), fn($query) => $query->whereDate('end_date', '>=', $request->date('end_date_from')))
            ->when($request->filled('end_date_to'), fn($query) => $query->whereDate('end_date', '<=', $request->date('end_date_to')))
            ->when($request->filled('search'), fn($query) => $query->whereHas('client', fn($query) => $query->whereLike(['name', 'address'], $request->string('search'))))
            ->with([
                'client',
                'details',
            ])
            ->orderBy('id', 'desc');
        return response()->json([
            'success' => true,
            'stats' => [
                'count' => $data->count(),
                'total_amount' => number_format($totalAmount = $data->sum('total_amount'), 2),
                'amount_paid' => number_format($amountPaid = $data->sum('amount_paid'), 2),
                'net_amount' => number_format($totalAmount - $amountPaid, 2)
            ],
            'data' => ClaimResource::collection($data->paginate(25))->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = Claim::query()
            ->with([
                'client',
                'details',
            ])
            ->where('id', $id)
            ->first();
        return response()->json([
            'success' => true,
            'data' => new ClaimResource($data),
        ]);
    }

    public function store(StoreClaimRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $claim = Claim::query()->create($request->validated());

            ClaimDataProcess2::calculate($claim);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            errorLog($exception);
            return response()->json([
                'success' => false,
                'message' => 'لم يتم الحفظ'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم الحفظ بنجاح'
        ]);
    }

    public function destroy($id)
    {

        try {
            DB::beginTransaction();

            ClaimDetail::query()->where('claim_id', $id)->delete();

            Claim::query()->where('id', $id)->delete();

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            errorLog($exception);
            return response()->json([
                'success' => false,
                'message' => 'لم يتم الحفظ'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم الحذف بنجاح'
        ]);
    }
}
