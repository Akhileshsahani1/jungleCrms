<?php

namespace App\Http\Controllers\Sales\Report;

use App\Exports\GSTExport;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Term;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $proforma_invoices_count    = Booking::count();
        $tax_invoices_count         = Invoice::count();

        $filter_month               = $request->filter_month;
        $filter_name                = $request->filter_name;
        $filter_mobile              = $request->filter_mobile;
        $filter_date_from           = $request->filter_date_from;
        $filter_date_to             = $request->filter_date_to;

        $invoices                   = Invoice::with('booking', 'booking.customer');

        if(isset($filter_month)){
            $invoices->whereMonth('date', $filter_month);
        }

        if ($request->filter_date_from && $request->filter_date_to) {

            $from   = date("Y-m-d", strtotime($request->input('filter_date_from')));
            $to     = date('Y-m-d', strtotime($request->input('filter_date_to')));
            $invoices->whereBetween('date', [$from, $to])->get();
        }

        if ($request->filter_date_from) {
            $from   = date("Y-m-d", strtotime($request->input('filter_date_from')));
            $invoices->whereDate('date', '>=', $from)->get();
        }

        if ($request->filter_date_to) {
            $to     = date('Y-m-d', strtotime($request->input('filter_date_to')));
            $invoices->whereDate('date', '<=', $to)->get();
        }

        if(isset($filter_name)) {
            $invoices->whereHas('booking.customer', function($q) use ($filter_name) {
                $q->where(function($q) use ($filter_name) {
                    $q->where('name', 'LIKE', '%' . $filter_name . '%');
                });
            });

        }

        if(isset($filter_mobile)) {
            $invoices->whereHas('booking.customer', function($q) use ($filter_mobile) {
                $q->where(function($q) use ($filter_mobile) {
                    $q->where('mobile', 'LIKE', '%' . $filter_mobile . '%');
                });
            });

        }

        $invoices                   = $invoices->latest()->get();

        return view('sales.reports.index', compact('proforma_invoices_count', 'tax_invoices_count', 'filter_month', 'filter_name', 'filter_mobile', 'filter_date_from', 'filter_date_to', 'invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $proforma_invoices_count    = Booking::count();
        $tax_invoices_count         = Invoice::count();

        $filter_month               = $request->filter_month;
        $filter_name                = $request->filter_name;
        $filter_mobile              = $request->filter_mobile;
        $filter_date_from           = $request->filter_date_from;
        $filter_date_to             = $request->filter_date_to;

        $invoices                   = Invoice::with('booking', 'booking.customer');

        if(isset($filter_month)){
            $invoices->whereMonth('date', $filter_month);
        }

        if ($request->filter_date_from && $request->filter_date_to) {

            $from   = date("Y-m-d", strtotime($request->input('filter_date_from')));
            $to     = date('Y-m-d', strtotime($request->input('filter_date_to')));
            $invoices->whereBetween('date', [$from, $to])->get();
        }

        if ($request->filter_date_from) {
            $from   = date("Y-m-d", strtotime($request->input('filter_date_from')));
            $invoices->whereDate('date', '>=', $from)->get();
        }

        if ($request->filter_date_to) {
            $to     = date('Y-m-d', strtotime($request->input('filter_date_to')));
            $invoices->whereDate('date', '<=', $to)->get();
        }

        if(isset($filter_name)) {
            $invoices->whereHas('booking.customer', function($q) use ($filter_name) {
                $q->where(function($q) use ($filter_name) {
                    $q->where('name', 'LIKE', '%' . $filter_name . '%');
                });
            });

        }

        if(isset($filter_mobile)) {
            $invoices->whereHas('booking.customer', function($q) use ($filter_mobile) {
                $q->where(function($q) use ($filter_mobile) {
                    $q->where('mobile', 'LIKE', '%' . $filter_mobile . '%');
                });
            });

        }

        $invoices                   = $invoices->latest()->get();
        if(count($invoices) > 0){
            $zip                        = new ZipArchive;

        if (true === ($zip->open(public_path('storage/uploads/invoices.zip'), ZipArchive::CREATE | ZipArchive::OVERWRITE))) {
            foreach($invoices as $invoice){
                    $booking  = Booking::find($invoice->booking_id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');
                    $terms    = Term::where('mode', 'invoice')->get();
                    $pdf      = Pdf::loadView('sales.invoices.pdf-tax-invoice', compact('booking','terms'));
                    Storage::put('public/uploads/invoices/'.$invoice->id.'.pdf', $pdf->output());

                    $zip->addFile(public_path('storage/uploads/invoices/'. $invoice->id.'.pdf'), $invoice->id.'.pdf');

            }
            $zip->close();
        }

        return response()->download(public_path('storage/uploads/invoices.zip'), 'invoices.zip');

        }else{

            return redirect()->back()->with('error', 'No Invoice Found...');
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = $request->all();
		return Excel::download(new GSTExport($data), 'gst.xlsx');

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
