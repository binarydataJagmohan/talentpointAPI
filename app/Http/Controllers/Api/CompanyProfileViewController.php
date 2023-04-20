<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CompanyProfileView;
use App\Classes\ErrorsClass;
use JWTAuth;

class CompanyProfileViewController extends Controller
{
    public function getCompanyViewCountByDays($company_id, $days) {
        try {
            $count = CompanyProfileView::where('company_id', $company_id)
                ->where('created_at', '>=', Carbon::now()->subDays($days))
                ->count();
            return response()->json(['status' => 'success', 'count' => $count]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
    public function getCompanyViewListByDays($company_id, $days) {
        try {
            $views = CompanyProfileView::where('company_id', $company_id)
                ->where('created_at', '>=', Carbon::now()->subDays($days))
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(['status' => 'success', 'views' => $views]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
    public function getCompanyUserViewedByDays($user_id, $days) {
        try {
            $views = CompanyProfileView::where('user_id', $user_id)
                ->where('created_at', '>=', Carbon::now()->subDays($days))
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(['status' => 'success', 'views' => $views]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
    public function insertCompanyView($company_id, $user_id, $status) {
        try {
            $companyProfileView = new CompanyProfileView;
            $companyProfileView->company_id = $company_id;
            $companyProfileView->user_id = $user_id;
            $companyProfileView->status = $status;
            $companyProfileView->save();
            return response()->json(['status' => 'success', 'message' => 'Company view inserted successfully']);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
    public function updateCompanyView($companyProfileView_id, $status) {
        try {
            $companyProfileView = CompanyProfileView::find($companyProfileView_id);
            if ($companyProfileView) {
                $companyProfileView->status = $status;
                $companyProfileView->save();
                return response()->json(['status' => 'success', 'message' => 'Company view updated successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Company view not found']);
            }
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
    public function deleteCompanyView($companyProfileView_id) {
        try {
            $companyProfileView = CompanyProfileView::find($companyProfileView_id);
            if ($companyProfileView) {
                $companyProfileView->delete();
                return response()->json(['status' => 'success', 'message' => 'Company view deleted successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Company view not found']);
            }
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
}