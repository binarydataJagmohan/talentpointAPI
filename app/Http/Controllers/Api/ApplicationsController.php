<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Applications;
use App\Classes\ErrorsClass;
use JWTAuth;

class ApplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAllApplications()
    {
        try {
            $applications = Applications::where('status', 'active')->orderBy('id', 'DESC')->paginate(10);
            return response()->json([
                'message' => 'Applications retrieved successfully.',
                'status' => true,
                'data' => $applications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while retrieving applications.',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getSingleApplication($id)
    {
        try {
            $applications = Applications::where('id', $id)->where('status', 'active')->first();
            return response()->json([
                'message' => 'Applications retrieved successfully.',
                'status' => true,
                'data' => $applications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while retrieving applications.',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function createApplication(Request $request)
    {
        try {
            $applications = new Applications;
            $applications->company_id = $request->input('company_id');
            $applications->job_id = $request->input('job_id');
            $applications->applicant_id = $request->input('applicant_id');
            $applications->resume_path = $request->input('resume_path');
            $applications->apply_status = $request->input('apply_status');
            $applications->status = $request->input('status');
            $applications->save();
            return response()->json([
                'message' => 'Applications created successfully.',
                'status' => true,
                'data' => $applications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while creating applications.',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateApplication(Request $request, $id)
    {
        try {
            $applications = Applications::where('id', $id)->where('status', 'active')->first();
            $applications->company_id = $request->input('edit_company_id');
            $applications->job_id = $request->input('edit_job_id');
            $applications->resume_path = $request->input('resume_path');
            $applications->apply_status = $request->input('apply_status');
            $applications->save();
            return response()->json([
                'message' => 'Applications updated successfully.',
                'status' => true,
                'data' => $applications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while updating applications.',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getApplicationByCompanyId($company_id)
    {
        try {
            $applications = Applications::where('company_id', $company_id)->where('status', 'active')->get();
            return response()->json([
                'message' => 'Applications retrieved successfully.',
                'status' => true,
                'data' => $applications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while retrieving applications.',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getApplicationByStatus(Request $request, $status)
    {
        try {
            $applications = Applications::where('status', $status)->get();
            return response()->json([
                'status' => true,
                'data' => $applications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getApplicationByCompanyIdWithStatus(Request $request, $company_id, $status)
    {
        try {
            $applications = Applications::where('company_id', $company_id)
                ->where('status', $status)
                ->get();
            return response()->json([
                'status' => true,
                'data' => $applications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteApplication(Request $request, $id)
    {
        try {
            $applications = Applications::where('id', $id)->where('status', 'active')->first();;
            if (!$applications) {
                return response()->json(['status' => false, 'message' => 'Applications not found'], 404);
            }
            $application->delete();
            return response()->json(['status' => true, 'message' => 'Applications deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Unable to delete applications'], 500);
        }
    }

}