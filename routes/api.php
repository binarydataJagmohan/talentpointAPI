<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api']], function ($router) {        
    Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
    Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
    Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');
    Route::post('/refresh', 'App\Http\Controllers\Api\AuthController@refresh');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'], 'prefix' => 'users'], function ($router) {        
    Route::get('/firstlogin/{user_id}', 'App\Http\Controllers\Api\UserController@isFirstLogin');
    Route::get('/check_unlock_instant_apply/{user_id}', 'App\Http\Controllers\Api\UserController@check_unlock_instant_apply');
    Route::get('/jobpreferences/{user_id}', 'App\Http\Controllers\Api\UserController@getJobPreferences');
    Route::put('updatejobpreferences/{user_id}', 'App\Http\Controllers\Api\UserController@updateJobPreferences');
    Route::get('/getusersdetails/{id}', 'App\Http\Controllers\Api\UserController@getUserDetails');
    Route::put('/updateemployee/{id}', 'App\Http\Controllers\Api\UserController@updateEmployee');
    Route::delete('/deleteuser/{id}', 'App\Http\Controllers\Api\UserController@deleteUser');
    Route::put('/updateprofilepercentage/{user_id}/{value}', 'App\Http\Controllers\Api\UserController@updateProfilePercentage');
    Route::put('/updatestatus/{user_id}/{value}', 'App\Http\Controllers\Api\UserController@updateStatus');
    Route::put('/updateemailverified/{id}', 'App\Http\Controllers\Api\UserController@updateEmailVerified');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'], 'prefix' => 'company'], function ($router) {        
    // Company routes
    Route::get('getcompany', 'App\Http\Controllers\Api\CompanyController@getAllCompany');
    Route::get('getsinglecompany/{id}', 'App\Http\Controllers\Api\CompanyController@getSingleCompany');
    Route::post('createcompany', 'App\Http\Controllers\Api\CompanyController@createCompany');
    Route::put('updatecompany/{id}', 'App\Http\Controllers\Api\CompanyController@updateCompany');
    Route::delete('deletecompany/{id}', 'App\Http\Controllers\Api\CompanyController@deleteCompany');
    // Route for updating company resume count
    Route::put('updatecompanyresumecount/{id}/{value}', 'App\Http\Controllers\Api\CompanyController@updateCompanyResumeCount');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'], 'prefix' => 'companyprofileview'], function ($router) { 
    Route::get('/getcompanyviewcountbydays/{company_id}/{days}', 'App\Http\Controllers\Api\CompanyProfileViewController@getCompanyViewCountByDays');
    Route::get('/getcompanyviewlistbydays/{company_id}/{days}', 'App\Http\Controllers\Api\CompanyProfileViewController@getCompanyViewListByDays');
    Route::get('/getcompanyuserviewedbydays/{user_id}/{days}', 'App\Http\Controllers\Api\CompanyProfileViewController@getCompanyUserViewedByDays');
    Route::post('/createcompanyview', 'App\Http\Controllers\Api\CompanyProfileViewController@insertCompanyView');
    Route::put('/updatecompanyview/{id}', 'App\Http\Controllers\Api\CompanyProfileViewController@updateCompanyView');
    Route::delete('/deletecompanyview/{id}', 'App\Http\Controllers\Api\CompanyProfileViewController@deleteCompanyView');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'], 'prefix' => 'workexperience'], function ($router) {        
    Route::get('/getworkexperience', 'App\Http\Controllers\Api\WorkExperienceController@getWorkExperience');
    Route::get('/getsingleworkexperience/{id}', 'App\Http\Controllers\Api\WorkExperienceController@getSingleWorkExperience');
    Route::post('/createworkexperience', 'App\Http\Controllers\Api\WorkExperienceController@createWorkExperience');
    Route::put('updateworkexperience/{id}', 'App\Http\Controllers\Api\WorkExperienceController@updateWorkExperience');
    Route::delete('deleteworkexperience/{id}', 'App\Http\Controllers\Api\WorkExperienceController@destroyWorkExperience');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'], 'prefix' => 'adminsettings'], function ($router) {        
    Route::get('/getalladminsettings', 'App\Http\Controllers\Api\AdminSettingsController@getAllAdminSettings');
    Route::get('/getsingleadminsettings/{id}', 'App\Http\Controllers\Api\AdminSettingsController@getSingleAdminSettings');
    Route::get('/getadminsettingsbystatus/{status}', 'App\Http\Controllers\Api\AdminSettingsController@getAdminSettingsByStatus');
    Route::get('/getadminsettingsby/user/{user_id}/status/{status}', 'App\Http\Controllers\Api\AdminSettingsController@getAdminSettingsByUserIdWithStatus');
    Route::get('/getadminsettingsbytype/{type}', 'App\Http\Controllers\Api\AdminSettingsController@getAdminSettingsByType');
    Route::post('/createadminsettings', 'AdminSettingsController@createAdminSetting');
    Route::put('/updateadminsettings/{id}', 'AdminSettingsController@updateAdminSetting');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'applications'], function ($router) { 
    Route::get('getallapplications', 'App\Http\Controllers\Api\ApplicationsController@getAllApplications');
    Route::get('getsingleapplication/{id}', 'App\Http\Controllers\Api\ApplicationsController@getSingleApplication');
    Route::post('createapplication', 'App\Http\Controllers\Api\ApplicationsController@createApplication');
    Route::put('updateapplications/{id}', 'App\Http\Controllers\Api\ApplicationsController@updateApplication');
    Route::get('getapplicationbycompany/{id}', 'App\Http\Controllers\Api\ApplicationsController@getApplicationByCompanyId');
    Route::get('getapplicationbystatus/{status}', 'App\Http\Controllers\Api\ApplicationsController@getApplicationByStatus');
    Route::get('getapplicationby/company/{id}/status/{status}', 'App\Http\Controllers\Api\ApplicationsController@getApplicationByCompanyIdWithStatus');
    Route::delete('deleteapplication/{id}', 'App\Http\Controllers\Api\ApplicationsController@deleteApplication');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'companyfollower'], function ($router) { 
    Route::get('getcompanyfollowerscount/{company_id}/', 'App\Http\Controllers\Api\CompanyFollowerController@getCompanyFollowersCount');
    Route::get('getcompanyusersfollow/{user_id}/', 'App\Http\Controllers\Api\CompanyFollowerController@getCompaniesUserFollow');
    Route::post('createompanyfollower', 'App\Http\Controllers\CompanyFollowerController@createCompanyFollower');
    Route::put('updatecompanyfollower', 'App\Http\Controllers\CompanyFollowerController@updateCompanyFollower');
    Route::delete('deletecompanyfollower/{id}', 'App\Http\Controllers\Api\ApplicationsController@deleteCompanyFollower');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'interview'], function ($router) {
    Route::get('/getallinterviews', 'App\Http\Controllers\Api\InterviewController@getAllInterviews');
    Route::get('/getuserinterviews/{user_id}', 'App\Http\Controllers\Api\InterviewController@getUserInterviews');
    Route::get('/getuserfutureinterviews/{user_id}', 'App\Http\Controllers\Api\InterviewController@getUserFutureInterviews');
    Route::get('/getcompanyinterviews/{company_id}', 'App\Http\Controllers\Api\InterviewController@getCompanyInterviews');
    Route::get('/getcompanyuserfutureinterviews/{company_id}', 'App\Http\Controllers\Api\InterviewController@getCompanyUserfutureInterviews');
    Route::post('/insertinterviews', 'App\Http\Controllers\Api\InterviewController@insertInterview');
    Route::put('/updateinterviews/{id}', 'App\Http\Controllers\Api\InterviewController@updateInterview');
    Route::delete('/deleteinterviews/{id}', 'App\Http\Controllers\Api\InterviewController@deleteInterview');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'jobs'], function ($router) {
    Route::get('/getalljobs', 'App\Http\Controllers\Api\JobsController@getAllJobs');
    Route::get('/getsinglejobs/{id}', 'App\Http\Controllers\Api\JobsController@getSingleJob');
    Route::get('/getsortbyjobs/{option}', 'App\Http\Controllers\Api\JobsController@getSortByJobs');
    Route::post('/createjobs', 'App\Http\Controllers\Api\JobsController@createJob');
    Route::put('/updatejobs/{id}', 'App\Http\Controllers\Api\JobsController@updateJob');
    Route::delete('/deletejobs/{id}', 'App\Http\Controllers\Api\JobsController@deleteJob');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'skills'], function ($router) {
    Route::get('/getallskills', 'App\Http\Controllers\Api\SkillController@getAllSkills');
    Route::get('/getsingleskills/{id}', 'App\Http\Controllers\Api\SkillController@getSingleSkills');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'employeeskills'], function ($router) {
    Route::get('/getallemployeeskills', 'App\Http\Controllers\Api\EmployeeSkillsController@getAllEmployeeSkills');
    Route::post('/addemployeeskills', 'App\Http\Controllers\Api\EmployeeSkillsController@addEmployeeSkills');
    Route::put('/updateemployeeskills/{id}', 'App\Http\Controllers\Api\EmployeeSkillsController@updateEmployeeSkills');
    Route::delete('/deleteemployeeskills/{id}', 'App\Http\Controllers\Api\EmployeeSkillsController@deleteEmployeeSkills');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'languages'], function ($router) {
    Route::get('/getalllanguages', 'App\Http\Controllers\Api\LanguageController@getAllLanguages');
    Route::get('/getsinglelanguages/{id}', 'App\Http\Controllers\Api\LanguageController@getSingleLanguages');
    Route::post('/addlanguage', 'App\Http\Controllers\Api\LanguageController@addLanguages');
    Route::put('/updatelanguages/{id}', 'App\Http\Controllers\Api\LanguageController@updateLanguages');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'portfolio'], function ($router) {
    Route::get('/getallportfolios', 'App\Http\Controllers\Api\PortfolioController@getAllPortfolios');
    Route::get('/getsingleportfolio/{id}', 'App\Http\Controllers\Api\PortfolioController@getSinglePortfolio');
    Route::post('/addportfolio', 'App\Http\Controllers\Api\PortfolioController@addPortfolio');
    Route::put('/updateportfolio/{id}', 'App\Http\Controllers\Api\PortfolioController@updatePortfolio');
    Route::delete('/deleteportfolio/{id}', 'App\Http\Controllers\Api\PortfolioController@deletePortfolio');
});

Route::group(['middleware' => ['auth:api', 'jwt.auth'],'prefix' => 'sector'], function ($router) {
    router.get('/getallsectors', 'App\Http\Controllers\Api\SectorController@getAllSectors');
    router.get('/getsinglesector/{id}', 'App\Http\Controllers\Api\SectorController@getSingleSector');
    router.post('/addsector', 'App\Http\Controllers\Api\SectorController@addSector');
    router.put('/updatesectors/{id}', 'App\Http\Controllers\Api\SectorController@updateSector');
});

Route::group(['middleware' => ['auth:api','jwt.auth'],'prefix' => 'errorlog'], function(){
    Route::get('lists', 'App\Http\Controllers\Api\ErrorLogController@errorLists');
    Route::post('search', 'App\Http\Controllers\Api\ErrorLogController@errorSearch');
    Route::get('detail/{id}', 'App\Http\Controllers\Api\ErrorLogController@geterrorDetails');
});