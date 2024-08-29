<?php

namespace App\Http\Controllers\Sales\Invoice;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCancel;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\BookingCab;
use App\Models\Hotel;
use App\Models\BookingHotel;
use App\Models\BookingItem;
use App\Models\BookingSafari;
use App\Models\Term;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd(env('CUSTOMER_ID'));
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        })->get(['id', 'name']);

        $filter_name                = $request->filter_name;
        $filter_date                = $request->filter_date;
        $filter_time                = $request->filter_time;
        $filter_user                = $request->filter_user;
        $filter_type                = $request->filter_type;
        $filter_sanctuary           = $request->filter_sanctuary;
        $filter_estimate            = $request->filter_estimate;
        $filter_booking_status      = $request->filter_booking_status;

        $bookings = Booking::with('customer', 'user', 'safari', 'invoice', 'reason', 'credit');
        if (isset($filter_name)) {
            $bookings->whereHas('customer', function ($q) use ($filter_name) {
                $q->where(function ($q) use ($filter_name) {
                    $q->where('name', 'LIKE', '%' . $filter_name . '%');
                });
            });
        }
        $cancelBookingIds = BookingCancel::pluck('booking_id')->all();
        if ($filter_booking_status == 'cancel') {
            $bookings->whereIn('id', $cancelBookingIds);
        } else {
            $bookings->whereNotIn('id', $cancelBookingIds);
        }

        if (isset($filter_date)) {
            $bookings->whereDate('created_at', $filter_date);
        }

        if (isset($filter_user)) {
            $bookings->where('assigned_to', $filter_user);
        }
        if (isset($filter_type)) {
            $bookings->where('type', $filter_type);
        }
        if (isset($filter_estimate)) {
            $bookings->where('estimate_id', $filter_estimate);
        }
        if (isset($filter_sanctuary)) {
            $bookings->whereHas('safari', function ($q) use ($filter_sanctuary) {
                $q->where(function ($q) use ($filter_sanctuary) {
                    $q->where('sanctuary', 'LIKE', '%' . $filter_sanctuary . '%');
                });
            });
        }

        if (Auth::user()->hasAnyRole('administrator|team lead|agent')) {

            $bookings = $bookings->latest()->paginate(20);
        } elseif (Auth::user()->hasRole('fresher')) {

            $bookings = $bookings->latest()->paginate(20);
        } elseif (Auth::user()->hasRole('team-lead')) {

            $bookings = $bookings->whereIn('website',  Auth::user()->roles->pluck('name')->toArray())->latest()->paginate(150);
        } else {

            $bookings = $bookings->where('assigned_to', Auth::user()->id)->latest()->paginate(20);
        }

        return view('sales.invoices.list', compact('filter_name', 'filter_date', 'filter_time', 'filter_user', 'filter_type', 'filter_sanctuary', 'users', 'bookings', 'filter_booking_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mobile                 = session()->get('mobile');
        $customers              = Customer::get(['id', 'name', 'mobile']);
        if (isset($mobile)) {
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [];
        } else {
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('sales.invoices.create', compact('customers', 'customer_exists', 'customer'));
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

    public function show($id)
    {
        $booking                    = Booking::find($id)->load('customer', 'user', 'hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');
        //dd($booking);
        // $company                    = Company::where('default', 'yes')->first();
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/' . $company->logo) : '';
        $terms                      = Term::where('mode', 'invoice')->get();
        // $pdf                        = Pdf::loadView('sales.invoices.proforma-pdf', compact('booking','terms'));
        return view('sales.invoices.proforma', compact('booking', 'terms', 'company'));
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking  = Booking::find($id)->load('customer', 'user', 'hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');

        $terms    = Term::where('mode', 'invoice')->get();
        // $company  = Company::where('default', 'yes')->first();
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/' . $company->logo) : '';
        $pdf      = Pdf::loadView('sales.invoices.pdf-proforma', compact('booking', 'terms', 'company'));
        return $pdf->download('Proforma-invoice.pdf');
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

    // public function taxInvoice($id)
    // {

    //     $transaction = Transaction::with('customer','booking')->find($id);booking

    //     $terms                      = Term::where('mode', 'invoice')->get();

    //     // $company                    = Company::where('default', 'yes')->first();

    //     $invoice_exists             = Invoice::where('booking_id', $transaction->booking_id)->where('transaction_id', $id)->exists();

    //     if ($invoice_exists) {
    //     } else {
    //         $invoice                        = new Invoice();
    //         $invoice->booking_id            = $transaction->booking_id;
    //         $invoice->transaction_id        = $id;
    //         $invoice->date                  = date('Y-m-d');
    //         $invoice->save();
    //     }
    //     $booking                    = Booking::find($transaction->booking_id)->load('customer', 'user', 'hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');
    //     $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
    //     $company->path = isset($company->logo) ? asset('storage/uploads/company/' . $company->logo) : '';

    //     Booking::where('id', $transaction->booking_id)->update(['invoice_generated' => 'yes']);

    //     $transaction->invoice_generated = 'yes';
    //     $transaction->update();
    //     // $pdf                        = Pdf::loadView('sales.invoices.proforma-pdf', compact('booking','terms'));
    //     return view('sales.invoices.tax-invoice', compact('booking', 'transaction', 'terms', 'company'));
    // }

    public function DownloadInvoice($id)
    {

        $organizationId = env('organizationId');
        $accessToken = $this->createAccessToken();
        $transaction = Transaction::with('customer', 'booking')->find($id);

        // Check if the transaction is found and has a Zoho invoice ID
        if ($transaction && $transaction->zoho_invoice_id) {
            $invoiceId = $transaction->zoho_invoice_id;

            $response = Http::withHeaders([
                'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
            ])->get(
                "https://www.zohoapis.in/books/v3/invoices/print?organization_id={$organizationId}&invoice_ids={$invoiceId}"
            );
            $filename = 'zoho_invoice_' . $id . '.pdf';

            return Response::make($response->body(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        } else {

            return redirect()->route('invoices.index')->with('error', 'Invoice not found or Zoho invoice ID missing');
        }
    }

    public function printInvoice($id)
    {
        $organizationId = env('organizationId');
        $accessToken = $this->createAccessToken();
        $transaction = Transaction::with('customer', 'booking')->find($id);

        // Check if the transaction is found and has a Zoho invoice ID
        if ($transaction && $transaction->zoho_invoice_id) {
            $invoiceId = $transaction->zoho_invoice_id;

            $response = Http::withHeaders([
                'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
            ])->get(
                "https://www.zohoapis.in/books/v3/invoices/print?organization_id={$organizationId}&invoice_ids={$invoiceId}"
            );

            // Handle the response or perform any other logic
            //  dd(); // Replace this with your actual logic
            $filename = 'zoho_invoice_' . $id . '.pdf';
            //$path = storage_path($filename);

            return Response::make($response->body(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        } else {
            // Handle the case when the transaction or Zoho invoice ID is not found
            return redirect()->route('invoices.index')->with('error', 'Invoice not found or Zoho invoice ID missing');
        }
    }

    public function taxInvoice(Request $request, $id)
    {

        $transaction = Transaction::with('customer', 'booking')->find($id);

        $non_taxable = isset($request->inputValue) ? $request->inputValue : 0;
        $type = bookingType($transaction->booking_id);

        $booking_type = $transaction->booking->type;

        $desc = '';
        $check_status = false;

        $amount = $transaction->amount;

        if ($non_taxable > 0) {
            $amount  = $amount  - $non_taxable;
        }


        if ($booking_type == 'package' || $booking_type == 'tour') {
            $i = 1;
            $check_status = true;
        }
        if (in_array('cab', $type)) {
            $cab    = BookingCab::where('booking_id', $transaction->booking_id)->first();

            if ($check_status) {
                $desc .= "  " . $i . " . ";
                $i++;
            }
            $desc .= '(' . $cab->vehicle_type . ') ' . strip_tags(htmlspecialchars_decode($cab->note));
        }
        if (in_array('hotel', $type)) {
            $hotel = BookingHotel::with('hotel')->where('booking_id',  $transaction->booking_id)->first();

            if ($check_status) {
                $desc .= "\n " . "  " . $i . " . ";
                $i++;
            }
            $desc .= $hotel->hotel->name . ' (' . $hotel->hotel->city . ')';
        }
        if (in_array('safari', $type)) {
            $safari = BookingSafari::where('booking_id',  $transaction->booking_id)->first();

            $san = '';

            if ($safari->sanctuary == 'gir') {
                $san = 'Gir National Park';
            }
            if ($safari->sanctuary == 'jim') {
                $san = 'Jim Corbett National Park';
            }
            if ($safari->sanctuary == 'ranthambore') {
                $san = 'Ranthambore National Park';
            }
            if ($safari->sanctuary == 'tadoba') {
                $san = 'Tadoba National Park';
            }

            if ($check_status) {
                $desc .= "\n " . "  " . $i . " . ";;
                $i++;
            }
            $desc .= $san . ' (' . $safari->mode . ')';
        }

        $organizationId = env('organizationId ');
        $accessToken = $this->createAccessToken();
        $contact_id = $this->getContactId($id);

        $item_id = $this->getItemId($transaction->booking->type);

        $amount = $amount / (1 + 5 / 100);

        $items = array();
        if ($amount > 0) {
            array_push($items, [
                'item_id' =>  $item_id,
                'description' => $desc,
                'rate' => round($amount, 2),
            ]);
        }
        if ($non_taxable > 0) {
            array_push($items, [
                'item_id' =>  '1462652000000202049',
                'description' => 'Non-taxable permit cost.',
                'rate' => $non_taxable,
            ]);
        }
        // if (in_array('safari', $type)) {
        //     array_push($items, [
        //         'item_id' =>  '1462652000000185180',
        //         'rate' => '1000',


        //     ]);
        // }
        // dd($items);
        $response = Http::withHeaders([

            'Content-Type' => 'application/json',
            'Authorization' => 'Zoho-oauthtoken ' . $accessToken

        ])->post(
            'https://www.zohoapis.in/books/v3/invoices?organization_id=' . $organizationId,
            [
                'customer_id' => $contact_id,
                'line_items' =>  $items

            ]
        );
        // dd($responseBody = $response->object());
        if ($response->status() === 201) {
            $responseBody = $response->object();
            $transaction->invoice_generated = 'yes';
            $transaction->zoho_invoice_id = $responseBody->invoice->invoice_id;
            $transaction->update();
            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully');
        } else {
            return redirect()->route('invoices.index')->with('success', 'Invoice not created');
        }
    }


    public function getContactId($id)
    {

        $transaction = Transaction::with('customer', 'booking')->find($id);
        // $amount = $transaction->booking->items->sum('amount');
        //dd($transaction->customer->address);

        $company = $transaction->customer->company;

        $address = [
            'address' => $transaction->customer->address
        ];


        $customerState = $transaction->customer->state;
        $stateCode = $this->getState($customerState);
        $organizationId = env('organizationId ');
        $accessToken = $this->createAccessToken();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post(
            'https://www.zohoapis.in/books/v3/contacts?organization_id=' . $organizationId,
            [
                'contact_name' => $transaction->customer->name,
                'company_name' => $company,
                'contact_type' => 'customer',
                'place_of_contact' => $stateCode,
                'billing_address' => $address
            ]
        );
        //dd($response->object());
        if ($response->status() === 201) {
            $responseBody = $response->object();
            return $responseBody->contact->contact_id;
        } else {
            return false;
        }
    }

    public function getState($stateName)
    {
        $stateMappings = [
            'Andhra Pradesh' => 'AP',
            'Arunachal Pradesh' => 'AR',
            'Assam' => 'AS',
            'Bihar' => 'BR',
            'Chhattisgarh' => 'CG',
            'Goa' => 'GA',
            'Gujarat' => 'GJ',
            'Haryana' => 'HR',
            'Himachal Pradesh' => 'HP',
            'Jammu and Kashmir' => 'JK',
            'Jharkhand' => 'JH',
            'Karnataka' => 'KA',
            'Kerala' => 'KL',
            'Madhya Pradesh' => 'MP',
            'Maharashtra' => 'MH',
            'Manipur' => 'MN',
            'Meghalaya' => 'ML',
            'Mizoram' => 'MZ',
            'Nagaland' => 'NL',
            'Odisha' => 'OD', // Updated from 'OR' to 'OD'
            'Punjab' => 'PB',
            'Rajasthan' => 'RJ',
            'Sikkim' => 'SK',
            'Tamil Nadu' => 'TN',
            'Tripura' => 'TR',
            'Uttarakhand' => 'UK',
            'Uttar Pradesh' => 'UP',
            'West Bengal' => 'WB',
            'Andaman and Nicobar Islands' => 'AN',
            'Chandigarh' => 'CH',
            'Dadra and Nagar Haveli and Daman and Diu' => 'DN',
            'Delhi' => 'DL',
            'Lakshadweep' => 'LD',
            'Puducherry' => 'PY'
        ];

        $stateName = ucwords(strtolower($stateName));

        // Check if the state name exists in the map
        if (array_key_exists($stateName, $stateMappings)) {
            return $stateMappings[$stateName];
        } else {
            return 'Not Found'; // You can customize the default value for unknown states
        }
    }

    public function getItemId($type)
    {

        if ($type == "cab") {
            return env('cab_id');
        }
        if ($type == "safari") {
            return env('safari_id');
        }
        if ($type == "hotel") {
            return env('hotel_id');
        }
        if ($type == "tour") {
            return env('tour_id');
        }
        if ($type == "package") {
            return env('package_id');
        }
    }


    function createAccessToken()
    {
        // Set the environment variables
        $clientId = env('ZOHO_CLIENT_ID', '1000.6FGO9C41CCVG87O6EO2I1VFVTKPW2Y');
        $clientSecret = env('ZOHO_CLIENT_SECRET', '59a30bdd575f12be92db8fd1c309386405051ec374');
        $refreshToken = env('ZOHO_REFRESH_TOKEN', '1000.c001e19b1d70e5c1e64d20d8be4bc041.bc0a7650db8ca79287f0f2743e7aa2c5');
        $grantType = 'refresh_token';

        // Set the URL
        $url = 'https://accounts.zoho.in/oauth/v2/token';

        // Make a POST request to obtain the access token
        $response = Http::asForm()->post($url, [
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => $grantType,
        ]);

        // Decode the JSON response
        $data = $response->json();
        // Access the access token
        $accessToken = $data['access_token'];

        return $accessToken;
    }



    public function download($id)
    {
        $transaction = Transaction::find($id);
        $booking  = Booking::find($transaction->booking_id)->load('customer', 'user', 'hotel', 'cab', 'safari', 'items', 'customer_details', 'invoice');
        $terms    = Term::where('mode', 'invoice')->get();
        // $company  = Company::where('default', 'yes')->first();
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/' . $company->logo) : '';
        $pdf      = Pdf::loadView('sales.invoices.pdf-tax-invoice', compact('booking', 'terms', 'company', 'transaction'));
        return $pdf->download('Tax-invoice.pdf');
    }
}