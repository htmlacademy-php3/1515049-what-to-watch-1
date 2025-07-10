<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    public function logout(Request $request): ErrorResponse|Response
    {
        $user = Auth::user();

        if (!$user) {
            return new ErrorResponse(null, 'Unauthenticated', 401);
        }

        $user->tokens()->delete();

        return response()->noContent();
    }
}
