<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $user = Auth::user();
dd($user);
        $user->tokens()->delete();

        return response()->json(['success' => true]);

    }
}
