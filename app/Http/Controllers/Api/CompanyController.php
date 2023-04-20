<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Paginate;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get all companies
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCompany()
    {
        try {
            $companies = Company::where('status', 'active')->orderBy('id', 'DESC')->paginate(10);
            return response()->json(['status' => 'success', 'data' => $companies]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get a single company by ID
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSingleCompany($id)
    {
        try {
            $company = Company::where('id', $id)->where('status', 'active')->first();
            if (!$company) {
                return response()->json(['status' => 'error', 'message' => 'Company not found']);
            }
            return response()->json(['status' => 'success', 'data' => $company]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Create a new company.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCompany(Request $request)
    {
        try {
            $company = new Company();
            $company->user_id = $request->user_id;
            $company->company_name = $request->company_name;
            $company->designation = $request->designation;
            $company->company_website = $request->company_website;
            $company->company_location = $request->company_location;
            $company->company_sector = $request->company_sector;
            $company->no_of_employees = $request->no_of_employees;
            $company->company_description = $request->company_description;
            $company->company_logo = $request->company_logo;
            $company->company_contact_no = $request->company_contact_no;
            $company->available_resume_count = $request->available_resume_count;
            $company->status = $request->status;
            $company->save();
            return response()->json(['message' => 'Company created successfully', 'data' => $company], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to create company', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing company.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCompany(Request $request, $id)
    {
        try {
            $company = Company::where('id', $id)->first();
            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }
            $company->company_name = $request->edit_company_name;
            $company->designation = $request->edit_designation;
            $company->company_website = $request->edit_company_website;
            $company->company_location = $request->edit_company_location;
            $company->company_sector = $request->edit_company_sector;
            $company->no_of_employees = $request->edit_no_of_employees;
            $company->company_description = $request->edit_company_description;
            $company->company_logo = $request->edit_company_logo;
            $company->company_contact_no = $request->edit_company_contact_no;
            $company->available_resume_count = $request->edit_available_resume_count;
            $company->status = $request->status;
            $company->save();

            return response()->json(['message' => 'Company updated successfully', 'data' => $company], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to update company', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateCompanyResumeCount(Request $request, $company_id, $value) {
        try {
            $company = Company::findOrFail($company_id);
            $company->available_resume_count += $value;
            $company->save();
    
            $message = "Company resume count updated successfully";
            return response()->json(['status' => 'success', 'message' => $message], 200);
        } catch (\Exception $e) {
            $message = "Failed to update company resume count";
            return response()->json(['status' => 'error', 'message' => $message], 500);
        }
    }
    
    /**
     * Delete an existing company.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function deleteCompany($id)
    {
        try {
            $company = Company::where('id', $id)->where('status', 'active')->first();

            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }

            $company->delete();

            return response()->json(['message' => 'Company deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to delete company', 'error' => $e->getMessage()], 500);
        }
    }

}
