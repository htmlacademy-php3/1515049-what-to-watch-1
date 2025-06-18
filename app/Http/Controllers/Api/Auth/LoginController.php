<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request) : SuccessResponse
    {
        return $this->success([]);
    }
}
