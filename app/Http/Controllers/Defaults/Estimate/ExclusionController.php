<?php

namespace App\Http\Controllers\Defaults\Estimate;

use App\Http\Controllers\Controller;
use App\Models\Exclusion;
use App\Models\EstimateDestination;
use Illuminate\Http\Request;

class ExclusionController extends Controller
{

    public function index(Request $request){
        $type = 'cab';
        if(isset($request->type)){
            $type = $request->type;
        }

        $cab_exclusions              = Exclusion::where('type', 'cab')->get();
        $hotel_normal_exclusions     = Exclusion::where('type', 'hotel')->where('filter', 'normal')->get();
        $hotel_weekend_exclusions    = Exclusion::where('type', 'hotel')->where('filter', 'weekend')->get();
        $hotel_festival_exclusions   = Exclusion::where('type', 'hotel')->where('filter', 'festival')->get();
        $safari_gir_exclusions       = Exclusion::where('type', 'safari')->where('filter', 'gir')->get();
        $safari_jim_exclusions       = Exclusion::where('type', 'safari')->where('filter', 'jim')->get();
        $safari_ran_exclusions       = Exclusion::where('type', 'safari')->where('filter', 'ranthambore')->get();
        $safari_tadoba_exclusions       = Exclusion::where('type', 'safari')->where('filter', 'tadoba')->get();
        $tour_exclusions             = Exclusion::where('type', 'tour')->get();
        $package_exclusions          = EstimateDestination::with('exclusions')->get();
        $destinations                = EstimateDestination::all();

        return view('defaults.estimates.exclusions.exclusions', compact('type','cab_exclusions', 'hotel_normal_exclusions', 'hotel_weekend_exclusions', 'hotel_festival_exclusions','safari_gir_exclusions','safari_ran_exclusions','safari_jim_exclusions','safari_tadoba_exclusions', 'tour_exclusions', 'package_exclusions','destinations'));
    }

    public function saveCabExclusions(Request $request){

        $term           = new Exclusion;
        $term->type     = 'cab';
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'cab'])->with('success', 'Cab exclusion saved successully,');
    }

    public function updateCabExclusions(Request $request){

        $term           = Exclusion::find($request->id);
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'cab'])->with('success', 'Cab exclusions updated successully,');
    }

    public function saveHotelExclusions(Request $request){

        $term           = new Exclusion;
        $term->type     = 'hotel';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'hotel'])->with('success', 'Hotel exclusion saved successully,');
    }

    public function updateHotelExclusions(Request $request){

        $term           = Exclusion::find($request->id);
        $term->content  = $request->content;
        $term->filter   = $request->filter;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'hotel'])->with('success', 'Hotel exclusions updated successully,');
    }

    public function saveSafariExclusions(Request $request){

        $term           = new Exclusion;
        $term->type     = 'safari';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'safari'])->with('success', 'Safari exclusions saved successully,');
    }

    public function updateSafariExclusions(Request $request){

        $term           = Exclusion::find($request->id);
        $term->content  = $request->content;
        $term->filter   = $request->filter;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'safari'])->with('success', 'Safari exclusions updated successully,');
    }

    public function saveTourExclusions(Request $request){

        $term           = new Exclusion;
        $term->type     = 'tour';
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'tour'])->with('success', 'Tour exclusions saved successully,');
    }

    public function updateTourExclusions(Request $request){

        $term           = Exclusion::find($request->id);
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'tour'])->with('success', 'Tour exclusions updated successully,');
    }

    public function savePackageExclusions(Request $request){

        $term           = new Exclusion;
        $term->type     = 'package';
        $term->content  = $request->content;
        $term->destination_id  = $request->destination_id;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'package'])->with('success', 'Package exclusions saved successully,');
    }

    public function updatePackageExclusions(Request $request){

        $term           = Exclusion::find($request->id);
        $term->content  = $request->content;
        $term->destination_id  = $request->destination_id;
        $term->save();

        return redirect()->route('exclusions.index',['type' => 'package'])->with('success', 'Package exclusions updated successully,');
    }

    public function destroy($id)
    {
        $exclusion = Exclusion::find($id);
        $type      =  $exclusion->type;
        $exclusion->delete();
        return redirect()->route('exclusions.index',['type' => $type])->with('success', 'Term deleted Successfully');
    }

    public function getExclusions(Request $request){
        $exclusions     = Exclusion::where('type', $request->type)->where('filter', $request->filter)->get();
        return response($exclusions);

    }
     public function getPackageExclusions(Request $request){
        $exclusions     = Exclusion::where('type', $request->type)->where('destination_id', $request->destination_id)->get();
        return response($exclusions);

    }
}
