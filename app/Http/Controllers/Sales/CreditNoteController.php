<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Company;
use App\Models\CreditNote;
use App\Models\Invoice;
use App\Models\Term;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CreditNoteController extends Controller
{
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
        return view('sales.credit-notes.credit-note', compact('booking', 'terms', 'company', 'transaction', 'invoice'));
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
