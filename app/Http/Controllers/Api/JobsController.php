<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Jobs;
use App\Classes\ErrorsClass;
use JWTAuth;

class JobsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAllJobs()
    {
        try {
            $jobs = Jobs::where('job_status', '!=', 'deleted')
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'All jobs retrieved successfully',
                'data' => $jobs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error retrieving all jobs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSingleJob($id)
    {
        try {
            $jobs = Jobs::findOrFail($id);

            return response()->json([
                'status' => 200,
                'message' => 'Jobs retrieved successfully',
                'data' => $jobs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Job not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function getSortByJobs($option)
    {
        try {
            if($option){
                $jobs = Job::where('job_status', '=', $option)
                    ->orderByDesc('id')
                    ->get();
            } else {
                $jobs = Job::where('job_status', '!=', 'deleted')
                    ->orderByDesc('id')
                    ->get();
            }
            return response()->json([
                'status' => 200,
                'message' => 'Jobs retrieved successfully',
                'data' => $jobs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error retrieving jobs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    function createJob(Request $request)
    {
        try {
            $jobs = new Jobs;
            $jobs->user_id = $request->user_id;
            $jobs->company_id = $request->company_id;
            $jobs->sector_id = $request->sector_id;
            $jobs->job_title = $request->job_title;
            $jobs->job_description = $request->job_description;
            $jobs->type_of_position = $request->type_of_position;
            $jobs->job_country = $request->job_country;
            $jobs->industry = $request->industry;
            $jobs->experience = $request->experience;
            $jobs->skills_required = $request->skills_required;
            $jobs->monthly_fixed_salary_currency = $request->monthly_fixed_salary_currency;
            $jobs->monthly_fixed_salary_min = $request->monthly_fixed_salary_min;
            $jobs->monthly_fixed_salary_max = $request->monthly_fixed_salary_max;
            $jobs->available_vacancies = $request->available_vacancies;
            $jobs->deadline = $request->deadline;
            $jobs->is_featured = $request->is_featured;
            $jobs->job_type = $request->job_type;
            $jobs->job_status = $request->job_status;
            $jobs->save();

            return response()->json(['message' => 'Jobs created successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create jobs', 'status' => 400]);
        }
    }

    function updateJob(Request $request, $id)
    {
        try {
            $jobs = Jobs::find($id);
            $jobs->user_id = $request->user_id;
            $jobs->company_id = $request->company_id;
            $jobs->sector_id = $request->sector_id;
            $jobs->job_title = $request->job_title;
            $jobs->job_description = $request->job_description;
            $jobs->type_of_position = $request->type_of_position;
            $jobs->job_country = $request->job_country;
            $jobs->industry = $request->industry;
            $jobs->experience = $request->experience;
            $jobs->skills_required = $request->skills_required;
            $jobs->monthly_fixed_salary_currency = $request->monthly_fixed_salary_currency;
            $jobs->monthly_fixed_salary_min = $request->monthly_fixed_salary_min;
            $jobs->monthly_fixed_salary_max = $request->monthly_fixed_salary_max;
            $jobs->available_vacancies = $request->available_vacancies;
            $jobs->deadline = $request->deadline;
            $jobs->is_featured = $request->is_featured;
            $jobs->job_type = $request->job_type;
            $jobs->job_status = $request->job_status;
            $jobs->save();

            return response()->json(['message' => 'Jobs updated successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update jobs', 'status' => 400]);
        }
    }

    function deleteJob($id)
    {
        try {
            $jobs = Jobs::find($id);
            $jobs->delete();

            return response()->json(['message' => 'Jobs deleted successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete jobs', 'status' => 400]);
        }
    }
}