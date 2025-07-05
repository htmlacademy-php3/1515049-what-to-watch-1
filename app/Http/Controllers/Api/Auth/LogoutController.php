<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request): ErrorResponse|SuccessResponse
    {
        $user = Auth::user();

        if (!$user) {
            return new ErrorResponse(null, 'Unauthenticated', 401);
        }

        $user->tokens()->delete();

        return new SuccessResponse(null, 204);
    }
}
