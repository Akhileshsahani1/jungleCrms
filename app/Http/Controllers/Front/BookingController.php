<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCab;
use App\Models\BookingHotel;
use App\Models\BookingItem;
use App\Models\BookingSafari;
use App\Models\BookingSafariCustomer;
use App\Models\BookingSafariPermit;
use App\Models\PermitLink;
use App\Models\BookingCancel;
use App\Models\BookingCancellationRequest;
use App\Models\BookingExclusion;
use App\Models\BookingInclusion;
use App\Models\BookingTerm;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\State;
use App\Models\Company;
use App\Models\Exclusion;
use App\Models\Hotel;
use App\Models\Inclusion;
use App\Models\LeadComment;
use App\Models\Term;
use App\Models\User;
use App\Models\Vendor;
use App\Models\BookingCancellationCharges;
use App\Models\CancellationCharges;
use App\Models\CancelSafari;
use App\Models\CancelSafariMembers;
use App\Models\RefundHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use CreateBookingSafariCustomers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PDFMerger;

class BookingController extends Controller
{
    public function __construct()
    {
        // Middleware only applied to these methods
        $this->middleware('auth:customer', [
            'only' => [
                'index' // Could add bunch of more methods too
            ]
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $bookings = Booking::where('customer_id', Auth::guard('customer')->user()->id)->with('customer', 'user', 'safari', 'Cancel')->whereDoesntHave('cancellationRequest',function($q){
                $q->where('cancel_status', '');
            })->latest()->paginate(150);
        // dd($bookings);
        return view('front.bookings.list', compact('bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::find($id);

        switch ($booking->type) {
            case 'cab':
                return redirect()->route('dashboard.cab-booking', $id);
                break;
            case 'hotel':
                return redirect()->route('dashboard.hotel-booking', $id);
                break;
            case 'safari':
                return redirect()->route('dashboard.safari-booking', $id);
                break;
            case 'tour':
                return redirect()->route('dashboard.tour-booking', $id);
                break;
            case 'package':
                return redirect()->route('dashboard.package-booking', $id);
                break;
        }


        return redirect()->route('dashboard.bookings')->with('error', 'Something went wrong.');
    }

    public function cabBooking($id)
    {
        $booking     = Booking::find($id)->load('customer', 'user', 'cab', 'items');
        $booking_cab = BookingCab::where('booking_id', $id)->get()->toArray();
        return view('front.bookings.cab', compact('booking', 'booking_cab'));
    }

    public function hotelBooking($id)
    {
        $booking = Booking::find($id)->load('customer', 'user', 'hotel', 'items');
        $hotel   = Hotel::find($booking->hotel->hotel_id);
        $hotel->load('images', 'rooms', 'rooms.services');
        foreach ($hotel->images as $image) {
            $image->path = asset('storage/uploads/hotels/' . $hotel->id . '/' . $image->image);
        }
        return view('front.bookings.hotel', compact('booking', 'hotel'));
    }

    public function safariBooking($id)
    {
        $booking = Booking::find($id)->load('customer', 'user', 'safari', 'items', 'customer_details');
        $cancel  = CancelSafari::with('members')->where('booking_id', $id)->first();
        return view('front.bookings.safari', compact('booking', 'cancel'));
    }

    public function tourBooking($id)
    {
        $booking = Booking::find($id)->load('customer', 'user', 'hotel', 'cab', 'safari', 'items', 'customer_details');
        $hotel  = Hotel::find($booking->hotel->hotel_id);
        $hotel->load('images', 'rooms', 'rooms.services');
        foreach ($hotel->images as $image) {
            $image->path = asset('storage/uploads/hotels/' . $hotel->id . '/' . $image->image);
        }
        $booking_type = bookingType($id);
        return view('front.bookings.tour', compact('booking', 'hotel', 'booking_type'));
    }

    public function packageBooking($id)
    {
        $booking = Booking::find($id)->load('customer', 'user', 'hotel', 'cab', 'safari', 'items', 'customer_details');
        $booking_type = bookingType($id);
        return view('front.bookings.package', compact('booking', 'booking_type'));
    }

    public function cancel($id)
    {

        $booking = Booking::find($id);
        $cancellation_exists = BookingCancellationRequest::where('booking_id', $id)->where('cancel_status', 'Cancel')->exists();

        $amount = 0;
        if (Auth::guard('customer')->user()->id == $booking->customer_id) {
            switch ($booking->type) {
                case 'cab':
                    $content  = BookingCancellationCharges::where('type', 'cab')->first();
                    $days = getCancellationDays($booking->cab->start_date);
                    $charge = CancellationCharges::Where('booking_cancellation_charge_id', $content->id)->Where('min_day', '<=', $days)->Where('max_day', '>=', $days)->value('charge');
                    $charge = ($charge) ? $charge : 100;
                    $amount = ($booking->items->sum('amount') * $charge / 100);


                    return view('front.bookings.cancel', compact('booking', 'amount', 'content', 'cancellation_exists'));
                    break;
                case 'hotel':
                    $content  = BookingCancellationCharges::where('type', 'hotel')->first();
                    $hotel  = Hotel::find($booking->hotel->hotel_id);
                    $days = getCancellationDays($booking->hotel->check_in);
                    $charge = CancellationCharges::Where('booking_cancellation_charge_id', $content->id)->Where('min_day', '<=', $days)->Where('max_day', '>=', $days)->value('charge');
                    $charge = ($charge) ? $charge : 100;
                    $amount = ($booking->items->sum('amount') * $charge / 100);
                    return view('front.bookings.cancel', compact('booking', 'amount', 'hotel', 'content', 'cancellation_exists'));
                    break;
                case 'safari':
                    $days = getCancellationDays($booking->safari->date);
                    $members = BookingSafariCustomer::where('booking_id', $id)->get();
                    $content  = BookingCancellationCharges::where('type', 'safari')->where('destination', $booking->safari->sanctuary)->first();
                    $charge = CancellationCharges::Where('booking_cancellation_charge_id', $content->id)->Where('min_day', '<=', $days)->Where('max_day', '>=', $days)->value('charge');
                    $charge = ($charge) ? $charge : 100;
                    $amount =  ($booking->items->sum('amount') * $charge / 100);
                    $cancel = CancelSafari::with('members')->where('booking_id', $id)->get()->first();
                    return view('front.bookings.cancel', compact('booking', 'members', 'amount', 'content', 'cancellation_exists', 'cancel'));
                    break;
                case 'tour':
                    $booking_type = bookingType($id);
                    $hotel  = Hotel::find($booking->hotel->hotel_id);
                    $content  = BookingCancellationCharges::where('type', 'tour')->first();
                    $days = Carbon::parse($booking->safari->date)->diffInDays();
                    $charge = CancellationCharges::Where('booking_cancellation_charge_id', $content->id)->Where('min_day', '<=', $days)->Where('max_day', '>=', $days)->value('charge');
                    $charge = ($charge) ? $charge : 100;
                    $amount = ($booking->items->sum('amount') * $charge / 100);
                    return view('front.bookings.cancel', compact('booking', 'amount', 'booking_type', 'hotel', 'content', 'cancellation_exists'));
                    break;
                case 'package':
                    $booking_type = bookingType($id);
                    $days = Carbon::parse($booking->safari->date)->diffInDays();
                    $content  = BookingCancellationCharges::where('type', 'package')->first();
                    $members = BookingSafariCustomer::where('booking_id', $id)->get();
                    $charge = CancellationCharges::Where('booking_cancellation_charge_id', $content->id)->Where('min_day', '<=', $days)->Where('max_day', '>=', $days)->value('charge');
                    $charge = ($charge) ? $charge : 100;
                    $amount = $booking->items->sum('amount') - ($booking->items->sum('amount') * $charge / 100);
                    $cancel = CancelSafari::with('members')->where('booking_id', $id)->get()->first();
                    return view('front.bookings.cancel', compact('booking', 'amount', 'members', 'booking_type', 'content', 'cancellation_exists', 'cancel'));
                    break;
            }
        } else {
            abort(403);
        }
    }

    public function cancelBooking(Request $request, $id)
    {


        $booking = Booking::find($id);
        $cstatus = 'Cancel';
        $ctype   = '';
        switch ($request->type) {

            case 'safari':

                (count($request->cancel_persons) == BookingSafariCustomer::where('booking_id', $id)->count()) ?  $cstatus = 'Cancel' : $cstatus = 'Partial Cancel';

                $cancel = CancelSafari::create([
                    'booking_id' => $id,
                    'amount'     =>  $booking->items->sum('amount'),
                    'customer_id' => Auth::guard('customer')->user()->id,

                ]);
                if (count($request->cancel_persons) > 0) {
                    foreach ($request->cancel_persons as $p) {
                        CancelSafariMembers::create([
                            'name' => $p,
                            'booking_id' => $id,
                            'cancel_id'  => $cancel->id,
                        ]);
                    }
                }

                break;

            case 'package-cab':

                $cstatus = 'Partial Cancel';
                $ctype   = 'Cab';

                BookingCab::where('id', $request->type_id)->update(['status' => 0]);

                break;

            case 'package-safari':

                $cstatus = 'Partial Cancel';
                $ctype   = 'Safari';

                BookingSafari::where('id', $request->type_id)->update(['status' => 0]);

                break;

            case 'package-hotel':

                $cstatus = 'Partial Cancel';
                $ctype   = 'Hotel';

                BookingHotel::where('id', $request->type_id)->update(['status' => 0]);

                break;
        }
        $cstatus = ($ctype)?$cstatus.'('.$ctype.')':$ctype;
       
        BookingCancellationRequest::create([
            'customer_id' => Auth::guard('customer')->user()->id,
            'booking_id' => $id,
            'reason' => $request->reason,
            'cancellation_charges' => $booking->items->sum('amount') - $request->amount,
            'refundable_amount' => $request->amount,
            'cancel_status' => $cstatus
        ]);

        return redirect()->route('dashboard.bookings.cancel', $id)->with('success', 'Cancellation request sent successfully, You can track request for update about refund amount.');
    }
    public function refund($id)
    {

        $booking = Booking::where('customer_id', Auth::guard('customer')->user()->id)->with('customer', 'user', 'safari', 'Cancel')->where('id', $id)->first();
        // dd($bookings);
        return view('front.bookings.refund', compact('booking'));
    }

    public function cancelBookingList()
    {

        $bookings = Booking::where('customer_id', Auth::guard('customer')->user()->id)->with('customer', 'user', 'safari', 'Cancel', 'cancellationRequest', 'refund_history');

        $bookings = $bookings->has('cancellationRequest')->latest()->paginate(5);

        return view('front.bookings.cancel-list', compact('bookings'));
    }

    public function refundAccept(Request $request)
    {
        
        $c = BookingCancellationRequest::find($request->id);
        $up = Carbon::parse($c->updated_at);
        $now = Carbon::now();
        $time = $now->diffInHours($up);
        
        if( $time > 24 ){
            return redirect()->back()->with('error','Sorry, This refund exceeds 24 hours its expired now.');
        }

        BookingCancellationRequest::where('id', $request->id)->update(['approval_status' => $request->approval_status]);

        if ($request->history_id != 0) {

            $cr = RefundHistory::find($request->history_id);

            RefundHistory::create([

                'booking_id'      => $cr->booking_id,
                'customer_id'     => $cr->customer_id,
                'admin_id'        => 0,
                'cancellation_id' => $request->id,
                'note'            => $request->note,
                'amount'          => $cr->amount,
                'status'          => $request->approval_status == 1 ? 'Accepted' : 'Rejected'

            ]);
        }

        return redirect()->back()->with('success', 'Thanks, Your response recorded successfully!');
    }

    public function refundApprovalHistory($id){
       
        $history = RefundHistory::where('booking_id',$id)->orderBy('id','desc')->paginate(10);

        return view('front.bookings.refund-history',compact('history'));
    }
}
