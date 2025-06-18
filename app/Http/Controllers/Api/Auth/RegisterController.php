<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) : SuccessResponse
    {
        return $this->success([]);
    }
}
