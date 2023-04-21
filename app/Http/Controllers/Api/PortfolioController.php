<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Classes\ErrorsClass;
use JWTAuth;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    function getAllPortfolios() {
        try {
            $portfolios = Portfolio::where('status', '!=', 'deleted')->orderBy('id', 'desc')->get();
            return response()->json(['data' => $portfolios], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch portfolios', 'error' => $e->getMessage()], 400);
        }
    }

    function getSinglePortfolio($id) {
        try {
            $portfolio = Portfolio::where('id', $id)->where('status', '!=', 'deleted')->first();
            if (!$portfolio) {
                return response()->json(['message' => 'Portfolio not found'], 404);
            }
            return response()->json(['data' => $portfolio], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch portfolio', 'error' => $e->getMessage()], 400);
        }
    }

    function addPortfolio(Request $request) {
        try {
            $portfolio = new Portfolio;
            $portfolio->user_id = $request->user_id;
            $portfolio->portfolio_link = $request->portfolio_link;
            $portfolio->start_date = $request->start_date;
            $portfolio->end_date = $request->end_date;
            $portfolio->present = $request->present;
            $portfolio->description = $request->description;
            $portfolio->status = $request->status;
            $portfolio->save();

            return response()->json(['message' => 'Portfolio added successfully', 'data' => $portfolio], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to add portfolio', 'error' => $e->getMessage()], 400);
        }
    }

    function updatePortfolio(Request $request, $id) {
        try {
            $portfolio = Portfolio::find($id);
            if (!$portfolio) {
                return response()->json(['message' => 'Portfolio not found'], 404);
            }
            $portfolio->user_id = $request->user_id;
            $portfolio->portfolio_link = $request->portfolio_link;
            $portfolio->start_date = $request->start_date;
            $portfolio->end_date = $request->end_date;
            $portfolio->present = $request->present;
            $portfolio->description = $request->description;
            $portfolio->status = $request->status;
            $portfolio->save();

            return response()->json(['message' => 'Portfolio updated successfully', 'data' => $portfolio], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to update portfolio', 'error' => $e->getMessage()], 400);
        }
    }

    function deletePortfolio($id) {
        try {
            $portfolio = Portfolio::find($id);
            if (!$portfolio) {
                return response()->json(['message' => 'Portfolio not found'], 404);
            }
            $portfolio->status = 'deleted';
            $portfolio->save();

            return response()->json(['message' => 'Portfolio deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete portfolio', 'error' => $e->getMessage()], 400);
        }
    }

}