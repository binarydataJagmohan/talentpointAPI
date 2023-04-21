<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Membership;
use App\Classes\ErrorsClass;
use JWTAuth;

class MembershipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
}