<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstimateController extends Controller
{
    public function __construct()
    {
        // Middleware only applied to these methods
        $this->middleware('auth:customer', [
            'only' => [
                'index' // Could add bunch of more methods too
            ]
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       

        $estimates = Estimate::where('customer_id', Auth::guard('customer')->user()->id)->with('customer', 'user')->latest()->paginate(20);
        return view('front.estimates.list', compact('estimates'));
    }

}
