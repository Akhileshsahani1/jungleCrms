<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCancel;
use App\Models\Company;
use App\Models\CreditNote;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Term;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $bookings = Booking::where('customer_id', Auth::guard('customer')->user()->id)->with('customer', 'user', 'safari', 'invoice', 'reason', 'credit')->latest()->paginate(20);

        return view('front.invoices.list', compact('bookings'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking                    = Booking::find($id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');
        // $company                    = Company::where('default', 'yes')->first();
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        $terms                      = Term::where('mode', 'invoice')->get();
        // $pdf                        = Pdf::loadView('sales.invoices.proforma-pdf', compact('booking','terms'));
        return view('front.invoices.proforma', compact('booking', 'terms', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking  = Booking::find($id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');

        $terms    = Term::where('mode', 'invoice')->get();
        // $company  = Company::where('default', 'yes')->first();
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        $pdf      = Pdf::loadView('front.invoices.pdf-proforma', compact('booking','terms','company'));
        return $pdf->download('Proforma-invoice.pdf');
    }

    public function taxInvoice($id){

        $transaction = Transaction::find($id);

        $terms                      = Term::where('mode', 'invoice')->get();
        // $company                    = Company::where('default', 'yes')->first();

        $invoice_exists             = Invoice::where('booking_id', $transaction->booking_id)->where('transaction_id', $id)->exists();

        if($invoice_exists){


        }else{
            $invoice                        = new Invoice();
            $invoice->booking_id            = $transaction->booking_id;
            $invoice->transaction_id        = $id;
            $invoice->date                  = date('Y-m-d');
            $invoice->save();
        }
        $booking                    = Booking::find($transaction->booking_id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');
          $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        
        Booking::where('id', $transaction->booking_id)->update(['invoice_generated' => 'yes']);

        $transaction->invoice_generated = 'yes';
        $transaction->update();
        // $pdf                        = Pdf::loadView('sales.invoices.proforma-pdf', compact('booking','terms'));
        return view('front.invoices.tax-invoice', compact('booking', 'transaction', 'terms', 'company'));
    }

    public function download($id){
        $transaction = Transaction::find($id);
        $booking  = Booking::find($transaction->booking_id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');
        $terms    = Term::where('mode', 'invoice')->get();
        // $company  = Company::where('default', 'yes')->first();
         $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        $pdf      = Pdf::loadView('front.invoices.pdf-tax-invoice', compact('booking','terms', 'company', 'transaction'));
        return $pdf->download('Tax-invoice.pdf');
    }

    public function creditNote($id){

        $transaction = Transaction::find($id);

        $terms                      = Term::where('mode', 'invoice')->get();
        $company                    = Company::where('default', 'yes')->first();
        $note_exists                = CreditNote::where('booking_id', $transaction->booking_id)->where('transaction_id', $id)->exists();

        if($note_exists){


        }else{
            $note                        = new CreditNote();
            $note->booking_id            = $transaction->booking_id;
            $note->transaction_id        = $id;
            $note->date                  = date('Y-m-d');
            $note->save();
        }
        $booking                    = Booking::find($transaction->booking_id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');
        Booking::where('id', $transaction->booking_id)->update(['invoice_generated' => 'yes']);

        $transaction->credit_note_generated = 'yes';
        $transaction->update();
        $invoice                          = Invoice::where('booking_id', $transaction->booking_id)->where('transaction_id', $id)->first();
        return view('front.credit-notes.credit-note', compact('booking', 'terms', 'company', 'transaction', 'invoice'));
    }

    public function downloadCreditNote($id){
        $transaction = Transaction::find($id);
        $booking  = Booking::find($transaction->booking_id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice', 'invoices', 'credit');
        $terms    = Term::where('mode', 'invoice')->get();
        $company  = Company::where('default', 'yes')->first();
        $invoice                          = Invoice::where('booking_id', $transaction->booking_id)->where('transaction_id', $id)->first();
        $pdf      = Pdf::loadView('sales.credit-notes.credit-note-pdf', compact('booking','terms', 'company', 'transaction', 'invoice'));
        return $pdf->download('Credit-note.pdf');
    }
}
