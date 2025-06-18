<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request) : SuccessResponse
    {
        return $this->success([]);
    }
}
