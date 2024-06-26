<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\StorePaymentRequest;
use App\Http\Resources\Payments\PaymentResource;
use App\Models\Claim;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = Payment::query()
            ->when($request->filled('is_active'), fn($query) => $query->whereHas('claim.client', fn($query) => $query->where('is_active', $request->boolean('is_active'))))
            ->when($request->filled('payment_date_from'), fn($query) => $query->whereDate('payment_date', '>=', $request->date('payment_date_from')))
            ->when($request->filled('payment_date_to'), fn($query) => $query->whereDate('payment_date', '<=', $request->date('payment_date_to')))
            ->when($request->filled('search'), fn($query) => $query->whereHas('claim.client', fn($query) => $query->whereLike(['name', 'address'], $request->string('search'))))

            ->with([
                'claim',
                'claim.client'
            ])
            ->orderBy('id', 'desc')
            ->paginate(25);
        return response()->json([
            'success' => true,
            'data' => PaymentResource::collection($data)->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = Payment::query()
            ->with([
                'claim',
                'claim.client'
            ])
            ->where('id', $id)
            ->first();
        return response()->json([
            'success' => true,
            'data' => new PaymentResource($data),
        ]);
    }

    public function store(StorePaymentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $payment = Payment::query()->create($request->validated());

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

    public function destroy($id): JsonResponse
    {

        try {
            DB::beginTransaction();

            Payment::query()->where('id', $id)->delete();

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
