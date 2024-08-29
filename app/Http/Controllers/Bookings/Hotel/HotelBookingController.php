<?php

namespace App\Http\Controllers\Bookings\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingExclusion;
use App\Models\BookingHotel;
use App\Models\BookingInclusion;
use App\Models\BookingItem;
use App\Models\BookingTerm;
use App\Models\Company;
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
use App\Models\Term;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserActivity;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelBookingController extends Controller
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
        $inclusions             = Inclusion::where('type', 'hotel')->get();
        $exclusions             = Exclusion::where('type', 'hotel')->get();
        $terms                  = Term::where('mode', 'voucher')->where('type', 'cab')->get();
        if(isset($mobile)){
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [] ;
        }else{
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('bookings.hotel.create', compact('customer_exists', 'customer','inclusions', 'exclusions', 'terms', 'hotels'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $hotels             = Hotel::get(['id', 'name']);
        $inclusions         = Inclusion::where('type', 'hotel')->get();
        $exclusions         = Exclusion::where('type', 'hotel')->get();
        $terms              = Term::where('mode', 'voucher')->where('type', 'cab')->get();
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [] ;
        return view('bookings.hotel.convert', compact('lead', 'customer_exists', 'customer', 'inclusions', 'exclusions', 'terms', 'hotels'));
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
            'adult'                 => 'required',
            'child'                 => 'required',
            'room'                  => 'required',
            'bed'                   => 'required',
            'check_in'              => 'required',
            'check_out'             => 'required',
            'destination'           => 'required',
            'hotel'                 => 'required',
            'hotel_room'            => 'required',
            'service'               => 'required',
            'website'               => 'required',
            
        ];

        $messages = [
            'customer_id.required'      => 'Please select customer from list',
            'adult.required'            => 'Please enter No of Adults.',
            'child.required'            => 'Please enter No of Children.',
            'room.required'             => 'Please enter No of Rooms.',
            'bed.required'              => 'Please enter No of Beds.',
            'check_in.required'         => 'Please enter Check In date.',
            'check_out.required'        => 'Please enter Check Out date.',
            'destination.required'      => 'Please enter Destination.',
            'hotel.required'            => 'Please select Hotel.',
            'hotel_room.required'       => 'Please select Hotel Room.',
            'service.required'          => 'Please select Service.',
            'website.required'          => 'Please enter Website',
        ];

        $this->validate($request, $rules, $messages);

        $website                       = $request->website;

        $booking                       = new Booking;
        $booking->type                 = 'hotel';
        $booking->customer_id          = $request->customer_id;
        $booking->lead_id              = $request->has('lead_id') ? $request->lead_id : null;
        $booking->estimate_id          = $request->has('estimate_id') ? $request->estimate_id : null;
        $booking->assigned_to          = $request->has('lead_id') ? Lead::find($request->lead_id)->assigned_to : null;
        $booking->source               = $request->has('lead_id') ? 'converted' : 'custom';
        $booking->website              = $website;       
        $booking->date                 = date("Y-m-d");
        $booking->time                 = date("H:i:s");
        $booking->save();

        $hotel                            = new BookingHotel;
        $hotel->booking_id                = $booking->id;
        $hotel->adult                     = $request->adult;
        $hotel->child                     = $request->child;
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
        $hotel->note                      = $request->note;
        $hotel->save();
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
                $comment->comment       = "Hotel Booking has been generated by " . Auth::user()->name;
                $comment->save();
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

        if($request->has('estimate_id')){
            Transaction::where('estimate_id', $request->estimate_id)->update(['booking_id' => $booking->id]);

            $payment_status = Estimate::find($request->estimate_id)->payment_status;
            Booking::where('id', $booking->id)->update(['payment_status' => $payment_status]);
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking generated',
            'comment' => 'A Hotel Booking has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);

        return redirect()->route('bookings.index')->with('success', 'Hotel Booking created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::find($id)->load('customer', 'user','hotel', 'items');
        $hotel  = Hotel::find($booking->hotel->hotel_id);
        $hotel->load('images', 'rooms', 'rooms.services');
        foreach ($hotel->images as $image) {
            $image->path = asset('storage/uploads/hotels/' . $hotel->id . '/' . $image->image);
        }
        return view('bookings.hotel.show', compact('booking', 'hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking            = Booking::find($id)->load('hotel', 'items');
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $hotels             = Hotel::get(['id', 'name']);
        $customer_exists    = Customer::where('id', $booking->customer_id)->exists();
        $customer           = $customer_exists ? Customer::find($booking->customer_id) : [];
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();

        return view('bookings.hotel.edit', compact('booking', 'customer_exists', 'customer', 'hotels', 'inclusions', 'exclusions', 'terms'));
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
            'adult'                 => 'required',
            'child'                 => 'required',
            'room'                  => 'required',
            'bed'                   => 'required',
            'check_in'              => 'required',
            'check_out'             => 'required',
            'destination'           => 'required',
            'hotel'                 => 'required',
            'hotel_room'            => 'required',
            'service'               => 'required',
            'website'               => 'required',
            
        ];

        $messages = [
            'customer_id.required'      => 'Please select customer from list',
            'adult.required'            => 'Please enter No of Adults.',
            'child.required'            => 'Please enter No of Children.',
            'room.required'             => 'Please enter No of Rooms.',
            'bed.required'              => 'Please enter No of Beds.',
            'check_in.required'         => 'Please enter Check In date.',
            'check_out.required'        => 'Please enter Check Out date.',
            'destination.required'      => 'Please enter Destination.',
            'hotel.required'            => 'Please select Hotel.',
            'hotel_room.required'       => 'Please select Hotel Room.',
            'service.required'          => 'Please select Service.',
            'website.required'                   => 'Please enter Website',
        ];

        $this->validate($request, $rules, $messages);

        $booking                       = Booking::find($id);
        $booking->customer_id          = $request->customer_id;
        $booking->website              = $request->website;       
        $booking->save();

        $hotel_booking_id                = BookingHotel::where('booking_id', $id)->value('id');

        $hotel                            = BookingHotel::find($hotel_booking_id);
        $hotel->booking_id                = $booking->id;
        $hotel->adult                     = $request->adult;
        $hotel->child                     = $request->child;
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
        $hotel->note                      = $request->note;
        $hotel->save();

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
            'comment' => 'A Hotel Booking has been updated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);

        return redirect()->route('bookings.index')->with('success', 'Hotel Booking updated successfully');
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
        $booking                            = Estimate::find($id)->load('hotel');
        $booking->items                     = [];
        $booking->option_selected           = EstimateHotelOption::where('estimate_id', $id)->where('accepted', 'yes')->first();
        // $customers                          = Customer::get(['id', 'name', 'mobile']);
        $hotels                             = Hotel::get(['id', 'name']);
        $customer_exists                    = Customer::where('id', $booking->customer_id)->exists();
        $customer                           = $customer_exists ? Customer::find($booking->customer_id) : [];
        $inclusions                         = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions                         = EstimateExclusion::where('estimate_id', $id)->get();
        $terms                              = Term::where('mode', 'voucher')->where('type', 'hotel')->where('filter', 'normal')->get();
        return view('bookings.hotel.estimate.booking', compact('booking', 'hotels', 'customer_exists', 'customer', 'id', 'inclusions', 'exclusions', 'terms'));
    }

    public function voucher($id){
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();
        $booking                    = Booking::find($id)->load('customer', 'user','hotel', 'items', 'customer_details');
        $booking->voucher_generated = 'yes';
        $booking->save();
        if(isset($booking->lead_id)){
            $comment                = new LeadComment();
            $comment->lead_id       = $booking->lead_id;
            $comment->comment_by    = Auth::user()->id;
            $comment->type          = "voucher generated";
            $comment->comment       = "Hotel Voucher has been generated by " . Auth::user()->name;
            $comment->save();
        }
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'voucher generated',
            'comment' => 'A Hotel Booking voucher has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);
        $pdf                        = Pdf::loadView('bookings.hotel.voucher', compact('booking','terms','company', 'inclusions', 'exclusions'));

        return $pdf->download('Hotel-voucher.pdf');
    }
}
