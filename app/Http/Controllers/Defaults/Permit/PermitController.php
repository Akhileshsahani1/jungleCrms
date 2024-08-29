<?php

namespace App\Http\Controllers\Defaults\Permit;

use App\Http\Controllers\Controller;
use App\Models\PermitRate;
use App\Models\PermitLink;
use Illuminate\Http\Request;

class PermitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type                 = isset($request->type) ? $request->type : 'gir';
        $gir_rates            = PermitRate::where('sanctuary', 'gir')->get();
        $jim_rates            = PermitRate::where('sanctuary', 'jim')->get();
        $tadoba_rates            = PermitRate::where('sanctuary', 'tadoba')->get();
        $ranthambore_rates    = PermitRate::where('sanctuary', 'ranthambore')->get();

        return view('defaults.permits.list', compact('type','gir_rates', 'jim_rates', 'ranthambore_rates','tadoba_rates'));
    }


    public function store(Request $request)
    {
        $permit                 = isset($request->id) ? PermitRate::find($request->id) : new PermitRate;
        $permit->sanctuary      = $request->sanctuary;
        $permit->type           = $request->type;
        $permit->nationality    = $request->nationality;
        $permit->price          = $request->price;
        $permit->save();

        if(isset($request->id)){
            return redirect()->route('permit.index',['type' => $permit->sanctuary])->with('success', 'Permit Rate Updated Successfully');
        }else{
            return redirect()->route('permit.index',['type' => $permit->sanctuary])->with('success', 'Permit Rate Created Successfully');
        }

        return redirect()->route('permit.index',['type' => $permit->sanctuary])->with('success', 'Permit Rate Created Successfully');
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

    public function destroy($id)
    {
        $permit = PermitRate::find($id);
        $type   =  $permit->sanctuary;
        $permit->delete();

        return redirect()->route('permit.index',['type' => $type])->with('success', 'Permit Rate Deleted Successfully');
    }
    public function generatePermits()
    {
        $per_links = PermitLink::latest()->get();

        return view('defaults.permits.generate_list', compact('per_links'));
    }
}
