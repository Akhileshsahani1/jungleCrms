<?php

namespace App\Exports;

use App\Models\BookingItem;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class GSTExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithEvents
{

    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14)->getColor()->setARGB('DD4B39');
            },
        ];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filter_month               = $this->data['filter_month'];
        $filter_name                = $this->data['filter_name'];
        $filter_mobile              = $this->data['filter_mobile'];
        $filter_date_from           = $this->data['filter_date_from'];
        $filter_date_to             = $this->data['filter_date_to'];

        $invoices                   = Invoice::with('booking', 'booking.customer');

        if(isset($filter_month)){
            $invoices->whereMonth('date', $filter_month);
        }

        if ($filter_date_from && $filter_date_to) {

            $from   = date("Y-m-d", strtotime($filter_date_from));
            $to     = date('Y-m-d', strtotime($filter_date_to));
            $invoices->whereBetween('date', [$from, $to])->get();
        }

        if ($filter_date_from) {
            $from   = date("Y-m-d", strtotime($filter_date_from));
            $invoices->whereDate('date', '>=', $from)->get();
        }

        if ($filter_date_to) {
            $to     = date('Y-m-d', strtotime($filter_date_to));
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
        $company_state              = Company::where('default', 'yes')->value('state');

        $excel_array = [];
        foreach($invoices as $key => $invoice){
            $total_amount               = $invoice->transaction->amount;
            $amount_taxable             = checkFirstTransaction($invoice->booking_id, $invoice->transaction_id) ? $total_amount - getNonTaxableAmount($invoice->booking_id) : $total_amount;
            $non_taxable_amount         = checkFirstTransaction($invoice->booking_id, $invoice->transaction_id) ? getNonTaxableAmount($invoice->booking_id) : 0;
            $service_amount             = $total_amount - $non_taxable_amount;
            $rate                       = BookingItem::where('booking_id', $invoice->booking_id)->where('particular', 'Taxable amount')->value('rate');
            $igst                       = $amount_taxable - $amount_taxable * (100 / (100 + 5));
            $cgst                       = $igst / 2;
            $sgst                       = $igst / 2;
            $excel_array[$key]['Date']                  = Carbon::parse($invoice->date)->format('d.m.Y');
            $excel_array[$key]['Invoice No.']           = 10000 + $invoice->id;
            $excel_array[$key]['State']                 = $invoice->booking->customer->state;
            $excel_array[$key]['Company']               = $invoice->booking->customer->company;
            $excel_array[$key]['GST No']                = $invoice->booking->customer->gstin;
            $excel_array[$key]['HSN/SAC CODE']          = 9985;
            $excel_array[$key]['Taxable Amount']        = $amount_taxable;
            $excel_array[$key]['Rate of Tax']           = $rate ? $rate : '0';
            $excel_array[$key]['Output(IGST)']          = $company_state == $invoice->booking->customer->state ? '0' : round($igst, 2);
            $excel_array[$key]['Output(CGST)']          = $company_state == $invoice->booking->customer->state ? round($cgst, 2) : '0';
            $excel_array[$key]['Output(SGST)']          = $company_state == $invoice->booking->customer->state ? round($sgst, 2) : '0';
            $excel_array[$key]['Non-Taxable (Permit)']  = $non_taxable_amount;
            $excel_array[$key]['Refund Amount']         = $invoice->transaction->credit_note_generated == 'yes' ? $total_amount : '0';
            $excel_array[$key]['Total Amount']          = $total_amount;
        }
        return collect($excel_array);
    }

    public function title(): string
    {
        return 'GST';
    }

    public function headings(): array
    {
        return ['Date', 'Invoice No.', 'State', 'Company Name', 'GST No.', 'HSN/SAC CODE', 'Taxable Amount', 'Rate of Tax', 'Output(IGST)', 'Output(CGST)', 'Output(SGST)', 'Non-Taxable (Permit)', 'Refund Amount', 'Total Amount'];
    }

}
