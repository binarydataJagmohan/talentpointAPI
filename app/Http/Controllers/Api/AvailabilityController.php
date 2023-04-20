<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Availability;
use App\Classes\ErrorsClass;
use JWTAuth;
use DB;
use Paginate;

class AvailabilityController extends Controller
{
    public function getAllAvailability(Request $request)
    {
        try {
            $availabilities = Availability::where('status', 'active')->orderBy('id', 'DESC')->paginate(10);

            return response()->json(['status' => 'success', 'data' => $availabilities], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error fetching availabilities: ' . $e->getMessage()], 500);
        }
    }

    public function getSingleAvailability(Request $request, $id)
    {
        try {
            $availability = Availability::where('id', $id)->where('status', 'active')->first();

            if (!$availability) {
                return response()->json(['status' => 'error', 'message' => 'Availability not found'], 404);
            }

            return response()->json(['status' => 'success', 'data' => $availability], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error fetching availability: ' . $e->getMessage()], 500);
        }
    }

    public function createAvailability(Request $request)
    {
        try {
            // Create a new availability record
            $availability = Availability::create([
                'user_id' => $request->input('user_id'),
                'interview_id' => $request->input('interview_id'),
                'availability_date' => $request->input('availability_date'),
                'availabel' => $request->input('availabel'),
                'from_time' => $request->input('from_time'),
                'to_time' => $request->input('to_time'),
                'status' => $request->input('status')
            ]);
            // Return success response with created record
            return response()->json([
                'status' => 'success',
                'message' => 'Availability record created successfully',
                'data' => $availability
            ], 201);

        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to create availability record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateAvailability(Request $request, $id)
    {
        try {
            // Find availability record by ID
            $availability = Availability::where('id', $id)->where('status', 'active')->first();

            // If record does not exist, return error response
            if (!$availability) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Availability record not found'
                ], 404);
            }
            // Update availability record
            $availability->interview_id = $request->input('edit_interview_id');
            $availability->availability_date = $request->input('edit_availability_date');
            $availability->availabel = $request->input('edit_availabel');
            $availability->from_time = $request->input('edit_from_time');
            $availability->to_time = $request->input('edit_to_time');
            $availability->status = $request->input('status');
            $availability->save();

            // Return success response with updated record
            return response()->json([
                'status' => 'success',
                'message' => 'Availability record updated successfully',
                'data' => $availability
            ], 200);

        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to update availability record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteAvailability(Request $request, $id)
    {
        try {
            $availability = Availability::where('id', $id)->where('status', 'active')->first();

            if (!$availability) {
                return response()->json(['status' => 'error', 'message' => 'Availability not found'], 404);
            }

            $availability->delete();

            return response()->json(['status' => 'success', 'message' => 'Availability deleted successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error deleting availability: ' . $e->getMessage()], 500);
        }
    }
}