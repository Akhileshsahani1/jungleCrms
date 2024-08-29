<?php

namespace App\Http\Controllers\Defaults\Voucher;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;

class VoucherTermsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $type = 'cab';
        if(isset($request->type)){
            $type = $request->type;
        }

        $cab_terms                      = Term::where('mode', 'voucher')->where('type', 'cab')->get();
        $hotel_normal_terms             = Term::where('mode', 'voucher')->where('type', 'hotel')->where('filter', 'normal')->get();
        $hotel_weekend_terms            = Term::where('mode', 'voucher')->where('type', 'hotel')->where('filter', 'weekend')->get();
        $hotel_festival_terms           = Term::where('mode', 'voucher')->where('type', 'hotel')->where('filter', 'festival')->get();
        $safari_gir_terms               = Term::where('mode', 'voucher')->where('type', 'safari')->where('filter', 'gir')->get();
        $safari_jim_terms               = Term::where('mode', 'voucher')->where('type', 'safari')->where('filter', 'jim')->get();
        $safari_ran_terms               = Term::where('mode', 'voucher')->where('type', 'safari')->where('filter', 'ranthambore')->get();
        $safari_tadoba_terms               = Term::where('mode', 'voucher')->where('type', 'safari')->where('filter', 'tadoba')->get();         
        $tour_gir_terms                 = Term::where('mode', 'voucher')->where('type', 'tour')->where('filter', 'gir')->get();
        $tour_jim_terms                 = Term::where('mode', 'voucher')->where('type', 'tour')->where('filter', 'jim')->get();
        $tour_ran_terms                 = Term::where('mode', 'voucher')->where('type', 'tour')->where('filter', 'ranthambore')->get();
        $tour_tadoba_terms                 = Term::where('mode', 'voucher')->where('type', 'tour')->where('filter', 'tadoba')->get();
        $package_gir_terms              = Term::where('mode', 'voucher')->where('type', 'package')->where('filter', 'gir')->get();
        $package_jim_terms              = Term::where('mode', 'voucher')->where('type', 'package')->where('filter', 'jim')->get();
        $package_ran_terms              = Term::where('mode', 'voucher')->where('type', 'package')->where('filter', 'ranthambore')->get();
        $package_tadoba_terms              = Term::where('mode', 'voucher')->where('type', 'package')->where('filter', 'tadoba')->get();

        return view('defaults.vouchers.terms.terms', compact('type','cab_terms', 'hotel_normal_terms', 'hotel_weekend_terms', 'hotel_festival_terms','safari_gir_terms','safari_ran_terms','safari_jim_terms','safari_tadoba_terms', 'tour_gir_terms','tour_jim_terms','tour_ran_terms','tour_tadoba_terms','package_gir_terms','package_jim_terms','package_ran_terms','package_tadoba_terms'));
    }

    public function saveCabTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'voucher';
        $term->type     = 'cab';
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'cab'])->with('success', 'Cab voucher terms saved successully,');
    }

    public function updateCabTerms(Request $request){

        $term           = Term::find($request->id);
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'cab'])->with('success', 'Cab voucher terms updated successully,');
    }

    public function saveHotelTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'voucher';
        $term->type     = 'hotel';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'hotel'])->with('success', 'Hotel voucher terms saved successully,');
    }

    public function updateHotelTerms(Request $request){

        $term           = Term::find($request->id);
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'hotel'])->with('success', 'Hotel voucher terms updated successully,');
    }

    public function saveSafariTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'voucher';
        $term->type     = 'safari';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'safari'])->with('success', 'Safari voucher terms saved successully,');
    }

    public function updateSafariTerms(Request $request){

        $term           = Term::find($request->id);
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'safari'])->with('success', 'Safari voucher terms updated successully,');
    }

    public function saveTourTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'voucher';
        $term->type     = 'tour';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'tour'])->with('success', 'Tour voucher terms saved successully,');
    }

    public function updateTourTerms(Request $request){

        $term           = Term::find($request->id);
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'tour'])->with('success', 'Tour voucher terms updated successully,');
    }

    public function savePackageTerms(Request $request){

        $term           = new Term;
        $term->mode     = 'voucher';
        $term->type     = 'package';
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'package'])->with('success', 'Package voucher terms saved successully,');
    }

    public function updatePackageTerms(Request $request){

        $term           = Term::find($request->id);
        $term->filter   = $request->filter;
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('voucher.terms.index',['type' => 'package'])->with('success', 'Package voucher terms updated successully,');
    }

    public function destroy($id)
    {
        $term = Term::find($id);
        $type = $term->type;
        $term->delete();
        return redirect()->route('voucher.terms.index',['type' => $type])->with('success', 'Term deleted Successfully');
    }

    public function getTerms(Request $request){
        $terms     = Term::where('mode', 'voucher')->where('type', $request->type)->where('filter', $request->filter)->get();
        return response($terms);

    }
}
