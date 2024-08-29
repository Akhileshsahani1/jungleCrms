<?php

namespace App\Http\Controllers;

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
use App\Models\Inclusion;
use App\Models\LeadComment;
use App\Models\Term;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PDFMerger;

class TrashBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function index(Request $request)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        })->get(['id', 'name']);

        $vendors = Vendor::get(['id', 'name']);

        $filter_name                = $request->filter_name;
        $filter_customer            = $request->filter_customer;
        $filter_mobile              = $request->filter_mobile;
        $filter_order_date          = $request->filter_order_date;
        $filter_date                = $request->filter_date;
        $filter_time                = $request->filter_time;
        $filter_user                = $request->filter_user;
        $filter_vendor              = $request->filter_vendor;
        $filter_type                = $request->filter_type;
        $filter_sanctuary           = $request->filter_sanctuary;
        $filter_estimate            = $request->filter_estimate;
        $filter_booking_status      = $request->filter_booking_status;
        $filter_payment_status      = $request->filter_payment_status;
        $filter_permit_uploaded     = $request->filter_permit_uploaded;

        $bookings = Booking::with('customer', 'user', 'safari')->onlyTrashed();
        if (isset($filter_name)) {
            $bookings->whereHas('customer', function ($q) use ($filter_name) {
                $q->where(function ($q) use ($filter_name) {
                    $q->where('name', 'LIKE', '%' . $filter_name . '%');
                });
            });
        }

        if (isset($filter_customer)) {
            $bookings->whereHas('customer', function ($q) use ($filter_customer) {
                $q->where(function ($q) use ($filter_customer) {
                    $q->where('id', $filter_customer);
                });
            });
        }

        if (isset($filter_mobile)) {
            $bookings->whereHas('customer', function ($q) use ($filter_mobile) {
                $q->where(function ($q) use ($filter_mobile) {
                    $q->where('mobile', 'LIKE', '%' . $filter_mobile . '%');
                });
            });
        }

        if (isset($filter_order_date)) {
            $bookings->where('date', $filter_order_date);
        }

        if (isset($filter_date)) {
            $bookings->whereHas('safari', function ($q) use ($filter_date) {
                $q->where(function ($q) use ($filter_date) {
                    $q->where('date', $filter_date);
                });
            });
        }


        if (isset($filter_vendor)) {
            $bookings->whereHas('safari', function ($q) use ($filter_vendor) {
                $q->where(function ($q) use ($filter_vendor) {
                    $q->where('vendor', $filter_vendor);
                });
            });
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
        if (isset($filter_payment_status)) {
            if ($filter_payment_status == 'partially_paid') {
                $bookings->where('payment_status', 'partially paid');
            } else {
                $bookings->where('payment_status', $filter_payment_status);
            }
        }
        if (isset($filter_sanctuary)) {
            $bookings->whereHas('safari', function ($q) use ($filter_sanctuary) {
                $q->where(function ($q) use ($filter_sanctuary) {
                    $q->where('sanctuary', 'LIKE', '%' . $filter_sanctuary . '%');
                });
            });
        }

        if (isset($filter_time)) {
            $bookings->whereHas('safari', function ($q) use ($filter_time) {
                $q->where(function ($q) use ($filter_time) {
                    $q->where('time', 'LIKE', '%' . $filter_time . '%');
                });
            });
        }

        // echo $bookings->toSql();
        // exit;

        $cancelBookingIds = BookingCancel::pluck('booking_id')->all();
        if ($filter_booking_status == 'cancel') {
            $bookings->whereIn('id', $cancelBookingIds);
        } else {
            $bookings->whereNotIn('id', $cancelBookingIds);
        }
        $permit_uploaded_bookings = BookingSafariPermit::query()->distinct()->pluck('booking_id')->all();
        if (isset($filter_permit_uploaded)) {
            if ($filter_permit_uploaded == 'yes') {
                $bookings->whereIn('id', $permit_uploaded_bookings);
            } else {
                $bookings->whereNotIn('id', $permit_uploaded_bookings);
            }
        }

        if (Auth::user()->hasAnyRole('administrator|team lead|agent')) {
            $bookings = $bookings->latest()->paginate(150);
        } elseif (Auth::user()->hasRole('fresher')) {

            $bookings = $bookings->latest()->paginate();
        }elseif (Auth::user()->hasRole('team-lead')) {

            $bookings = $bookings->whereIn('website',  Auth::user()->roles->pluck('name')->toArray())->latest()->paginate(150);
        } else {

            $bookings = $bookings->where('assigned_to', Auth::user()->id)->latest()->paginate(150);
        }

        // echo '<pre>';
        // print_r($bookings);
        // exit;

        return view('trash.bookings.list', compact('filter_name', 'filter_date', 'filter_time', 'filter_order_date', 'filter_user', 'filter_type', 'filter_sanctuary', 'filter_booking_status', 'filter_payment_status', 'users', 'bookings', 'filter_mobile', 'vendors', 'filter_vendor', 'filter_permit_uploaded'));
    }

    public function restoreBooking($id){
        Booking::withTrashed()->find($id)->restore();
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking updated',
            'comment' => 'A Booking has been restored <a href="'.route('bookings.show', $id).'">Booking No. '.$id.'</a>'
        ]);

        return redirect()->back()->with('success', 'Booking Restore successfully!');
    }
    public function deleteBooking($id){

        Booking::withTrashed()->find($id)->forceDelete();
        BookingCab::where('booking_id', $id)->delete();
        BookingItem::where('booking_id', $id)->delete();
        BookingHotel::where('booking_id', $id)->delete();
        BookingSafari::where('booking_id', $id)->delete();
        BookingSafariPermit::where('booking_id', $id)->delete();
        BookingSafariCustomer::where('booking_id', $id)->delete();
        Invoice::where('booking_id', $id)->delete();
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking updated',
            'comment' => 'A Booking has been deleted Booking No. '.$id,
        ]);

        return redirect()->back()->with('success', 'Booking deleted successfully!');
    }
     public function showBooking($id)
    {
        $booking = Booking::withTrashed()->find($id);
        switch ($booking->type) {
            case 'cab':
             $booking = Booking::withTrashed()->find($id)->load('customer', 'user','cab', 'items');
             $booking_cab = BookingCab::where('booking_id',$id)->get()->toArray();
             return view('trash.bookings.cab.show', compact('booking', 'booking_cab'));
            break;
            case 'hotel':
                $booking = Booking::withTrashed()->find($id)->load('customer', 'user','hotel', 'items');
                $hotel  = Hotel::find($booking->hotel->hotel_id);
                $hotel->load('images', 'rooms', 'rooms.services');
                foreach ($hotel->images as $image) {
                    $image->path = asset('storage/uploads/hotels/' . $hotel->id . '/' . $image->image);
                }
                return view('trash.bookings.hotel.show', compact('booking', 'hotel'));
            break;
            case 'safari':
                $booking = Booking::withTrashed()->find($id)->load('customer', 'user','safari', 'items', 'customer_details');
                return view('trash.bookings.safari.show', compact('booking'));
            break;
            case 'tour':
                $booking = Booking::withTrashed()->find($id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details');
                $hotel  = Hotel::find($booking->hotel->hotel_id);
                $hotel->load('images', 'rooms', 'rooms.services');
                foreach ($hotel->images as $image) {
                    $image->path = asset('storage/uploads/hotels/' . $hotel->id . '/' . $image->image);
                }
                $booking_type = bookingType($id);
                return view('trash.bookings.tour.show', compact('booking', 'hotel', 'booking_type'));
            break;
            case 'package':
                $booking = Booking::withTrashed()->find($id)->load('customer', 'user','hotel', 'cab', 'safari', 'items', 'customer_details');
                $booking_type = bookingType($id);
                return view('trash.bookings.package.show', compact('booking', 'booking_type'));
            break;
        }

        return redirect()->route('trash-bookings.index')->with('error', 'Something went wrong.');
    }
}
