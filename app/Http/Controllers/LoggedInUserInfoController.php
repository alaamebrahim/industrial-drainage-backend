<?php

namespace App\Http\Controllers;


class LoggedInUserInfoController
{
    public function __invoke(): ?\Illuminate\Http\JsonResponse
    {
        if (! auth()->check()) {
            abort(403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'userName' => userName(),
            ],
        ]);
    }
}
