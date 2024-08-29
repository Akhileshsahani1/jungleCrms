<?php

namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\Transaction;
use App\Models\RefundTransaction;
use App\Models\BookingCancellationRequest;
use App\Models\RefundHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingTransactionController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $filter_booking_status=$request->filter_booking_status;
        $booking = Booking::find($request->booking_id);
        $transactions = Transaction::where('booking_id', $booking->id)->latest()->get();
        $refund_transactions = RefundTransaction::where('booking_id', $booking->id)->latest()->get();
        $cancel_req = BookingCancellationRequest::where('booking_id', $booking->id)->where('approval_status', '1')->latest()->first();
        return view('bookings.transactions', compact('transactions','refund_transactions', 'booking','filter_booking_status','cancel_req'));
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
        $taxable_amount                = BookingItem::where('booking_id', $request->booking_id)->where('particular', 'Taxable amount')->value('amount');
        $permit_rate                   = $booking->items->sum('amount') - $taxable_amount;

        $transaction_exists            = Transaction::where('booking_id', $request->booking_id)->exists();
        if(!$transaction_exists ){
            if($request->amount <= $permit_rate){
                return redirect()->back()->with('error', 'Please enter amount greater than Permit Rate. Permit Rate for this booking is ₹'.$permit_rate.'');
            }
        }
        $transaction                   =  isset($request->id) ? Transaction::find($request->id)  : new Transaction;
        if(isset($booking->estimate_id)){
            $transaction->estimate_id = $booking->estimate_id;
        }
        $transaction->booking_id        = $request->booking_id;
        $transaction->customer_id       = $booking->customer_id;
        $transaction->date              = $request->date;
        $transaction->amount            = $request->amount;
        $transaction->mode              = $request->mode;
        $transaction->transaction_id    = $request->transaction_id;
        $transaction->save();
        $total_amount                   = $booking->items->sum('amount');
        $amount_paid                    = $booking->transactions->sum('amount');

        if ($total_amount > $amount_paid) {
            $booking->payment_status = 'partially paid';
            if($booking->lead_id){
                Lead::where('id', $booking->lead_id)->update(['payment_status' => 'partially paid']);
                $comment                = new LeadComment();
                $comment->lead_id       = $booking->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "partially paid";
                $comment->comment       = "Payment of Rs.". $request->amount ." is added by " . Auth::user()->name;
                $comment->save();
            }
        } else {
            $booking->payment_status = 'paid';
            if($booking->lead_id){
                Lead::where('id', $booking->lead_id)->update(['payment_status' => 'paid']);
                $comment                = new LeadComment();
                $comment->lead_id       = $booking->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "partially paid";
                $comment->comment       = "Payment of Rs.". $request->amount ." is added by " . Auth::user()->name;
                $comment->save();
            }
        }

        $booking->save();

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
        $booking_id = Transaction::find($id)->booking_id;
        $booking    = Booking::find($booking_id);

        $total_amount                   = $booking->items->sum('amount');
        $amount_paid                    = $booking->transactions->sum('amount');

        if ($total_amount > $amount_paid) {
            $booking->payment_status = 'partially paid';
        }elseif($total_amount == $total_amount){
            $booking->payment_status = 'paid';
        }else{
            $booking->payment_status = 'unpaid';
        }
        $booking->save();

        $transaction = Transaction::find($id)->delete();
        Invoice::where('transaction_id', $id)->delete();

        return redirect()->back()->with('success', 'Transaction saved successfully.');
    }
}
