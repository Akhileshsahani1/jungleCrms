<?php

namespace App\Http\Controllers\PaymentMode;

use App\Http\Controllers\Controller;
use App\Models\PaymentMode;
use Illuminate\Http\Request;

class RazorpayModeController extends Controller
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
        $modes = PaymentMode::where('mode', 'razorpay')->get();

        return view('payment-modes.razorpay-mode.list', compact('modes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-modes.razorpay-mode.create');
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
                'name'                                  => 'required',
                'razorpay_key'                          => 'required',
                'razorpay_secret_key'                   => 'required',
            ],
            [
                'name.required'                 => 'Please enter Payment mode name.',
                'razorpay_key.required'         => 'Please enter Razorpay key.',
                'razorpay_secret_key.required'  => 'Please enter Razorpay secret key.',
            ]
          );

          $mode = new PaymentMode;
          $mode->name = $request->name;
          $mode->mode = 'razorpay';
          $mode->details = $request->all();
          $mode->save();

          return redirect()->route('razorpay-mode.index')->with('success', 'Razorpay mode details saved successfully');
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
            return redirect()->route('razorpay-mode.index')->with('success', 'Razorpay mode is activated Successfully');
        }else{
            return redirect()->route('razorpay-mode.index')->with('error', 'Razorpay mode is deactivated Successfully');
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
        return view('payment-modes.razorpay-mode.edit', compact('mode'));
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
                'name'                                  => 'required',
                'razorpay_key'                          => 'required',
                'razorpay_secret_key'                   => 'required',
            ],
            [
                'name.required'                 => 'Please enter Payment mode name.',
                'razorpay_key.required'         => 'Please enter Razorpay key.',
                'razorpay_secret_key.required'  => 'Please enter Razorpay secret key.',
            ]
          );

          $mode = PaymentMode::find($id);
          $mode->name = $request->name;
          $mode->mode = 'razorpay';
          $mode->details = $request->all();
          $mode->save();

          return redirect()->route('razorpay-mode.index')->with('success', 'Razorpay mode details updated successfully');
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
        return redirect()->route('razorpay-mode.index')->with('success', 'Razorpay mode details deleted Successfully');
    }
}
