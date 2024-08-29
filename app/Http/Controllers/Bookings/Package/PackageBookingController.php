<?php

namespace App\Http\Controllers\Bookings\Package;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCab;
use App\Models\BookingCabHalt;
use App\Models\BookingExclusion;
use App\Models\BookingHotel;
use App\Models\BookingHotelDestination;
use App\Models\BookingHotelDestinationOption;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PDFMerger;
use ZipArchive;

class PackageBookingController extends Controller
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
        // $customers              = Customer::get(['id', 'name', 'mobile']);
        $hotels                 = Hotel::get(['id', 'name']);
        $vendors                = Vendor::all();
        $destinations           = Hotel::select('city as destination')->distinct('city')->get();
        $states                 = State::get(['id', 'state']);
        $cab_vendors                = Vendor::where('sanctuary', 'cab')->get();
        $inclusions             = Inclusion::where('type', 'package')->get();
        $exclusions             = Exclusion::where('type', 'package')->get();
        $terms                  = Term::where('type', 'package')->get();
        $booking_type           = [];
        if(isset($mobile)){
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [] ;
        }else{
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('bookings.package.create', compact('customer_exists', 'customer', 'hotels', 'vendors', 'states', 'booking_type', 'destinations', 'inclusions', 'exclusions', 'terms', 'cab_vendors'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $hotels             = Hotel::get(['id', 'name']);
        $vendors            = Vendor::all();
        $cab_vendors                = Vendor::where('sanctuary', 'cab')->get();
        $destinations       = Hotel::select('city as destination')->distinct('city')->get();
        $states             = State::get(['id', 'state']);
        $inclusions         = Inclusion::where('type', 'package')->get();
        $exclusions         = Exclusion::where('type', 'package')->get();
        $terms              = [];
        $booking_type       = [];
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [] ;
        return view('bookings.package.convert', compact('lead', 'customer_exists', 'customer', 'hotels', 'vendors', 'states', 'booking_type', 'destinations', 'inclusions', 'exclusions', 'terms', 'cab_vendors'));
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
            'website'               => 'required',            
        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'booking_type.required'             => 'Please select estimate type from list',
            'amount.required'                   => 'Please enter Total Amount',
            'website.required'                   => 'Please select estimate type',
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
        $booking->type                 = 'package';
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
            if (!empty($request->trip) && is_array($request->trip)) {
                foreach ($request->trip as $key => $trip) {
                    $cab                            = new BookingCab;
                    $cab->booking_id                = $booking->id;
                    $cab->trip_type                 = $trip['trip_type'];
                    $cab->pickup_medium             = 'any';
                    $cab->vehicle_type              = $trip['cab_type'];
                    $cab->start_date                = Carbon::parse($trip['start_date'])->format('Y-m-d');
                    $cab->end_date                  = Carbon::parse($trip['end_date'])->format('Y-m-d');
                    $cab->days                      = $trip['days'];
                    $cab->pick_up                   = $trip['pick_up'];
                    $cab->drop                      = $trip['drop'];
                    $cab->pickup_time               = $trip['pickup_time'];
                    $cab->total_riders              = $trip['total_riders'];
                    $cab->no_of_cab                 = $trip['no_of_cab'];
                    $cab->vendor_name               = $trip['vendor_name'];
                    $cab->vendor_mobile             = $trip['vendor_mobile'];
                    $cab->cab_due_amount            = $trip['cab_due_amount'];
                    $cab->note                      = $trip['cab_note'];
                    $cab->amount                    = $request->amount;
                    $cab->save();

                    if (!empty($trip['halts']) && is_array($trip['halts'])) {
                        foreach ($trip['halts'] as $key => $value) {
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
            }
        }


        if (in_array('hotel', $request->booking_type)) {

            if (!empty($request->hotel) && is_array($request->hotel)) {
                foreach ($request->hotel as $key => $value) {

                    $hotel                            = new BookingHotel;
                    $hotel->booking_id                = $booking->id;
                    $hotel->adult                     = $value['adults'];
                    $hotel->child                     = $value['childs'];
                    $hotel->room                      = $value['room'];
                    $hotel->bed                       = $value['bed'];
                    $hotel->check_in                  = $value['check_in'];
                    $hotel->check_out                 = $value['check_out'];
                    $hotel->destination               = $value['destination'];
                    $hotel->hotel_due_amount          = $value['hotel_due_amount'];
                    $hotel->note                      = $value['hotel_note'];
                    $hotel->amount                    = $request->amount;
                    $hotel->save();

                    $option                             = new BookingHotelDestinationOption;
                    $option->booking_id                 = $booking->id;
                    $option->booking_hotel_id           = $hotel->id;
                    $option->hotel_id                   = $value['hotel'];
                    $option->room_id                    = $value['hotel_room'];
                    $option->service_id                 = $value['service'];
                    $option->save();

                }
            }
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

            $comment                    = new LeadComment();
                $comment->lead_id       = $request->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "booking generated";
                $comment->comment       = "Package Booking has been generated by " . Auth::user()->name;
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
            'comment' => 'A Package Booking has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);


        return redirect()->route('bookings.index')->with('success', 'Package Booking created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::find($id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details','cancellationRequest');
        $booking_type = bookingType($id);
        return view('bookings.package.show', compact('booking', 'booking_type'));
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
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $states             = State::get(['id', 'state']);
        $countries          = Country::get(['country']);
        $hotels             = Hotel::get(['id', 'name']);
        $vendors            = Vendor::all();
        $destinations       = Hotel::select('city as destination')->distinct('city')->get();
        $customer_exists    = Customer::where('id', $booking->customer_id)->exists();
        $customer           = $customer_exists ? Customer::find($booking->customer_id) : [];
        $booking_type       = bookingType($id);
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();
        $cab_vendors                = Vendor::where('sanctuary', 'cab')->get();

        return view('bookings.package.edit', compact('booking', 'customer_exists', 'customer', 'states', 'countries', 'hotels', 'vendors', 'destinations', 'booking_type', 'inclusions', 'exclusions', 'terms', 'cab_vendors'));
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
            'website'                => 'required',            

        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'booking_type.required'             => 'Please select estimate type from list',
            'amount.required'                   => 'Please enter Total Amount',
            'website.required'                   => 'Please enter Website',
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
            BookingCab::where('booking_id', $id)->delete();
            BookingCabHalt::where('booking_id', $id)->delete();
            if (!empty($request->trip) && is_array($request->trip)) {
                foreach ($request->trip as $key => $trip) {
                    $cab                            = new BookingCab;
                    $cab->booking_id                = $booking->id;
                    $cab->trip_type                 = $trip['trip_type'];
                    $cab->pickup_medium             = 'any';
                    $cab->vehicle_type              = $trip['cab_type'];
                    $cab->start_date                = Carbon::parse($trip['start_date'])->format('Y-m-d');
                    $cab->end_date                  = Carbon::parse($trip['end_date'])->format('Y-m-d');
                    $cab->days                      = $trip['days'];
                    $cab->pick_up                   = $trip['pick_up'];
                    $cab->drop                      = $trip['drop'];
                    $cab->pickup_time               = $trip['pickup_time'];
                    $cab->total_riders              = $trip['total_riders'];
                    $cab->no_of_cab                 = $trip['no_of_cab'];
                    $cab->vendor_name               = $trip['vendor_name'];
                    $cab->vendor_mobile             = $trip['vendor_mobile'];
                    $cab->cab_due_amount            = $trip['cab_due_amount'];
                    $cab->note                      = $trip['cab_note'];
                    $cab->amount                    = $request->amount;
                    $cab->save();

                    if (!empty($trip['halts']) && is_array($trip['halts'])) {
                        foreach ($trip['halts'] as $key => $value) {
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
            }

        }


        $hotel_booking_exists  = BookingHotel::where('booking_id', $id)->exists();

        if ($hotel_booking_exists) {
            $hotel_booking_id = BookingHotel::where('booking_id', $id)->value('id');
        }

        if (!in_array('hotel', $request->booking_type) && $hotel_booking_exists) {
            BookingHotel::where('booking_id', $id)->delete();
            BookingHotelDestination::where('booking_id', $id)->delete();
            BookingHotelDestinationOption::where('booking_id', $id)->delete();
        }

        if (in_array('hotel', $request->booking_type)) {

            BookingHotel::where('booking_id', $id)->delete();
            BookingHotelDestination::where('booking_id', $id)->delete();
            BookingHotelDestinationOption::where('booking_id', $id)->delete();

            if (!empty($request->hotel) && is_array($request->hotel)) {
                foreach ($request->hotel as $key => $value) {

                    $hotel                            = new BookingHotel;
                    $hotel->booking_id                = $booking->id;
                    $hotel->adult                     = $value['adults'];
                    $hotel->child                     = $value['childs'];
                    $hotel->room                      = $value['room'];
                    $hotel->bed                       = $value['bed'];
                    $hotel->check_in                  = $value['check_in'];
                    $hotel->check_out                 = $value['check_out'];
                    $hotel->destination               = $value['destination'];
                    $hotel->hotel_due_amount          = $value['hotel_due_amount'];
                    $hotel->note                      = $value['hotel_note'];
                    $hotel->amount                    = $request->amount;
                    $hotel->save();

                    $option                             = new BookingHotelDestinationOption;
                    $option->booking_id                 = $booking->id;
                    $option->booking_hotel_id           = $hotel->id;
                    $option->hotel_id                   = $value['hotel'];
                    $option->room_id                    = $value['hotel_room'];
                    $option->service_id                 = $value['service'];
                    $option->save();

                }
            }

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
            'comment' => 'A Package Booking has been updated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
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
        // $customers                  = Customer::get(['id', 'name', 'mobile']);
        $states                     = State::get(['id', 'state']);
        $hotels                     = Hotel::get(['id', 'name']);
        $vendors                    = Vendor::all();
        $destinations               = Hotel::select('city as destination')->distinct('city')->get();
        $customer_exists            = Customer::where('id', $booking->customer_id)->exists();
        $customer                   = $customer_exists ? Customer::find($booking->customer_id) : [];
        $booking_type               = estimateType($id);
        $inclusions                 = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions                 = EstimateExclusion::where('estimate_id', $id)->get();
        $cab_vendors                = Vendor::where('sanctuary', 'cab')->get();
        // $terms                      = Term::where('mode', 'voucher')->where('type', 'package')->where('filter', $booking->safari->sanctuary)->get();
        $terms                      = EstimateTerm::where('estimate_id', $id)->get();

        return view('bookings.package.estimate.booking', compact('booking', 'states', 'hotels', 'vendors', 'destinations','customer_exists', 'customer', 'booking_type', 'id', 'inclusions', 'exclusions', 'terms', 'cab_vendors'));
    }

    // public function voucher($id){
    //     $booking                    = Booking::find($id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details');
    //     $booking->voucher_generated = 'yes';
    //     $booking->save();

    //     $terms                      = Term::where('mode', 'voucher')->where('type', 'tour')->get();
    //     $pdf                        = Pdf::loadView('bookings.package.voucher', compact('booking','terms'));

    //     return $pdf->download('Package-voucher.pdf');
    // }
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
            $comment->comment       = "Package Vouchers has been generated by " . Auth::user()->name;
            $comment->save();
        }
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();

        // cab-booking
        if (in_array("cab", $booking_type)){
           
            foreach($booking->cabs as $key => $cab){
              if($cab->status){
                $pdf                        = Pdf::loadView('bookings.package.voucher-cab', compact('booking','cab','terms', 'inclusions', 'exclusions','company'));
                Storage::put('public/uploads/bookings/vouchers/'.$id.'/Cab-voucher'.$key.'.pdf', $pdf->output());
                $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Cab-voucher'.$key.'.pdf', 'all');
               }
            }
        }

         if (in_array("hotel", $booking_type)){
            
             foreach($booking->hotels as $key => $hotel){
                if($hotel->status){
                $pdf                        = Pdf::loadView('bookings.package.voucher-hotel', compact('booking','hotel','terms', 'inclusions', 'exclusions','company'));
                Storage::put('public/uploads/bookings/vouchers/'.$id.'/Hotel-voucher'.$key.'.pdf', $pdf->output());
                $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Hotel-voucher'.$key.'.pdf', 'all');
               }
             }


         }

        // safari-booking
        if (in_array("safari", $booking_type)){
            
            foreach($booking->safaris as $key => $safari){
              if($safari->status){
                $pdf                        = Pdf::loadView('bookings.package.voucher-safari', compact('booking','safari','terms', 'inclusions', 'exclusions','company'));
                Storage::put('public/uploads/bookings/vouchers/'.$id.'/Safari-voucher'.$key.'.pdf', $pdf->output());
                $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Safari-voucher'.$key.'.pdf', 'all');
              }
             }
       }

        // Create an instance of PDFMerger





        $oMerger->merge();
        $oMerger->save(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf', 'file');
        $path = public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf';

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'voucher generated',
            'comment' => 'A Package Booking voucher has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);

        if (file_exists($path)) {
            return Response::download($path);
        }


    }
}
