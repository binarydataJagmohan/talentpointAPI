<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\WorkExperience;
use App\Classes\ErrorsClass;
use JWTAuth;

class WorkExperienceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function getWorkExperience()
    {
        try{
            $workexperience = WorkExperience::all();
            if($workexperience){
                return response()->json(['status'=>true,'message'=>'Work Experience details','error'=>'','data'=>$workexperience], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Work Experience details not found','error'=>'','data'=>''], 400);
            }
        } catch(\Illuminate\Database\QueryException $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
        } catch(\Exception $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
        }
    }

    public function getSingleWorkExperience(Request $request, $id)
    {
        try{
            $workexperience = WorkExperience::find($id);
            if($workexperience){
                return response()->json(['status'=>true,'message'=>'Work Experience details','error'=>'','data'=>$workexperience], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Work Experience details not found','error'=>'','data'=>''], 400);
            }
        } catch(\Illuminate\Database\QueryException $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
        } catch(\Exception $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
        }
    }

    public function createWorkExperience(Request $request)
    {
        try{
            $workexperience = WorkExperience::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'company' => $request->company,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'currently_work_here' => $request->currently_work_here,
                'description' => $request->description,
                'status' => 'pending'
            ]);
            if($workexperience){
                return response()->json(['status'=>true,'message'=>'Work Experience created Successfully!','error'=>'','data'=>''], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Work Experience not created Successfully!','error'=>'','data'=>''], 400);
            }
        } catch(\Illuminate\Database\QueryException $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
        } catch(\Exception $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $workexperience = WorkExperience::find($id);
            $workexperience->title = $request->edit_title;
            $workexperience->company = $request->edit_company;
            $workexperience->start_date = $request->edit_start_date;
            $workexperience->end_date = $request->edit_end_date;
            $workexperience->currently_work_here = $request->edit_currently_work_here;
            $workexperience->description = $request->edit_description;
            $updateworkexperience = $workexperience->save();
            if($updateworkexperience){
                return response()->json(['status'=>true,'message'=>'Work Experience updated Successfully!','error'=>'','data'=>''], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Work Experience not updated Successfully!','error'=>'','data'=>''], 400);
            }
        } catch(\Illuminate\Database\QueryException $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
        } catch(\Exception $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
        }
    }

    public function destroy($id)
    {
        try{
            $workexperience = WorkExperience::where('id', $id)->update(['status'=>'deleted']);
            if($workexperience){
                return response()->json(['status'=>true,'message'=>'Work Experience deleted Successfully!','error'=>'','data'=>''], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Work Experience not deleted Successfully!','error'=>'','data'=>''], 400);
            }
        } catch(\Illuminate\Database\QueryException $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
        } catch(\Exception $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
        }
    }
}
