<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\ErrorsClass;
use JWTAuth;

class UserController extends Controller
{
    public function getJobPreferences($user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            $job_preferences = [
                'where_job_search' => $user->where_job_search,
                'job_type' => $user->job_type,
            ];
            return response()->json([
                'status' => 'success',
                'data' => $job_preferences,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateJobPreferences(Request $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            $user->where_job_search = $request->input('where_job_search');
            $user->job_type = $request->input('job_type');
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Job preferences updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUserDetails($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateEmployee(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->job_status = $request->input('job_status');
            $user->where_currently_based = $request->input('where_currently_based');
            $user->current_position = $request->input('current_position');
            $user->linked_id = $request->input('linked_id');
            $user->google_id = $request->input('google_id');
            $user->contact_no = $request->input('contact_no');
            $user->updated_at = Carbon::now();
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully'
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateProfilePercentage($user_id, $value)
    {
        try {
            $user = User::findOrFail($user_id);
            $user->profile_complete_percentage = $value;
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Profile percentage updated successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateStatus($user_id, $value)
    {
        try {
            $user = User::find($user_id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ], 404);
            }
            $user->status = $value;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'User status updated successfully',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateEmailVerified($user_id, $value)
    {
        try {
            $user = User::findOrFail($user_id);
            $user->email_verified_at = $value;
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Email verification status updated successfully.',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

}