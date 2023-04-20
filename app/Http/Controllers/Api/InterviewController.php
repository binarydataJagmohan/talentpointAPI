<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Classes\ErrorsClass;
use JWTAuth;

class InterviewController extends Controller
{
    public function getAllInterviews()
    {
        try {
            $interviews = Interview::orderByDesc('created_at')->get();
            return response()->json([
                'status' => true,
                'message' => 'All interviews fetched successfully',
                'data' => $interviews,
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    public function getUserInterviews($userId)
    {
        try {
            $interviews = Interview::where('applicant_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $interviews,
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    public function getUserFutureInterviews($userId)
    {
        try {
            $now = Carbon::now();
            $interviews = Interview::where('applicant_id', $userId)
                ->where('interview_schedule_date', '>', $now->format('Y-m-d'))
                ->orWhere(function ($query) use ($now) {
                    $query->where('interview_schedule_date', '=', $now->format('Y-m-d'))
                        ->where('interview_schedule_time', '>=', $now->format('H:i:s'));
                })
                ->orderBy('interview_schedule_date', 'asc')
                ->orderBy('interview_schedule_time', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $interviews,
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getCompanyInterviews($companyId)
    {
        try {
            $interviews = Interview::where('company_id', $companyId)->orderByDesc('created_at')->get();
            return response()->json([
                'status' => 'success',
                'interviews' => $interviews
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getCompanyUserfutureInterviews($companyId)
    {
        try {
            $interviews = Interview::where('company_id', $companyId)
                ->where('interview_schedule_date', '>', Carbon::now()->format('Y-m-d'))
                ->orderBy('interview_schedule_date', 'asc')
                ->orderBy('interview_schedule_time', 'asc')
                ->get();
            return response()->json([
                'status' => 'success',
                'interviews' => $interviews
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function insertInterview(Request $request)
    {
        try {
            $interview = new Interview();
            $interview->job_id = $request->input('job_id');
            $interview->company_id = $request->input('company_id');
            $interview->applicant_id = $request->input('applicant_id');
            $interview->meeting_link = $request->input('meeting_link');
            $interview->interview_schedule_date = $request->input('interview_schedule_date');
            $interview->interview_schedule_time = $request->input('interview_schedule_time');
            $interview->interview_status = $request->input('interview_status', 'scheduled');
            $interview->save();

            return response()->json([
                'status' => true,
                'message' => 'Interview created successfully',
                'data' => $interview,
            ], 201);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateInterview(Request $request, $interview_id)
    {
        try {
            $interview = Interview::findOrFail($interview_id);
            $interview = new Interview();
            $interview->job_id = $request->input('edit_job_id');
            $interview->company_id = $request->input('edit_company_id');
            $interview->applicant_id = $request->input('edit_applicant_id');
            $interview->meeting_link = $request->input('edit_meeting_link');
            $interview->interview_schedule_date = $request->input('edit_interview_schedule_date');
            $interview->interview_schedule_time = $request->input('edit_interview_schedule_time');
            $interview->interview_status = $request->input('edit_interview_status', 'scheduled');
            $interview->save();

            return response()->json([
                'status' => true,
                'message' => 'Interview updated successfully',
                'data' => $interview,
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function deleteInterview($interview_id)
    {
        try {
            $interview = Interview::findOrFail($interview_id);
            $interview->delete();
            return response()->json([
                'status' => true,
                'message' => 'Interview deleted successfully',
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

}