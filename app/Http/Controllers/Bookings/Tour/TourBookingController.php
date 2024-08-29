<?php

namespace App\Http\Controllers\Bookings\Tour;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCab;
use App\Models\BookingCabHalt;
use App\Models\BookingExclusion;
use App\Models\BookingHotel;
use App\Models\BookingInclusion;
use App\Models\BookingItem;
use App\Models\BookingSafari;
use App\Models\BookingSafariCustomer;
use App\Models\BookingTerm;
use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateExclusion;
use App\Models\EstimateHotelOption;
use App\Models\EstimateInclusion;
use App\Models\EstimateTerm;
use App\Models\Exclusion;
use App\Models\Hotel;
use App\Models\Inclusion;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\State;
use App\Models\Term;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use PDFMerger;
use ZipArchive;

class TourBookingController extends Controller
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
        $hotels                 = Hotel::get(['id', 'name']);
        $states                 = State::get(['id', 'state']);
        $vendors                = Vendor::all();
        $booking_type           = [];
        if(isset($mobile)){
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [] ;
        }else{
            $customer_exists    = false;
            $customer           = [];
        }
        $inclusions             = Inclusion::where('type', 'tour')->get();
        $exclusions             = Exclusion::where('type', 'tour')->get();     
        $cab_vendors            = Vendor::where('sanctuary', 'cab')->get();  
        $terms                  = Term::where('type', 'tour')->get();
        session()->forget('mobile');
        return view('bookings.tour.create', compact('customer_exists', 'customer', 'hotels', 'states', 'booking_type', 'vendors', 'inclusions', 'exclusions', 'terms', 'cab_vendors'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        $vendors            = Vendor::all();
        $cab_vendors         = Vendor::where('sanctuary', 'cab')->get();
        $hotels             = Hotel::get(['id', 'name']);
        $states             = State::get(['id', 'state']);
        $booking_type       = [];
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [] ;
        $inclusions         = Inclusion::where('type', 'tour')->get();
        $exclusions         = Exclusion::where('type', 'tour')->get();       
        $terms              = [];
        return view('bookings.tour.convert', compact('lead', 'customer_exists', 'customer', 'hotels', 'states', 'booking_type', 'vendors', 'inclusions', 'exclusions', 'terms', 'cab_vendors'));
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
            'booking_type'          => 'required|array|min:1',
            'amount'                => 'required',
            'trip_type'             =>  in_array('cab', $request->booking_type) ? 'required' : '',           
            'cab_type'              =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'start_date'            =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'end_date'              =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'days'                  =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'pick_up'               =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'drop'                  =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'pickup_time'           =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'vendor_name'           =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'vendor_mobile'         =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'total_riders'          =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'adults'                =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'childs'                =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'room'                  =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'bed'                   =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'check_in'              =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'check_out'             =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'destination'           =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'hotel'                 =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'hotel_room'            =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'service'               =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'sanctuary'             =>  in_array('safari', $request->booking_type) ? 'required' : '',
            'website'               => 'required',            


        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'booking_type.required'             => 'Please select estimate type from list',
            'amount.required'                   => 'Please enter Total Amount',
            'trip_type.required'                => 'The Trip Type field can not be blank.',
            'cab_type.required'                 => 'Please select vehicle type',
            'start_date.required'               => 'Please enter journey start date.',
            'end_date.required'                 => 'Please enter journey end date.',
            'days.required'                     => 'Please enter no of days.',
            'pick_up.required'                  => 'Please enter Pickup point',
            'drop.required'                     => 'Please enter Drop point',
            'pickup_time.required'              => 'Please enter Pickup time',
            'vendor_name.required'              => 'Please enter Vendor Name.',
            'vendor_mobile.required'            => 'Please enter Vendor mobile.',
            'total_riders.required'             => 'Please enter no of riders.',
            'adults.required'                   => 'Please enter No of Adults.',
            'childs.required'                   => 'Please enter No of Children.',
            'room.required'                     => 'Please enter No of Rooms.',
            'bed.required'                      => 'Please enter No of Beds.',
            'check_in.required'                 => 'Please enter Check In date.',
            'check_out.required'                => 'Please enter Check Out date.',
            'hotel.required'                    => 'Please select Hotel.',
            'hotel_room.required'               => 'Please select Hotel Room.',
            'service.required'                  => 'Please select Service.',
            'destination.required'              => 'Please enter Destination.',
            'sanctuary.required'                => 'Please select Sanctuary.',
            'website.required'                  => 'Please enter Website',

        ];

        $this->validate($request, $rules, $messages);


        $website = $request->website;

        switch ($request->sanctuary) {
            case 'gir':
               $website = 'girlionsafari.com';
                break;
            case 'jim':
                $website = 'jimcorbett.in';
                break;
            case 'ranthambore':
                $website = 'ranthamboretigerreserve.in';
                break;
            case 'tadoba':
                $website = 'tadobapark.com';
                break;

        }

        $booking                       = new Booking;
        $booking->type                 = 'tour';
        $booking->customer_id          = $request->customer_id;
        $booking->lead_id              = $request->has('lead_id') ? $request->lead_id : null;
        $booking->estimate_id          = $request->has('estimate_id') ? $request->estimate_id : null;
        $booking->assigned_to          = $request->has('lead_id') ? Lead::find($request->lead_id)->assigned_to : null;
        $booking->source               = $request->has('lead_id') ? 'converted' : 'custom';
        $booking->website              = $website;       
        $booking->date                 = date("Y-m-d");
        $booking->time                 = date("H:i:s");
        $booking->save();

        if ($request->hasfile('image')) {
            $image              = $request->file('image');
            $name               = $image->getClientOriginalName();
            $image->storeAs('uploads/bookings/customers/'.$booking->id, $name, 'public');

            Booking::find($booking->id)->update(['image' => $name]);
        }

        if (in_array('cab', $request->booking_type)) {

            $cab = new BookingCab;
            $cab->booking_id                = $booking->id;
            $cab->trip_type                 = $request->trip_type;
            $cab->pickup_medium             = 'any';
            $cab->vehicle_type              = $request->cab_type;
            $cab->start_date                = Carbon::parse($request->start_date)->format('Y-m-d');
            $cab->end_date                  = Carbon::parse($request->end_date)->format('Y-m-d');
            $cab->days                      = $request->days;
            $cab->pick_up                   = $request->pick_up;
            $cab->drop                      = $request->drop;
            $cab->pickup_time               = $request->pickup_time;
            $cab->total_riders              = $request->total_riders;
            $cab->note                      = $request->cab_note;
            $cab->amount                    = $request->amount;
            $cab->vendor_name               = $request->vendor_name;
            $cab->vendor_mobile             = $request->vendor_mobile;
            $cab->cab_due_amount           = $request->cab_due_amount;
            $cab->no_of_cab           = $request->no_of_cab;
            $cab->save();

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

        }


        if (in_array('hotel', $request->booking_type)) {

            $hotel                            = new BookingHotel;
            $hotel->booking_id                = $booking->id;
            $hotel->adult                     = $request->adults;
            $hotel->child                     = $request->childs;
            $hotel->room                      = $request->room;
            $hotel->bed                       = $request->bed;
            $hotel->check_in                  = Carbon::parse($request->check_in)->format('Y-m-d');
            $hotel->check_out                 = Carbon::parse($request->check_out)->format('Y-m-d');
            $hotel->destination               = $request->destination;
            $hotel->hotel_id                  = $request->hotel;
            $hotel->room_id                   = $request->hotel_room;
            $hotel->service_id                = $request->service;
            $hotel->amount                    = $request->amount;
            $hotel->note                      = $request->hotel_note;
            $hotel->hotel_due_amount         = $request->hotel_due_amount;
            $hotel->save();

        }



        if (in_array('safari', $request->booking_type)) {

            if (!empty($request->safari) && is_array($request->safari)) {
                foreach ($request->safari as $key => $value) {
                    $safari                            = new BookingSafari;
                    $safari->booking_id                = $booking->id;
                    $safari->sanctuary                 = $request->sanctuary;
                    $safari->mode                      = $value['mode'];
                    $safari->area                      = array_key_exists('area', $value) ? $value['area'] : null;
                    $safari->zone                      = array_key_exists('zone', $value) ? $value['zone'] : null;
                    $safari->adult                     = array_key_exists('adult', $value) ? $value['adult'] : null;
                    $safari->child                     = array_key_exists('child', $value) ? $value['child'] : null;
                    $safari->total_person              = array_key_exists('total_person', $value)  ?  $value['total_person'] : $value['adult'] + $value['child'];
                    $safari->vehicle_type              = array_key_exists('vehicle_type', $value) ? $value['vehicle_type'] : null;
                    $safari->date                      = Carbon::parse($value['date'])->format('Y-m-d');
                    $safari->time                      = $value['time'];
                    $safari->nationality               = $value['nationality'];
                    $safari->note                      = $value['note'];
                    $safari->jeeps                     = $value['jeeps'];
                    $safari->vendor                    = $value['vendor'];
                    $safari->safari_due_amount         = $value['safari_due_amount'];
                    $safari->amount                    = $request->amount;
                    $safari->type                      = array_key_exists('type', $value) ? $value['type'] : null;
                    $safari->save();
                }
            }

            if (!empty($request->customer) && is_array($request->customer)) {
                foreach ($request->customer as $key => $value) {

                    $option                         = new BookingSafariCustomer;
                    $option->booking_id             = $booking->id;
                    $option->name                   = $value['name'];
                    $option->age                    = $value['age'];
                    $option->gender                 = $value['gender'];
                    $option->nationality            = $value['nationality'];
                    $option->state                  = $value['state'];
                    $option->idproof                = $value['idproof'];
                    $option->idproof_no             = $value['idproof_no'];
                    $option->save();
                }
            }

        }
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
                $comment->comment       = "Tour Booking has been generated by " . Auth::user()->name;
                $comment->save();
        }
        if($request->has('estimate_id')){
            Transaction::where('estimate_id', $request->estimate_id)->update(['booking_id' => $booking->id]);

            $payment_status = Estimate::find($request->estimate_id)->payment_status;
            Booking::where('id', $booking->id)->update(['payment_status' => $payment_status]);
        }

        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new BookingInclusion();
                $inclusion->booking_id     = $booking->id;
                $inclusion->content         = $value['content'];
                $inclusion->save();
            }
        }
       
        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new BookingExclusion();
                $exclusion->booking_id      = $booking->id;
                $exclusion->content         = $value['content'];
                $exclusion->save();
            }
        }

        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new BookingTerm();
                $term->booking_id      = $booking->id;
                $term->content         = $value['content'];
                $term->save();
            }
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking generated',
            'comment' => 'A Tour Booking has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);


        return redirect()->route('bookings.index')->with('success', 'Tour Booking created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::find($id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details');
        $hotel  = Hotel::find($booking->hotel->hotel_id);
        $hotel->load('images', 'rooms', 'rooms.services');
        foreach ($hotel->images as $image) {
            $image->path = asset('storage/uploads/hotels/' . $hotel->id . '/' . $image->image);
        }
        $booking_type = bookingType($id);
        return view('bookings.tour.show', compact('booking', 'hotel', 'booking_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking            = Booking::find($id)->load('hotel', 'cab', 'safari', 'items', 'customer_details');
        $states             = State::get(['id', 'state']);
        $countries          = Country::get(['country']);
        $hotels             = Hotel::get(['id', 'name']);
        $vendors            = Vendor::all();
        $customer_exists    = Customer::where('id', $booking->customer_id)->exists();
        $customer           = $customer_exists ? Customer::find($booking->customer_id) : [];
        $booking_type       = bookingType($id);
        $cab_vendors         = Vendor::where('sanctuary', 'cab')->get();
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();

        return view('bookings.tour.edit', compact('booking', 'customer_exists', 'customer', 'states', 'countries', 'hotels', 'vendors', 'booking_type', 'inclusions', 'exclusions', 'terms', 'cab_vendors'));
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
            'booking_type'          => 'required|array|min:1',
            'amount'                => 'required',
            'trip_type'             =>  in_array('cab', $request->booking_type) ? 'required' : '',         
            'cab_type'              =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'start_date'            =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'end_date'              =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'days'                  =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'pick_up'               =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'drop'                  =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'pickup_time'           =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'total_riders'          =>  in_array('cab', $request->booking_type) ? 'required' : '',
            'adults'                =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'childs'                =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'room'                  =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'bed'                   =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'check_in'              =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'check_out'             =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'destination'           =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'hotel'                 =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'hotel_room'            =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'service'               =>  in_array('hotel', $request->booking_type) ? 'required' : '',
            'sanctuary'             =>  in_array('safari', $request->booking_type) ? 'required' : '',
            'website'               => 'required',            

        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'booking_type.required'             => 'Please select estimate type from list',
            'amount.required'                   => 'Please enter Total Amount',
            'trip_type.required'                => 'The Trip Type field can not be blank.',
            'cab_type.required'                 => 'Please select vehicle type',
            'start_date.required'               => 'Please enter journey start date.',
            'end_date.required'                 => 'Please enter journey end date.',
            'days.required'                     => 'Please enter no of days.',
            'pick_up.required'                  => 'Please enter Pickup point',
            'drop.required'                     => 'Please enter Drop point',
            'pickup_time.required'              => 'Please enter Pickup time',
            'total_riders.required'             => 'Please enter no of riders.',
            'adults.required'                   => 'Please enter No of Adults.',
            'childs.required'                   => 'Please enter No of Children.',
            'room.required'                     => 'Please enter No of Rooms.',
            'bed.required'                      => 'Please enter No of Beds.',
            'check_in.required'                 => 'Please enter Check In date.',
            'check_out.required'                => 'Please enter Check Out date.',
            'hotel.required'                    => 'Please select Hotel.',
            'hotel_room.required'               => 'Please select Hotel Room.',
            'service.required'                  => 'Please select Service.',
            'destination.required'              => 'Please enter Destination.',
            'sanctuary.required'                => 'Please select Sanctuary.',
            'website.required'          => 'Please enter Website',
        ];

        $this->validate($request, $rules, $messages);

        $website = $request->website;

        switch ($request->sanctuary) {
            case 'gir':
               $website = 'girlionsafari.com';
                break;
            case 'jim':
                $website = 'jimcorbett.in';
                break;
            case 'ranthambore':
                $website = 'ranthamboretigerreserve.in';
                break;
            case 'tadoba':
                $website = 'tadobapark.com';
                break;

        }

        $booking                       = Booking ::find($id);
        $booking->customer_id          = $request->customer_id;
        $booking->website              = $website;        
        $booking->save();

        if ($request->hasfile('image')) {
            $image              = $request->file('image');
            $name               = $image->getClientOriginalName();
            $image->storeAs('uploads/bookings/customers/'.$id, $name, 'public');

            Booking::find($id)->update(['image' => $name]);
        }

        $cab_booking_exists    = BookingCab::where('booking_id', $id)->exists();

        if ($cab_booking_exists) {
            $cab_booking_id = BookingCab::where('booking_id', $id)->value('id');
        }

        if (!in_array('cab', $request->booking_type) && $cab_booking_exists) {
            BookingCab::where('booking_id', $id)->delete();
        }

        if (in_array('cab', $request->booking_type)) {

            $cab                            = $cab_booking_exists ? BookingCab::find($cab_booking_id) : new BookingCab;
            $cab->booking_id                = $booking->id;
            $cab->trip_type                 = $request->trip_type;
            $cab->pickup_medium             = 'any';
            $cab->vehicle_type              = $request->cab_type;
            $cab->start_date                = Carbon::parse($request->start_date)->format('Y-m-d');
            $cab->end_date                  = Carbon::parse($request->end_date)->format('Y-m-d');
            $cab->days                      = $request->days;
            $cab->pick_up                   = $request->pick_up;
            $cab->drop                      = $request->drop;
            $cab->pickup_time               = $request->pickup_time;
            $cab->total_riders              = $request->total_riders;
            $cab->amount                    = $request->amount;
            $cab->vendor_name               = $request->vendor_name;
            $cab->vendor_mobile             = $request->vendor_mobile;
            $cab->cab_due_amount            = $request->cab_due_amount;
            $cab->note                      = $request->cab_note;
            $cab->save();

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

        }


        $hotel_booking_exists  = BookingHotel::where('booking_id', $id)->exists();

        if ($hotel_booking_exists) {
            $hotel_booking_id = BookingHotel::where('booking_id', $id)->value('id');
        }

        if (!in_array('hotel', $request->booking_type) && $hotel_booking_exists) {
            BookingHotel::where('booking_id', $id)->delete();
        }

        if (in_array('hotel', $request->booking_type)) {

            $hotel                            = $hotel_booking_exists ? BookingHotel::find($hotel_booking_id) : new BookingHotel;
            $hotel->booking_id                = $booking->id;
            $hotel->adult                     = $request->adults;
            $hotel->child                     = $request->childs;
            $hotel->room                      = $request->room;
            $hotel->bed                       = $request->bed;
            $hotel->check_in                  = Carbon::parse($request->check_in)->format('Y-m-d');
            $hotel->check_out                 = Carbon::parse($request->check_out)->format('Y-m-d');
            $hotel->destination               = $request->destination;
            $hotel->hotel_id                  = $request->hotel;
            $hotel->room_id                   = $request->hotel_room;
            $hotel->service_id                = $request->service;
            $hotel->amount                    = $request->amount;
            $hotel->hotel_due_amount          = $request->hotel_due_amount;
            $hotel->note                      = $request->hotel_note;
            $hotel->save();

        }


        $safari_booking_exists = BookingSafari::where('booking_id', $id)->exists();
        if ($safari_booking_exists) {
            $safari_booking_id = BookingSafari::where('booking_id', $id)->value('id');
        }

        if (!in_array('safari', $request->booking_type) && $safari_booking_exists) {
            BookingSafari::where('booking_id', $id)->delete();
            BookingSafariCustomer::where('booking_id', $id)->delete();
        }

        if (in_array('safari', $request->booking_type)) {

            BookingSafari::where('booking_id', $id)->delete();
            if (!empty($request->safari) && is_array($request->safari)) {
                foreach ($request->safari as $key => $value) {
                    $safari                            = new BookingSafari;
                    $safari->booking_id                = $booking->id;
                    $safari->sanctuary                 = $request->sanctuary;
                    $safari->mode                      = $value['mode'];
                    $safari->area                      = array_key_exists('area', $value) ? $value['area'] : null;
                    $safari->zone                      = array_key_exists('zone', $value) ? $value['zone'] : null;
                    $safari->adult                     = array_key_exists('adult', $value) ? $value['adult'] : null;
                    $safari->child                     = array_key_exists('child', $value) ? $value['child'] : null;
                    $safari->total_person              = array_key_exists('total_person', $value)  ?  $value['total_person'] : $value['adult'] + $value['child'];
                    $safari->vehicle_type              = array_key_exists('vehicle_type', $value) ? $value['vehicle_type'] : null;
                    $safari->date                      = Carbon::parse($value['date'])->format('Y-m-d');
                    $safari->time                      = $value['time'];
                    $safari->nationality               = $value['nationality'];
                    $safari->note                      = $value['note'];
                    $safari->jeeps                     = $value['jeeps'];
                    $safari->vendor                    = $value['vendor'];
                    $safari->safari_due_amount         = $value['safari_due_amount'];
                    $safari->type                      = array_key_exists('type', $value) ? $value['type'] : null;
                    $safari->amount                    = $request->amount;
                    $safari->save();
                }
            }

            BookingSafariCustomer::where('booking_id', $id)->delete();
            if (!empty($request->customer) && is_array($request->customer)) {
                foreach ($request->customer as $key => $value) {

                    $option                         = new BookingSafariCustomer;
                    $option->booking_id             = $booking->id;
                    $option->name                   = $value['name'];
                    $option->age                    = $value['age'];
                    $option->gender                 = $value['gender'];
                    $option->nationality            = $value['nationality'];
                    $option->state                  = $value['state'];
                    $option->idproof                = $value['idproof'];
                    $option->idproof_no             = $value['idproof_no'];
                    $option->save();
                }
            }
        }


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

        BookingInclusion::where('booking_id', $id)->delete();
        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new BookingInclusion();
                $inclusion->booking_id     = $booking->id;
                $inclusion->content         = $value['content'];
                $inclusion->save();
            }
        }

        BookingExclusion::where('booking_id', $id)->delete();
        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new BookingExclusion();
                $exclusion->booking_id      = $booking->id;
                $exclusion->content         = $value['content'];
                $exclusion->save();
            }
        }

        BookingTerm::where('booking_id', $id)->delete();
        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new BookingTerm();
                $term->booking_id      = $booking->id;
                $term->content         = $value['content'];
                $term->save();
            }
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking updated',
            'comment' => 'A Tour Booking has been updated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);

        return redirect()->route('bookings.index')->with('success', 'Tour Booking updated successfully');
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
        $booking                    = Estimate::find($id)->load('cab', 'hotel', 'safari');
        $booking->items             = [];
        $booking->customer_details  = [];
        $booking->option_selected   = EstimateHotelOption::where('estimate_id', $id)->where('accepted', 'yes')->first();
        $states                     = State::get(['id', 'state']);
        $hotels                     = Hotel::get(['id', 'name']);
        $vendors                    = Vendor::all();
        $cab_vendors                = Vendor::where('sanctuary', 'cab')->get();
        $customer_exists            = Customer::where('id', $booking->customer_id)->exists();
        $customer                   = $customer_exists ? Customer::find($booking->customer_id) : [];
        $booking_type               = estimateType($id);
        if(in_array('safari', $booking_type)){
            $booking->safari->jeeps     = null;
        }
        $inclusions                 = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions                 = EstimateExclusion::where('estimate_id', $id)->get();
        $terms                      = Term::where('mode', 'voucher')->where('type', 'tour')->where('filter', $booking->safari->sanctuary)->get();


        return view('bookings.tour.estimate.booking', compact('booking', 'states', 'hotels', 'vendors', 'customer_exists', 'customer', 'booking_type', 'id', 'inclusions', 'exclusions', 'terms', 'cab_vendors'));
    }

    public function voucher($id){
        $oMerger = PDFMerger::init();

        $booking_type = bookingType($id);

        $booking                    = Booking::find($id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details');
        $booking->voucher_generated = 'yes';
        $booking->save();

        if(isset($booking->lead_id)){
            $comment                = new LeadComment();
            $comment->lead_id       = $booking->lead_id;
            $comment->comment_by    = Auth::user()->id;
            $comment->type          = "voucher generated";
            $comment->comment       = "Tour Vouchers has been generated by " . Auth::user()->name;
            $comment->save();
        }

        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();
        // cab-booking
        if (in_array("cab", $booking_type)){
            
            $pdf                        = Pdf::loadView('bookings.cab.voucher', compact('booking','terms', 'inclusions', 'exclusions','company'));
            Storage::put('public/uploads/bookings/vouchers/'.$id.'/Cab-voucher.pdf', $pdf->output());
            $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Cab-voucher.pdf', 'all');
        }

        //hotel-booking
         if (in_array("hotel", $booking_type)){
            
            $pdf                        = Pdf::loadView('bookings.hotel.voucher', compact('booking','terms', 'inclusions', 'exclusions','company'));
            Storage::put('public/uploads/bookings/vouchers/'.$id.'/Hotel-voucher.pdf', $pdf->output());
            $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Hotel-voucher.pdf', 'all');
         }

        // safari-booking
        if (in_array("safari", $booking_type)){
            
            foreach($booking->safaris as $key => $safari){
                $pdf                        = Pdf::loadView('bookings.tour.voucher-safari', compact('booking','safari','terms', 'inclusions', 'exclusions','company'));
                Storage::put('public/uploads/bookings/vouchers/'.$id.'/Safari-voucher'.$key.'.pdf', $pdf->output());
                $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Safari-voucher'.$key.'.pdf', 'all');
             }
       }

        // Create an instance of PDFMerger

        $oMerger->merge();
        $oMerger->save(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf', 'file');
        $path = public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf';

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'voucher generated',
            'comment' => 'A Tour Booking voucher has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);
        if (file_exists($path)) {
            return Response::download($path);
        }


    }
}
