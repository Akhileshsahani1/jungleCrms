<?php

namespace App\Http\Controllers\Defaults\Estimate;

use App\Http\Controllers\Controller;
use App\Models\Inclusion;
use App\Models\EstimateDestination;
use Illuminate\Http\Request;

class InclusionController extends Controller
{

    public function index(Request $request){
        $type = 'cab';
        if(isset($request->type)){
            $type = $request->type;
        }
        $cab_inclusions              = Inclusion::where('type', 'cab')->get();
        $hotel_normal_inclusions     = Inclusion::where('type', 'hotel')->where('filter', 'normal')->get();
        $hotel_weekend_inclusions    = Inclusion::where('type', 'hotel')->where('filter', 'weekend')->get();
        $hotel_festival_inclusions   = Inclusion::where('type', 'hotel')->where('filter', 'festival')->get();
        $safari_gir_inclusions       = Inclusion::where('type', 'safari')->where('filter', 'gir')->get();
        $safari_jim_inclusions       = Inclusion::where('type', 'safari')->where('filter', 'jim')->get();
        $safari_tadoba_inclusions       = Inclusion::where('type', 'safari')->where('filter', 'tadoba')->get();
         $safari_ran_inclusions       = Inclusion::where('type', 'safari')->where('filter', 'ranthambore')->get();
        $tour_inclusions             = Inclusion::where('type', 'tour')->get();
        $package_inclusions          = EstimateDestination::with('inclusions')->get();
        $destinations                = EstimateDestination::all();
        
        return view('defaults.estimates.inclusions.inclusions', compact('type','cab_inclusions', 'hotel_normal_inclusions', 'hotel_weekend_inclusions', 'hotel_festival_inclusions','safari_gir_inclusions','safari_ran_inclusions','safari_jim_inclusions','safari_tadoba_inclusions', 'tour_inclusions', 'package_inclusions','destinations'));
    }

    public function saveCabInclusions(Request $request){

        $term           = new Inclusion;
        $term->type     = 'cab';
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'cab'])->with('success', 'Cab inclusions saved successully,');
    }

    public function updateCabInclusions(Request $request){

        $term           = Inclusion::find($request->id);
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'cab'])->with('success', 'Cab inclusions updated successully,');
    }

    public function saveHotelInclusions(Request $request){

        $term           = new Inclusion;
        $term->type     = 'hotel';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'hotel'])->with('success', 'Hotel inclusions saved successully,');
    }

    public function updateHotelInclusions(Request $request){

        $term           = Inclusion::find($request->id);
        $term->content  = $request->content;
        $term->filter   = $request->filter;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'cab'])->with('success', 'Hotel inclusions updated successully,');
    }

    public function saveSafariInclusions(Request $request){

        $term           = new Inclusion;
        $term->type     = 'safari';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'safari'])->with('success', 'Safari inclusions saved successully,');
    }

    public function updateSafariInclusions(Request $request){

        $term           = Inclusion::find($request->id);
        $term->content  = $request->content;
        $term->filter   = $request->filter;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'safari'])->with('success', 'Safari inclusions updated successully,');
    }

    public function saveTourInclusions(Request $request){

        $term           = new Inclusion;
        $term->type     = 'tour';
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'tour'])->with('success', 'Tour inclusions saved successully,');
    }

    public function updateTourInclusions(Request $request){

        $term           = Inclusion::find($request->id);
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'tour'])->with('success', 'Tour inclusions updated successully,');
    }

    public function savePackageInclusions(Request $request){

        $term           = new Inclusion;
        $term->type     = 'package';
        $term->content  = $request->content;
        $term->destination_id  = $request->destination_id;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'package'])->with('success', 'Package inclusions saved successully,');
    }

    public function updatePackageInclusions(Request $request){

        $term           = Inclusion::find($request->id);
        $term->content  = $request->content;
        $term->destination_id  = $request->destination_id;
        $term->save();

        return redirect()->route('inclusions.index',['type' => 'package'])->with('success', 'Package inclusions updated successully,');
    }

    public function destroy($id)
    {
        $inclusion = Inclusion::find($id);
        $type      = $inclusion->type;
        $inclusion->delete();
        return redirect()->route('inclusions.index',['type' => $type])->with('success', 'Term deleted Successfully');
    }

    public function getInclusions(Request $request){
        $inclusions     = Inclusion::where('type', $request->type)->where('filter', $request->filter)->get();
        return response($inclusions);

    }
    public function getPackageInclusions(Request $request){
        $inclusions     = Inclusion::where('type', $request->type)->where('destination_id', $request->destination_id)->get();
        return response($inclusions);

    }
}
