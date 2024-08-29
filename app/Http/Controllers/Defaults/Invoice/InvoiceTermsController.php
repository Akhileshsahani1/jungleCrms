<?php

namespace App\Http\Controllers\Defaults\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;

class InvoiceTermsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $terms = Term::where('mode', 'invoice')->get();
        return view('defaults.invoice.terms', compact('terms'));
    }

    public function save(Request $request){

        $term           = new Term;
        $term->mode     = 'invoice';
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('invoice.terms.index')->with('success', 'Invoice terms saved successully,');
    }

    public function update(Request $request){

        $term           = Term::find($request->id);
        $term->content  = $request->content;
        $term->save();

        return redirect()->route('invoice.terms.index')->with('success', 'Invoice terms updated successully,');
    }

    public function destroy($id)
    {
        Term::find($id)->delete();
        return redirect()->route('invoice.terms.index')->with('success', 'Term deleted Successfully');
    }
}
