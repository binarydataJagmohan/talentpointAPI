<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CompanyFollower;
use App\Classes\ErrorsClass;
use JWTAuth;

class CompanyFollowersController extends Controller
{
    public function getCompanyFollowersCount($company_id)
    {
        try {
            $count = CompanyFollower::where('company_id', $company_id)->count();
            return response()->json(['status' => 'success', 'count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to get company followers count']);
        }
    }

    public function getCompaniesUserFollow($user_id)
    {
        try {
            $companies = CompanyFollower::where('user_id', $user_id)
                ->orderBy('created_at', 'DESC')
                ->get();
            
            return response()->json(['status' => 'success', 'companies' => $companies]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to get companies followed by user']);
        }
    }

    public function createCompanyFollower(Request $request)
    {
        try {
            $company_follower = new CompanyFollower;
            $company_follower->user_id = $request->user_id;
            $company_follower->company_id = $request->company_id;
            $company_follower->status = $request->status;
            $company_follower->save();
            return response()->json(['status' => 'success', 'message' => 'Company follower added successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to add company follower']);
        }
    }

    public function updateCompanyFollower(Request $request)
    {
        try {
            $company_follower = CompanyFollower::find($request->id);
            
            if (!$company_follower) {
                return response()->json(['status' => 'error', 'message' => 'Company follower not found']);
            }
            
            $company_follower->user_id = $request->user_id;
            $company_follower->company_id = $request->company_id;
            $company_follower->status = $request->status;
            $company_follower->save();
            
            return response()->json(['status' => 'success', 'message' => 'Company follower updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to update company follower']);
        }
    }
    
    public function deleteCompanyFollower(Request $request)
    {
        try {
            $company_follower = CompanyFollower::find($request->id);
            
            if (!$company_follower) {
                return response()->json(['status' => 'error', 'message' => 'Company follower not found']);
            }
            
            $company_follower->delete();
            
            return response()->json(['status' => 'success', 'message' => 'Company follower deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to delete company follower']);
        }
    }
}