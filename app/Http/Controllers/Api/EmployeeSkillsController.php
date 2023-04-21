<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\EmployeeSkills;
use App\Classes\ErrorsClass;
use JWTAuth;

class EmployeeSkillsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAllEmployeeSkills()
    {
        try {
            $employee_skills = DB::table('employee_skills')
            ->where('status', '!=', 'deleted')
            ->orderBy('id', 'desc')
            ->get();
            return response()->json(['success' => true, 'data' => $employeeskills], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    // Route: POST /employee-skills
    function addEmployeeSkills(Request $request) {
        try {
            $user_id = $request->input('user_id');
            $skill_id = $request->input('skill_id');
            DB::table('employee_skills')->insert([
                'user_id' => $user_id,
                'skill_id' => $skill_id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Employee skill added successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error adding employee skill'
            ], 500);
        }
    }

    // Route: PUT /employee-skills/{id}
    function updateEmployeeSkills(Request $request, $id) {
        try {
            $user_id = $request->input('user_id');
            $skill_id = $request->input('skill_id');
            $status = $request->input('status');
            DB::table('employee_skills')
                ->where('id', $id)
                ->update([
                    'user_id' => $user_id,
                    'skill_id' => $skill_id,
                    'status' => $status,
                    'updated_at' => now()
                ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Employee skill updated successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating employee skill'
            ], 500);
        }
    }

    // Route: DELETE /employee-skills/{id}
    function deleteEmployeeSkills($id) {
        try {
            DB::table('employee_skills')
                ->where('id', $id)
                ->update([
                    'status' => 'deleted',
                    'updated_at' => now()
                ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Employee skill deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting employee skill'
            ], 500);
        }
    }

}