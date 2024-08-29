<?php

namespace App\Http\Controllers\Defaults\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type                   = isset($request->type) ? $request->type : 'gir';
        $gir_vendors            = Vendor::where('sanctuary', 'gir')->get();
        $jim_vendors            = Vendor::where('sanctuary', 'jim')->get();
        $cab_vendors            = Vendor::where('sanctuary', 'cab')->get();
        $ranthambore_vendors    = Vendor::where('sanctuary', 'ranthambore')->get();
        $tadoba_vendors         = Vendor::where('sanctuary', 'tadoba')->get();

        return view('defaults.vendors.list', compact('type','gir_vendors', 'jim_vendors', 'cab_vendors', 'ranthambore_vendors','tadoba_vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendor             = isset($request->id) ? Vendor::find($request->id) : new Vendor;
        $default_vendor_exist = Vendor::where('sanctuary',$request->sanctuary)->where('default','yes')->exists();
        $vendor->default    = ($default_vendor_exist)?'no':'yes';
        $vendor->name       = $request->name;
        $vendor->email      = $request->email;
        $vendor->sanctuary  = $request->sanctuary;
        $vendor->phone      = $request->phone;
        $vendor->alternate  = $request->alternate;
        $vendor->save();
        if(isset($request->id)){
            return redirect()->route('vendor.index',['type'=>$vendor->sanctuary])->with('success', 'Vendor Updated Successfully');
        }else{
            return redirect()->route('vendor.index',['type'=>$vendor->sanctuary])->with('success', 'Vendor Created Successfully');
        }

        return redirect()->route('vendor.index',['type'=>$vendor->sanctuary])->with('success', 'Vendor Created Successfully');

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
        $vendor = Vendor::find($id);
        $type   = $vendor->sanctuary;
        $vendor->delete();
        return redirect()->route('vendor.index',['type'=>$type])->with('success', 'Vendor Deleted Successfully');
    }
}
