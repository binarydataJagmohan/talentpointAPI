<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Skills;
use App\Classes\ErrorsClass;
use JWTAuth;

class SkillsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAllSkills()
    {
        try {
            $skills = Skill::where('status', 'active')->orderBy('id', 'desc')->get();
            return response()->json(['success' => true, 'data' => $skills], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getSingleSkills($id)
    {
        try {
            $skill = Skill::findOrFail($id);
            return response()->json(['success' => true, 'data' => $skill], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}