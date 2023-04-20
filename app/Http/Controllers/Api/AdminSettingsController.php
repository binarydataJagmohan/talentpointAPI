<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AdminSettings;
use App\Classes\ErrorsClass;
use JWTAuth;
use DB;
use Paginate;

class AdminSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAllAdminSettings()
    {
        try {
            $adminSettings = AdminSettings::where('status', 'active')->orderBy('id', 'DESC')->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Admin settings retrieved successfully',
                'data' => $adminSettings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving admin settings',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSingleAdminSettings($id)
    {
        try {
            $adminSetting = AdminSettings::where('id', $id)->where('status', 'active')->first();
            if ($adminSetting) {
                return response()->json([
                    'status' => true,
                    'message' => 'Admin setting found',
                    'data' => $adminSetting
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Admin setting not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to get admin setting',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAdminSettingsByStatus($status)
    {
        try {
            $adminSettings = AdminSettings::where('status', $status)->get();
            return response()->json([
                'status' => true,
                'message' => 'Admin settings retrieved successfully',
                'data' => $adminSettings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to get admin settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAdminSettingsByUserIdWithStatus($userId, $status)
    {
        try {
            $adminSettings = AdminSettings::where('user_id', $userId)->where('status', $status)->get();
            return response()->json([
                'status' => true,
                'message' => 'Admin settings retrieved successfully',
                'data' => $adminSettings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to get admin settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAdminSettingsByType($type)
    {
        try {
            $columns = [];
            switch ($type) {
                case 'Website':
                    $columns = ['logo', 'favicon'];
                    break;
                case 'payment gateway':
                    $columns = ['payment_gateway', 'stripe_test_secret_key', 'stripe_test_publish_key', 'stripe_live_secret_key', 'stripe_live_publish_key'];
                    break;
                case 'home page':
                    $columns = ['homepage_meta_tag', 'homepage_meta_title', 'homepage_meta_description'];
                    break;
                case 'job':
                    $columns = ['jobs_meta_tag', 'jobs_meta_title', 'jobs_meta_description'];
                    break;
                case 'carreer':
                    $columns = ['carrer_meta_tag', 'carrer_meta_title', 'carrer_meta_description'];
                    break;
                case 'about':
                    $columns = ['about_meta_tag', 'about_meta_title', 'about_meta_description'];
                    break;
                case 'employer':
                    $columns = ['employer_meta_tag', 'employer_meta_title', 'employer_meta_description'];
                    break;
                case 'employee':
                    $columns = ['employee_meta_tag', 'employee_meta_title', 'employee_meta_description'];
                    break;
                case 'pricing':
                    $columns = ['pricing_meta_tag', 'pricing_meta_title', 'pricing_meta_description'];
                    break;
                case 'blog':
                    $columns = ['blog_listing_meta_tag', 'blog_listing_meta_title', 'blog_listing_meta_description'];
                    break;
                default:
                    // If the type parameter is not recognized, throw an exception
                    throw new \Exception('Invalid admin settings type.');
            }

            // Retrieve the requested columns from the admin_settings table
            $settings = DB::table('admin_settings')->select($columns)->first();

            if (!$settings) {
                // If no settings were found, throw an exception
                //throw new \Exception('No admin settings found for the specified type.');
                return response()->json([
                    'status' => false,
                    'message' => 'No admin settings found for the specified type.',
                    'error' => '',
                    'data' => $settings
                ], 200);
            }
            // Return the settings as a JSON response
            return response()->json([
                'status' => true,
                'message' => 'Admin settings retrieved successfully.',
                'error' => '',
                'data' => $settings
            ], 200);
        } catch (\Exception $e) {
            // If an exception was thrown, return an error message as a JSON response
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve admin settings.',
                'error' => $e->getMessage(),
                'data' => null
            ], 400);
        }
    }

    public function createAdminSetting(Request $request)
    {
        try {
            $adminSetting = new AdminSettings();
            $adminSetting->user_id = $request->input('user_id');
            $adminSetting->logo = $request->input('logo');
            $adminSetting->favicon = $request->input('favicon');
            $adminSetting->payment_gateway = $request->input('payment_gateway');
            $adminSetting->stripe_test_secret_key = $request->input('stripe_test_secret_key');
            $adminSetting->stripe_test_publish_key = $request->input('stripe_test_publish_key');
            $adminSetting->stripe_live_secret_key = $request->input('stripe_live_secret_key');
            $adminSetting->stripe_live_publish_key = $request->input('stripe_live_publish_key');
            $adminSetting->homepage_meta_tag = $request->input('homepage_meta_tag');
            $adminSetting->homepage_meta_title = $request->input('homepage_meta_title');
            $adminSetting->homepage_meta_description = $request->input('homepage_meta_description');
            $adminSetting->jobs_meta_tag = $request->input('jobs_meta_tag');
            $adminSetting->jobs_meta_title = $request->input('jobs_meta_title');
            $adminSetting->jobs_meta_description = $request->input('jobs_meta_description');
            $adminSetting->carrer_meta_tag = $request->input('carrer_meta_tag');
            $adminSetting->carrer_meta_title = $request->input('carrer_meta_title');
            $adminSetting->carrer_meta_description = $request->input('carrer_meta_description');
            $adminSetting->about_meta_tag = $request->input('about_meta_tag');
            $adminSetting->about_meta_title = $request->input('about_meta_title');
            $adminSetting->about_meta_description = $request->input('about_meta_description');
            $adminSetting->employer_meta_tag = $request->input('employer_meta_tag');
            $adminSetting->employer_meta_title = $request->input('employer_meta_title');
            $adminSetting->employer_meta_description = $request->input('employer_meta_description');
            $adminSetting->employee_meta_tag = $request->input('employee_meta_tag');
            $adminSetting->employee_meta_title = $request->input('employee_meta_title');
            $adminSetting->employee_meta_description = $request->input('employee_meta_description');
            $adminSetting->pricing_meta_tag = $request->input('pricing_meta_tag');
            $adminSetting->pricing_meta_title = $request->input('pricing_meta_title');
            $adminSetting->pricing_meta_description = $request->input('pricing_meta_description');
            $adminSetting->blog_listing_meta_tag = $request->input('blog_listing_meta_tag');
            $adminSetting->blog_listing_meta_title = $request->input('blog_listing_meta_title');
            $adminSetting->blog_listing_meta_description = $request->input('blog_listing_meta_description');
            $adminSetting->status = $request->input('status');
            $adminSetting->save();

            return response()->json([
                'status' => true,
                'message' => 'Admin setting created successfully',
                'data' => $adminSetting,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating admin setting',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateAdminSetting(Request $request, $id)
    {
        try {
            $adminSetting = AdminSettings::where('id', $id)->where('status', 'active')->first();

            if (!$adminSetting) {
                return response()->json([
                    'status' => false,
                    'message' => 'Admin setting not found',
                ], 404);
            }

            $adminSetting->user_id = $request->input('user_id');
            $adminSetting->logo = $request->input('edit_logo');
            $adminSetting->favicon = $request->input('edit_favicon');
            $adminSetting->payment_gateway = $request->input('edit_payment_gateway');
            $adminSetting->stripe_test_secret_key = $request->input('edit_stripe_test_secret_key');
            $adminSetting->stripe_test_publish_key = $request->input('edit_stripe_test_publish_key');
            $adminSetting->stripe_live_secret_key = $request->input('edit_stripe_live_secret_key');
            $adminSetting->stripe_live_publish_key = $request->input('edit_stripe_live_publish_key');
            $adminSetting->homepage_meta_tag = $request->input('edit_homepage_meta_tag');
            $adminSetting->homepage_meta_title = $request->input('edit_homepage_meta_title');
            $adminSetting->homepage_meta_description = $request->input('edit_homepage_meta_description');
            $adminSetting->jobs_meta_tag = $request->input('edit_jobs_meta_tag');
            $adminSetting->jobs_meta_title = $request->input('edit_jobs_meta_title');
            $adminSetting->jobs_meta_description = $request->input('edit_jobs_meta_description');
            $adminSetting->carrer_meta_tag = $request->input('edit_carrer_meta_tag');
            $adminSetting->carrer_meta_title = $request->input('edit_carrer_meta_title');
            $adminSetting->carrer_meta_description = $request->input('edit_carrer_meta_description');
            $adminSetting->about_meta_tag = $request->input('edit_about_meta_tag');
            $adminSetting->about_meta_title = $request->input('edit_about_meta_title');
            $adminSetting->about_meta_description = $request->input('edit_about_meta_description');
            $adminSetting->employer_meta_tag = $request->input('edit_employer_meta_tag');
            $adminSetting->employer_meta_title = $request->input('edit_employer_meta_title');
            $adminSetting->employer_meta_description = $request->input('edit_employer_meta_description');
            $adminSetting->employee_meta_tag = $request->input('edit_employee_meta_tag');
            $adminSetting->employee_meta_title = $request->input('edit_employee_meta_title');
            $adminSetting->employee_meta_description = $request->input('edit_employee_meta_description');
            $adminSetting->pricing_meta_tag = $request->input('edit_pricing_meta_tag');
            $adminSetting->pricing_meta_title = $request->input('edit_pricing_meta_title');
            $adminSetting->pricing_meta_description = $request->input('edit_pricing_meta_description');
            $adminSetting->blog_listing_meta_tag = $request->input('edit_blog_listing_meta_tag');
            $adminSetting->blog_listing_meta_title = $request->input('edit_blog_listing_meta_title');
            $adminSetting->blog_listing_meta_description = $request->input('edit_blog_listing_meta_description');
            $adminSetting->status = $request->input('status');
            $adminSetting->save();

            return response()->json([
                'status' => true,
                'message' => 'Admin setting updated successfully',
                'data' => $adminSetting,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error updating admin setting',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
