<?php

namespace App\Http\Controllers\Defaults\LocalAddress;

use App\Http\Controllers\Controller;
use App\Models\LocalAddress;
use App\Models\State;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type                 = isset($request->type) ? $request->type : 'gir';
        $gir_address           = LocalAddress::where('sanctuary', 'gir')->get();
        $jim_address           = LocalAddress::where('sanctuary', 'jim')->get();
        $ranthambore_address   = LocalAddress::where('sanctuary', 'ranthambore')->get();
        $tadoba_address   = LocalAddress::where('sanctuary', 'tadoba')->get();
        $dailytour_address = LocalAddress::where('sanctuary', 'dailytour')->get();
        $states                = State::get(['id', 'state']);

        return view('defaults.local-address.list', compact('type','gir_address', 'jim_address', 'ranthambore_address','tadoba_address','dailytour_address', 'states'));
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
        $address             = isset($request->id) ? LocalAddress::find($request->id) : new LocalAddress;
        $address->name       = $request->name;
        $address->address_1  = $request->address_1;
        $address->address_2  = $request->address_2;
        $address->state      = $request->state;
        $address->sanctuary  = $request->sanctuary;
        $address->pincode    = $request->pincode;
        $address->save();

        if(isset($request->id)){
            return redirect()->route('local-address.index',['type'=>$address->sanctuary])->with('success', 'Local Address Updated Successfully');
        }else{
            return redirect()->route('local-address.index',['type'=>$address->sanctuary])->with('success', 'Local Address Successfully');
        }

        return redirect()->route('local-address.index',['type'=>$address->sanctuary])->with('success', 'Local Address Successfully');
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
        //
    }
}
