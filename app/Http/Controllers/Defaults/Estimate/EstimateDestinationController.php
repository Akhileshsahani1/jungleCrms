<?php

namespace App\Http\Controllers\Defaults\Estimate;

use App\Models\EstimateDestination;
use App\Models\Inclusion;
use App\Models\Exclusion;
use App\Models\Term;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstimateDestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $destinations                      = EstimateDestination::get();

        return view('defaults.estimates.destination.destination', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $e_destination = isset($request->id)?EstimateDestination::find($request->id):new EstimateDestination;
        $e_destination->destination=$request->destination;
        $e_destination->save();
        return redirect()->back()->with('success', 'Estimate Destination  added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Inclusion::where('destination_id',$id)->delete();
        Exclusion::where('destination_id',$id)->delete();
        Term::where('destination_id',$id)->delete();
        $e_destination = EstimateDestination::find($id)->delete();
        return redirect()->back()->with('success', 'Estimate Destination  Deleted successfully');
    }
}
