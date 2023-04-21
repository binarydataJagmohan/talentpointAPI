<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Languages;
use App\Classes\ErrorsClass;
use JWTAuth;

class LanguagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    function getAllLanguages($user_id)
    {
        try {
            $languages = Languages::where('user_id', $user_id)->where('status', 'active')->orderBy('id', 'desc')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'All languages retrieved successfully!',
                'data' => $languages
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    function getSingleLanguages($id)
    {
        try {
            $languages = Languages::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Languages retrieved successfully!',
                'data' => $language
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    function addLanguages(Request $request)
    {
        try {
            $languages = new Languages;
            $languages->user_id = $request->user_id;
            $languages->language = $request->language;
            $languages->proficiency = $request->proficiency;
            $languages->status = 'active';
            $languages->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Languages added successfully!',
                'data' => $languages
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    function updateLanguages(Request $request, $id)
    {
        try {
            $languages = Languages::findOrFail($id);
            $languages->language = $request->language;
            $languages->proficiency = $request->proficiency;
            $languages->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Languages updated successfully!',
                'data' => $language
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}