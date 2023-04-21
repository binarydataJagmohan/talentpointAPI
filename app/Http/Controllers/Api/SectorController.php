<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Sector;
use App\Classes\ErrorsClass;
use JWTAuth;

class SectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAllSectors()
    {
        try {
            $sectors = Sector::where('status', 'active')->orderBy('id', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'sectors' => $sectors
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get sectors',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSingleSector($id)
    {
        try {
            $sector = Sector::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'sector' => $sector
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get sector',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addSector(Request $request)
    {
        try {
            $sector = new Sector;
            $sector->sector_name = $request->sector_name;
            $sector->status = $request->status ?? 'active';
            $sector->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Sector added successfully',
                'sector' => $sector
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add sector',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateSector(Request $request, $id)
    {
        try {
            $sector = Sector::findOrFail($id);
            $sector->sector_name = $request->sector_name ?? $sector->sector_name;
            $sector->status = $request->status ?? $sector->status;
            $sector->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Sector updated successfully',
                'sector' => $sector
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update sector',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}