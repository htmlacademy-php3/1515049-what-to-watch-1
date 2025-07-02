<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Log;

class LogoutController extends Controller
{
    public function logout(Request $request) : ErrorResponse|SuccessResponse
    {
        Auth::user()->tokens()->delete();

        return new SuccessResponse(null, 204);
    }
}
