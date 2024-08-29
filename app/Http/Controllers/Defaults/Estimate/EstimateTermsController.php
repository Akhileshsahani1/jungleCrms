<?php

namespace App\Http\Controllers\Defaults\Estimate;

use App\Http\Controllers\Controller;
use App\Models\Term;
use App\Models\EstimateDestination;
use Illuminate\Http\Request;

class EstimateTermsController extends Controller
{

    public function index(Request $request){
        $type = 'cab';
        if(isset($request->type)){
            $type = $request->type;
        }
        $cab_terms                      = Term::where('mode', 'estimate')->where('type', 'cab')->get();
        $hotel_normal_terms             = Term::where('mode', 'estimate')->where('type', 'hotel')->where('filter', 'normal')->get();
        $hotel_weekend_terms            = Term::where('mode', 'estimate')->where('type', 'hotel')->where('filter', 'weekend')->get();
        $hotel_festival_terms           = Term::where('mode', 'estimate')->where('type', 'hotel')->where('filter', 'festival')->get();

        $safari_gir_terms               = Term::where('mode', 'estimate')->where('type', 'safari')->where('filter', 'gir')->get();
        $safari_jim_terms               = Term::where('mode', 'estimate')->where('type', 'safari')->where('filter', 'jim')->get();
        $safari_tadoba_terms               = Term::where('mode', 'estimate')->where('type', 'safari')->where('filter', 'tadoba')->get();
        $safari_ran_terms               = Term::where('mode', 'estimate')->where('type', 'safari')->where('filter', 'ranthambore')->get();

        $tour_gir_terms                 = Term::where('mode', 'estimate')->where('type', 'tour')->where('filter', 'gir')->get();
        $tour_jim_terms                 = Term::where('mode', 'estimate')->where('type', 'tour')->where('filter', 'jim')->get();
        $tour_ran_terms                 = Term::where('mode', 'estimate')->where('type', 'tour')->where('filter', 'ranthambore')->get();
        $tour_tadoba_terms                 = Term::where('mode', 'estimate')->where('type', 'tour')->where('filter', 'tadoba')->get();
        $package_terms              = EstimateDestination::with('terms')->get();
        $destinations               = EstimateDestination::all();

        return view('defaults.estimates.terms.terms', compact('type','cab_terms', 'hotel_normal_terms', 'hotel_weekend_terms', 'hotel_festival_terms','safari_gir_terms','safari_ran_terms','safari_jim_terms','safari_tadoba_terms', 'tour_gir_terms','tour_jim_terms','tour_ran_terms','tour_tadoba_terms','package_terms','destinations'));
    }

    public function saveCabTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'estimate';
        $term->type     = 'cab';
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('terms.index',['type' => 'cab'])->with('success', 'Cab terms saved successully,');
    }

    public function updateCabTerms(Request $request){

        $term           = Term::find($request->id);
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('terms.index',['type' => 'cab'])->with('success', 'Cab terms updated successully,');
    }

    public function saveHotelTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'estimate';
        $term->type     = 'hotel';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('terms.index',['type' => 'hotel'])->with('success', 'Hotel terms saved successully,');
    }

    public function updateHotelTerms(Request $request){

        $term           = Term::find($request->id);
        $term->content  = $request->content;
        $term->filter   = $request->filter;
        $term->save();

        return redirect()->route('terms.index',['type' => 'hotel'])->with('success', 'Hotel terms updated successully,');
    }

    public function saveSafariTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'estimate';
        $term->type     = 'safari';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('terms.index',['type' => 'safari'])->with('success', 'Safari terms saved successully,');
    }

    public function updateSafariTerms(Request $request){

        $term           = Term::find($request->id);
        $term->content  = $request->content;
        $term->filter   = $request->filter;
        $term->save();

        return redirect()->route('terms.index',['type' => 'safari'])->with('success', 'Safari terms updated successully,');
    }

    public function saveTourTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'estimate';
        $term->type     = 'tour';
        $term->content  = $request->content;
        $term->filter   = $request->filter;
        $term->save();

        return redirect()->route('terms.index',['type' => 'tour'])->with('success', 'Tour terms saved successully,');
    }

    public function updateTourTerms(Request $request){

        $term           = Term::find($request->id);
        $term->content  = $request->content;
         $term->filter   = $request->filter;
        $term->save();

        return redirect()->route('terms.index',['type' => 'tour'])->with('success', 'Tour terms updated successully,');
    }

    public function savePackageTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'estimate';
        $term->type     = 'package';
        $term->destination_id  = $request->destination_id;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('terms.index',['type' => 'package'])->with('success', 'Package terms saved successully,');
    }

    public function updatePackageTerms(Request $request){

        $term           = Term::find($request->id);
         $term->destination_id  = $request->destination_id;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('terms.index',['type' => 'package'])->with('success', 'Package terms updated successully,');
    }

    public function destroy($id)
    {
        $term = Term::find($id);
        $type = $term->type;
        $term->delete();
        return redirect()->route('terms.index',['type' => $type])->with('success', 'Term deleted Successfully');
    }

    public function getTerms(Request $request){
        $terms     = Term::where('mode', 'estimate')->where('type', $request->type)->where('filter', $request->filter)->get();
        return response($terms);

    }
     public function getPackageTerms(Request $request){
        $terms     = Term::where('mode', 'estimate')->where('type', $request->type)->where('destination_id', $request->destination_id)->get();
        return response($terms);

    }
}
