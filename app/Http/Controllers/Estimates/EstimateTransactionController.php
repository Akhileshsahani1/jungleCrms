<?php

namespace App\Http\Controllers\Estimates;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Estimate;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstimateTransactionController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $estimate = Estimate::find($request->estimate_id);
        $transactions = Transaction::where('estimate_id', $estimate->id)->latest()->get();
        switch ($estimate->type) {
            case 'cab':
                $estimate->total = cabTotal($estimate->id);
                break;

            case 'tour':
                $estimate->total = tourTotal($estimate->id);
                break;

            case 'hotel':
                $estimate->total = hotelTotal($estimate->id);
                break;

            case 'safari':
                $estimate->total = safariTotal($estimate->id);
                break;
            case 'package':
                $estimate->total = packageTotal($estimate->id);
                break;
        }

        return view('estimates.transactions', compact('transactions', 'estimate'));
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

        $estimate                       = Estimate::find($request->estimate_id);


        $transaction                    = isset($request->id) ? Transaction::find($request->id)  : new Transaction;
        if(bookingExists($estimate->id)){
            $booking_id = Booking::where('estimate_id', $estimate->id)->value('id');

            $transaction->booking_id        = $booking_id;
        }
        $transaction->estimate_id       = $request->estimate_id;
        $transaction->customer_id       = $estimate->customer_id;
        $transaction->date              = $request->date;
        $transaction->amount            = $request->amount;
        $transaction->mode              = $request->mode;
        $transaction->transaction_id    = $request->transaction_id;
        $transaction->save();

        $amount_paid                    = $estimate->transactions->sum('amount');

        switch ($estimate->type) {
            case 'cab':
                $total = cabTotal($estimate->id);
                break;

            case 'tour':
                $total = tourTotal($estimate->id);
                break;

            case 'hotel':
                $total = hotelTotal($estimate->id);
                break;

            case 'safari':
                $total = safariTotal($estimate->id);
                break;

            case 'package':
                $total = packageTotal($estimate->id);
                break;
        }

        if ($total > $amount_paid) {
            $estimate->payment_status = 'partially paid';
            if($estimate->lead_id){
                Lead::where('id', $estimate->lead_id)->update(['payment_status' => 'partially paid']);
                $comment                = new LeadComment();
                $comment->lead_id       = $estimate->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "partially paid";
                $comment->comment       = "Payment of Rs.". $request->amount ." is added by " . Auth::user()->name;
                $comment->save();
            }
        } else {
            $estimate->payment_status = 'paid';
            if($estimate->lead_id){
                Lead::where('id', $estimate->lead_id)->update(['payment_status' => 'paid']);
                $comment                = new LeadComment();
                $comment->lead_id       = $estimate->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "paid";
                $comment->comment       = "Payment of Rs.". $request->amount ." is added by " . Auth::user()->name;
                $comment->save();
            }
        }
        $estimate->save();

        return redirect()->back()->with('success', 'Transaction saved successfully.');
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
        $transaction = Transaction::find($id)->delete();
        return redirect()->back()->with('success', 'Transaction saved successfully.');
    }
}
