<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Classes\ErrorsClass;
use JWTAuth;

class EducationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getEducation()
    {
        try{
            $education = Education::all();
            if($education){
                return response()->json(['status'=>true,'message'=>'Education details','error'=>'','data'=>$education], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Education details not found','error'=>'','data'=>''], 400);
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

    public function getSingleEducation(Request $request, $id)
    {
        try{
            $education = Education::find($id);
            if($education){
                return response()->json(['status'=>true,'message'=>'Education details','error'=>'','data'=>$education], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Education details not found','error'=>'','data'=>''], 400);
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

    public function createEducation(Request $request)
    {
        try{
            $education = Education::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'company' => $request->company,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'currently_work_here' => $request->currently_work_here,
                'description' => $request->description,
                'status' => 'pending',
            ]);
            if($education){
                return response()->json(['status'=>true,'message'=>'Education created Successfully!','error'=>'','data'=>''], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Education not created Successfully!','error'=>'','data'=>''], 400);
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

    public function updateEducation(Request $request, $id)
    {
        try{
            $education = Education::find($id);
            $education->education_title = $request->edit_education_title;
            $education->degree = $request->edit_degree;
            $education->start_date = $request->edit_start_date;
            $education->end_date = $request->edit_end_date;
            $education->currently_study_here = $request->edit_currently_study_here;
            $education->your_score = $request->edit_your_score;
            $updateeducation = $education->save();
            if($updateeducation){
                return response()->json(['status'=>true,'message'=>'Education updated Successfully!','error'=>'','data'=>''], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Education not updated Successfully!','error'=>'','data'=>''], 400);
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

    public function deleteEducation($id)
    {
        try{
            $education = Education::where('id', $id)->update(['status'=>'deleted']);
            if($education){
                return response()->json(['status'=>true,'message'=>'Education deleted Successfully!','error'=>'','data'=>''], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Education not deleted Successfully!','error'=>'','data'=>''], 400);
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
