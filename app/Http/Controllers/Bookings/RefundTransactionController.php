<?php

namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Estimate;
use App\Models\RefundTransaction;
use App\Models\BookingCancellationRequest;

class RefundTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $booking                       = Booking::find($request->booking_id);
        $booking->voucher_generated = 'no';
        $booking->save();
        $transaction                    = isset($request->id) ? RefundTransaction::find($request->id)  : new RefundTransaction;
        if(isset($booking->estimate_id)){
            $transaction->estimate_id = $booking->estimate_id;
        }
        $transaction->booking_id        = $request->booking_id;
        $transaction->customer_id       = $booking->customer_id;
        $transaction->date              = $request->date;
        $transaction->amount            = $request->amount;
        $transaction->mode              = $request->mode;
        $transaction->transaction_id    = $request->transaction_id;
        $transaction->note              = $request->note;
        if ($request->hasfile('attachment')) {
            $attachment         = $request->file('attachment');
            $name               = $attachment->getClientOriginalName();
            $attachment->storeAs('uploads/bookings/refund/'.$request->booking_id, $name, 'public');

            $transaction->attachment        = $name;
        }
        $transaction->save();

        BookingCancellationRequest::where('id', $request->cancel_id)->update(['status' =>'1']);

        return redirect()->back()->with('success', 'Refund saved successfully.');
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
        $transaction = RefundTransaction::find($id)->delete();
        return redirect()->back()->with('success', 'Transaction delete successfully.');
    }
}
