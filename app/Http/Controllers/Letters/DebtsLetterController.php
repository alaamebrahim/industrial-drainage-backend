<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Letters\DebtsLetterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class DebtsLetterController extends Controller
{
    public function __invoke(DebtsLetterRequest $request): JsonResponse
    {

        $savedFile = '/letters/generated/'.'_'.Str::replace([' ', ':', '/'], '-', $request->get('letter')).'.docx';

        try {
            $file = public_path('letters/debts.docx');

            $phpword = new TemplateProcessor($file);

            $phpword->setValue('letter', $request->get('letter'));

            $phpword->setValue('date', $request->get('date'));

            $phpword->setValue('amount', $request->get('amount'));

            $phpword->setValue('amountString', $request->get('amountString'));

            $phpword->saveAs(public_path($savedFile));

        } catch (\Throwable $throwable) {
            errorLog($throwable);

            return response()->json(['success' => false, 'message' => $throwable->getMessage()]);
        }

        return response()->json(['success' => true, 'data' => URL::to($savedFile)]);
    }
}
