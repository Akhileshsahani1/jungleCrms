<?php

namespace App\Http\Controllers\PaymentMode;

use App\Http\Controllers\Controller;
use App\Models\PaymentMode;
use Illuminate\Http\Request;

class OfflineModeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modes = PaymentMode::where('mode', 'offline')->get();

        return view('payment-modes.offline-mode.list', compact('modes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-modes.offline-mode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'name'                  => 'required',
                'account_holder_name'   => 'required',
                'account_number'        => 'required',
                'ifsc_code'             => 'required',
                'account_type'          => 'required',
                'bank_name'             => 'required',
            ],
            [
                'name.required'                 => 'Please enter Payment Mode name.',
                'account_holder_name.required'  => 'Please enter account holder name.',
                'account_number.required'       => 'Account Number is required.',
                'ifsc_code.required'            => 'Please enter IFSC code.',
                'account_type.required'         => 'Please select account type.',
                'bank_name.required'            => 'Please enter bank name.',
            ]
          );

          $mode = new PaymentMode();
          $mode->name = $request->name;
          $mode->mode = 'offline';
          $mode->details = $request->all();
          $mode->save();
          return redirect()->route('offline-mode.index')->with('success', 'Offline mode details saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mode = PaymentMode::find($id);

        $mode->status = $mode->status == 1 ? '0': '1';
        $mode->save();
        if($mode->status == '1'){
            return redirect()->route('offline-mode.index')->with('success', 'Offline mode is activated Successfully');
        }else{
            return redirect()->route('offline-mode.index')->with('error', 'Offline mode is deactivated Successfully');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mode = PaymentMode::find($id);
        return view('payment-modes.offline-mode.edit', compact('mode'));
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
        $request->validate(
            [
                'name'                  => 'required',
                'account_holder_name'   => 'required',
                'account_number'        => 'required',
                'ifsc_code'             => 'required',
                'account_type'          => 'required',
                'bank_name'             => 'required',
            ],
            [
                'name.required'                 => 'Please enter Payment Mode name.',
                'account_holder_name.required'  => 'Please enter account holder name.',
                'account_number.required'       => 'Account Number is required.',
                'ifsc_code.required'            => 'Please enter IFSC code.',
                'account_type.required'         => 'Please select account type.',
                'bank_name.required'            => 'Please enter bank name.',
            ]
          );

          $mode = PaymentMode::find($id);
          $mode->name = $request->name;
          $mode->details = $request->all();
          $mode->save();
          return redirect()->route('offline-mode.index')->with('success', 'Offline mode details updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaymentMode::find($id)->delete();
        return redirect()->route('offline-mode.index')->with('success', 'Offline mode details deleted Successfully');
    }
}
