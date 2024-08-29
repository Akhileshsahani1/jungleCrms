<?php

namespace App\Http\Controllers\Bookings\Cab;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCab;
use App\Models\BookingCabHalt;
use App\Models\BookingExclusion;
use App\Models\BookingInclusion;
use App\Models\BookingItem;
use App\Models\BookingTerm;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateCabOption;
use App\Models\EstimateExclusion;
use App\Models\EstimateInclusion;
use App\Models\EstimateTerm;
use App\Models\Exclusion;
use App\Models\Inclusion;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\Term;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabBookingController extends Controller
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
        $mobile                 = session()->get('mobile');      
        $inclusions             = Inclusion::where('type', 'cab')->get();
        $exclusions             = Exclusion::where('type', 'cab')->get();
        $terms                  = Term::where('mode', 'voucher')->where('type', 'cab')->get();
        $vendors                = Vendor::where('sanctuary', 'cab')->get();
        if(isset($mobile)){
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [] ;
        }else{
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('bookings.cab.create', compact('customer_exists', 'inclusions', 'exclusions', 'terms','customer', 'vendors'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        $inclusions         = Inclusion::where('type', 'cab')->get();
        $exclusions         = Exclusion::where('type', 'cab')->get();
        $terms              = Term::where('mode', 'voucher')->where('type', 'cab')->get();
        $vendors            = Vendor::where('sanctuary', 'cab')->get();
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [] ;
        return view('bookings.cab.convert', compact('lead', 'customer_exists', 'inclusions', 'exclusions', 'terms', 'customer', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $rules = [
            'customer_id'           => 'required',
            'trip_type'             => 'required',
            'vehicle_type'          => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
            'days'                  => 'required',
            'pick_up'               => 'required',
            'drop'                  => 'required',
            'pickup_time'           => 'required',
            'total_riders'          => 'required',
            'amount'                => 'required',
            'vendor_name'           => 'required',
            'vendor_mobile'         => 'required',
            'website'               => 'required',           
        ];


        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'trip_type.required'                => 'The Trip Type field can not be blank.',           
            'vehicle_type.required'             => 'Please select vehicle type',
            'start_date.required'               => 'Please enter journey start date.',
            'end_date.required'                 => 'Please enter journey end date.',
            'days.required'                     => 'Please enter no of days.',
            'pick_up.required'                  => 'Please enter Pickup point',
            'drop.required'                     => 'Please enter Drop point',
            'pickup_time.required'              => 'Please enter Pickup time',
            'total_riders.required'             => 'Please enter no of riders.',
            'amount.required'                   => 'Please enter Total Amount.',
            'vendor_name.required'              => 'Please enter vendor name.',
            'vendor_mobile.required'            => 'Please enter vendor mobile number.',
            'website.required'                  => 'Please select any Website',
        ];

        $this->validate($request, $rules, $messages);

        $website                       = $request->website;

        $booking                       = new Booking;
        $booking->type                 = 'cab';
        $booking->customer_id          = $request->customer_id;
        $booking->lead_id              = $request->has('lead_id') ? $request->lead_id : null;
        $booking->estimate_id          = $request->has('estimate_id') ? $request->estimate_id : null;
        $booking->assigned_to          = $request->has('lead_id') ? Lead::find($request->lead_id)->assigned_to : null;
        $booking->source               = $request->has('lead_id') ? 'converted' : 'custom';
        $booking->website              = $website;       
        $booking->date                 = date("Y-m-d");
        $booking->time                 = date("H:i:s");
        $booking->save();

        $cab                            = new BookingCab;
        $cab->booking_id                = $booking->id;
        $cab->trip_type                 = $request->trip_type;
        $cab->pickup_medium             = 'any';
        $cab->vehicle_type              = $request->vehicle_type;
        $cab->start_date                = Carbon::parse($request->start_date)->format('Y-m-d');
        $cab->end_date                  = Carbon::parse($request->end_date)->format('Y-m-d');
        $cab->days                      = $request->days;
        $cab->pick_up                   = $request->pick_up;
        $cab->drop                      = $request->drop;
        $cab->pickup_time               = $request->pickup_time;
        $cab->total_riders              = $request->total_riders;
        $cab->amount                    = $request->amount;
        $cab->no_of_cab                 = $request->no_of_cab;
        $cab->cab_due_amount            = $request->cab_due_amount;
        $cab->vendor_name               = $request->vendor_name;
        $cab->vendor_mobile             = $request->vendor_mobile;
        $cab->note                      = $request->note;
        $cab->save();

        $company_state                  = Company::where('default', 'yes')->value('state');
        $customr_state                  = Customer::find($request->customer_id)->state;

        if (!empty($request->halts) && is_array($request->halts)) {
            foreach ($request->halts as $key => $value) {
                $halt                  = new BookingCabHalt();
                $halt->booking_id      = $booking->id;
                $halt->booking_cab_id  = $cab->id;
                $halt->halt            = $value['halt'];
                $halt->start           = $value['start'];
                $halt->end             = $value['end'];
                $halt->save();
            }
        }

        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){
               $item                  = new BookingItem;
               $item->booking_id      = $booking->id;
               $item->particular      = $value['particular'];
               $item->amount          = $value['amount'];
               $item->rate            = $value['rate'];
               $item->gst             = $company_state == $customr_state ? 'SGST@CGST' : 'IGST';
               $item->save();
            }
        }        

        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new BookingInclusion;
                $inclusion->booking_id     = $booking->id;
                $inclusion->content         = $value['content'];
                $inclusion->save();
            }
        }

        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new BookingExclusion;
                $exclusion->booking_id      = $booking->id;
                $exclusion->content         = $value['content'];
                $exclusion->save();
            }
        }

        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new BookingTerm;
                $term->booking_id      = $booking->id;
                $term->content         = $value['content'];
                $term->save();
            }
        }
        

        if($request->has('lead_id')){
            $lead                       = Lead::find($request->lead_id);
            $lead->payment_status       = 'paid';
            $lead->lead_status          = 4;
            $lead->timestamps           = false;
            $lead->save();

                $comment                = new LeadComment();
                $comment->lead_id       = $request->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "booking generated";
                $comment->comment       = "Cab Booking has been generated by " . Auth::user()->name;
                $comment->save();
        }

        if($request->has('estimate_id')){
            Transaction::where('estimate_id', $request->estimate_id)->update(['booking_id' => $booking->id]);

            $payment_status = Estimate::find($request->estimate_id)->payment_status;
            Booking::where('id', $booking->id)->update(['payment_status' => $payment_status]);
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking generated',
            'comment' => 'A Cab Booking has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);
       

        return redirect()->route('bookings.index')->with('success', 'Cab Booking created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::find($id)->load('customer', 'user','cab', 'items');
        $booking_cab = BookingCab::where('booking_id',$id)->get()->toArray();
        return view('bookings.cab.show', compact('booking', 'booking_cab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $booking            = Booking::find($id)->load('cab', 'items');       
        $vendors            = Vendor::where('sanctuary', 'cab')->get();
        $customer_exists    = Customer::where('id', $booking->customer_id)->exists();
        $customer           = $customer_exists ? Customer::find($booking->customer_id) : [];
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();

        return view('bookings.cab.edit', compact('booking', 'vendors','customer_exists', 'customer','inclusions', 'exclusions', 'terms'));
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
        $rules = [
            'customer_id'           => 'required',
            'trip_type'             => 'required',
            'vehicle_type'          => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
            'days'                  => 'required',
            'pick_up'               => 'required',
            'drop'                  => 'required',
            'pickup_time'           => 'required',
            'total_riders'          => 'required',
            'amount'                => 'required',
             'website'              => 'required',            
        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'trip_type.required'                => 'The Trip Type field can not be blank.',           
            'vehicle_type.required'             => 'Please select vehicle type',
            'start_date.required'               => 'Please enter journey start date.',
            'end_date.required'                 => 'Please enter journey end date.',
            'days.required'                     => 'Please enter no of days.',
            'pick_up.required'                  => 'Please enter Pickup point',
            'drop.required'                     => 'Please enter Drop point',
            'pickup_time.required'              => 'Please enter Pickup time',
            'total_riders.required'             => 'Please enter no of riders.',
            'amount.required'                   => 'Please enter Total Amount.',
            'website.required'                  => 'Please enter Website',
        ];

        $this->validate($request, $rules, $messages);

        $booking                       = Booking::find($id);
        $booking->customer_id          = $request->customer_id;
        $booking->website              = $request->website;       
        $booking->save();

        $cab_booking_id                = BookingCab::where('booking_id', $id)->value('id');

        $cab                            = BookingCab::find($cab_booking_id);
        $cab->booking_id                = $booking->id;
        $cab->trip_type                 = $request->trip_type;
        $cab->pickup_medium             = 'any';
        $cab->vehicle_type              = $request->vehicle_type;
        $cab->start_date                = Carbon::parse($request->start_date)->format('Y-m-d');
        $cab->end_date                  = Carbon::parse($request->end_date)->format('Y-m-d');
        $cab->days                      = $request->days;
        $cab->pick_up                   = $request->pick_up;
        $cab->drop                      = $request->drop;
        $cab->pickup_time               = $request->pickup_time;
        $cab->total_riders              = $request->total_riders;
        $cab->amount                    = $request->amount;
        $cab->cab_due_amount            = $request->cab_due_amount;
        $cab->vendor_name               = $request->vendor_name;
        $cab->vendor_mobile             = $request->vendor_mobile;
        $cab->note                      = $request->note;
        $cab->save();

        BookingItem::where('booking_id', $id)->delete();
        $company_state                  = Company::where('default', 'yes')->value('state');
        $customr_state                  = Customer::find($request->customer_id)->state;
        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){

               $item                  = new BookingItem;
               $item->booking_id      = $booking->id;
               $item->particular      = $value['particular'];
               $item->amount          = $value['amount'];
               $item->rate            = $value['rate'];
               $item->gst             = $company_state == $customr_state ? 'SGST@CGST' : 'IGST';
               $item->save();

            }
        }

        BookingCabHalt::where('booking_id', $id)->delete();
        if (!empty($request->halts) && is_array($request->halts)) {
            foreach ($request->halts as $key => $value) {
                $halt                  = new BookingCabHalt();
                $halt->booking_id      = $booking->id;
                $halt->booking_cab_id  = $cab->id;
                $halt->halt            = $value['halt'];
                $halt->start           = $value['start'];
                $halt->end             = $value['end'];
                $halt->save();
            }
        }
        

        BookingInclusion::where('booking_id', $id)->delete();
        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new BookingInclusion;
                $inclusion->booking_id     = $booking->id;
                $inclusion->content         = $value['content'];
                $inclusion->save();
            }
        }

        BookingExclusion::where('booking_id', $id)->delete();
        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new BookingExclusion;
                $exclusion->booking_id      = $booking->id;
                $exclusion->content         = $value['content'];
                $exclusion->save();
            }
        }

        BookingTerm::where('booking_id', $id)->delete();
        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new BookingTerm;
                $term->booking_id      = $booking->id;
                $term->content         = $value['content'];
                $term->save();
            }
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking updated',
            'comment' => 'A Cab Booking has been updated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);

        return redirect()->route('bookings.index')->with('success', 'Cab Booking updated successfully');
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

    public function booking($id)
    {
        $booking                            = Estimate::find($id)->load('cab');
        $vendors                            = Vendor::where('sanctuary', 'cab')->get();
        $booking->items                     = [];
        $booking->option_selected           = EstimateCabOption::where('estimate_id', $id)->where('accepted', 'yes')->first();       
        $customer_exists                    = Customer::where('id', $booking->customer_id)->exists();
        $customer                           = $customer_exists ? Customer::find($booking->customer_id) : [];
        $inclusions                         = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions                         = EstimateExclusion::where('estimate_id', $id)->get();
        $terms                              = Term::where('mode', 'voucher')->where('type', 'cab')->get();

        return view('bookings.cab.estimate.booking', compact('booking', 'vendors', 'customer_exists', 'customer', 'id', 'inclusions', 'exclusions', 'terms'));
    }

    public function voucher($id){
        $inclusions                 = BookingInclusion::where('booking_id', $id)->get();
        $exclusions                 = BookingExclusion::where('booking_id', $id)->get();
        $terms                      = BookingTerm::where('booking_id', $id)->get();
        $booking                    = Booking::find($id)->load('customer', 'user','cab', 'items', 'customer_details');        
        $booking->voucher_generated = 'yes';
        $booking->save();

        if(isset($booking->lead_id)){
            $comment                = new LeadComment();
            $comment->lead_id       = $booking->lead_id;
            $comment->comment_by    = Auth::user()->id;
            $comment->type          = "voucher generated";
            $comment->comment       = "Cab Voucher has been generated by " . Auth::user()->name;
            $comment->save();
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'voucher generated',
            'comment' => 'A Cab Voucher has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);
               
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path              = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        // return view('bookings.cab.voucher', compact('booking','terms','company', 'inclusions', 'exclusions'));
        $pdf                        = Pdf::loadView('bookings.cab.voucher', compact('booking','terms','company', 'inclusions', 'exclusions'));        

        return $pdf->download('Cab-voucher.pdf');
    }
}
