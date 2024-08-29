<?php

namespace App\Http\Controllers\Bookings;

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
use App\Models\RefundHistory;
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

class BookingController extends Controller
{
    public function __construct()
    {
        // Middleware only applied to these methods
        $this->middleware('auth', [
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

        $bookings = Booking::with('customer', 'user', 'safari','Cancel');
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
        // if ($filter_booking_status == 'cancel') {
        //     $bookings->whereIn('id', $cancelBookingIds);
        // } else {
        //     $bookings->whereNotIn('id', $cancelBookingIds);
        // }
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

        return view('bookings.list', compact('filter_name', 'filter_date', 'filter_time', 'filter_order_date', 'filter_user', 'filter_type', 'filter_sanctuary', 'filter_booking_status', 'filter_payment_status', 'users', 'bookings', 'filter_mobile', 'vendors', 'filter_vendor', 'filter_permit_uploaded'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return $request->all();
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
        $booking = Booking::find($id);
        switch ($booking->type) {
            case 'cab':
            return redirect()->route('cab-booking.show', $id);
            break;
            case 'hotel':
            return redirect()->route('hotel-booking.show', $id);
            break;
            case 'safari':
            return redirect()->route('safari-booking.show', $id);
            break;
            case 'tour':
            return redirect()->route('tour-booking.show', $id);
            break;
            case 'package':
            return redirect()->route('package-booking.show', $id);
            break;
        }

        return redirect()->route('bookings.index')->with('error', 'Something went wrong.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking = Booking::find($id);
        switch ($booking->type) {
            case 'cab':
            return redirect()->route('cab-booking.edit', $id);
            break;
            case 'hotel':
            return redirect()->route('hotel-booking.edit', $id);
            break;
            case 'safari':
            return redirect()->route('safari-booking.edit', $id);
            break;
            case 'tour':
            return redirect()->route('tour-booking.edit', $id);
            break;
            case 'package':
            return redirect()->route('package-booking.edit', $id);
            break;
        }


        return redirect()->route('bookings.index')->with('error', 'Something went wrong.');
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
    public function destroy(Request $request,$id)
    {
        $booking = Booking::find($id);
        $booking->reason = $request->reason;
        $booking->deleted_by = Auth::user()->id;
        $booking->save();
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking updated',
            'comment' => 'A Booking has been delete for Booking No. '.$booking->id.'.'
        ]);
        $booking->delete();
        // BookingCab::where('booking_id', $id)->delete();
        // BookingItem::where('booking_id', $id)->delete();
        // BookingHotel::where('booking_id', $id)->delete();
        // BookingSafari::where('booking_id', $id)->delete();
        // BookingSafariPermit::where('booking_id', $id)->delete();
        // BookingSafariCustomer::where('booking_id', $id)->delete();
        // Invoice::where('booking_id', $id)->delete();

        return redirect()->back()->with('success', 'Booking deleted successfully');
    }

    public function deleteBookingCustomerId($id){
        Booking::find($id)->update(['image' => null]);
        return redirect()->back()->with('success', 'Uploaded Image deletd successfully');
    }

    public function sendVoucher($id)
    {
        $booking                    = Booking::find($id)->load('customer', 'user', 'cab', 'hotel', 'safari', 'items', 'customer_details');
        $booking->mail_sent         = 'yes';
        $booking->save();
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/' . $company->logo) : '';
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();
        switch ($booking->type) {
            case 'cab':

            $booking_cab                = BookingCab::where('booking_id', $id)->get()->toArray();

            $pdf                        = Pdf::loadView('bookings.cab.voucher', compact('booking', 'terms', 'company', 'booking_cab', 'inclusions', 'exclusions'));
            $filename                   = 'Cab-voucher.pdf';

            $data["email"] = $booking->customer->email;
            $data["title"] = "Booking Voucher (" . $company->name . ")";

            try {
                $results = Mail::send('emails.voucher', $data, function ($message) use ($data, $pdf, $filename) {
                    $message->from('contact@junglesafariindia.in')
                    ->to($data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), $filename);
                });

                $comment                = new LeadComment();
                $comment->lead_id       = $booking->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "voucher sent";
                $comment->comment       = "Cab Voucher has been sent to customer email by " . Auth::user()->name;
                $comment->save();
                UserActivity::create([
                    'user_id' => Auth::user()->id,
                    'type'    => 'voucher sent',
                    'comment' => 'A Cab Booking voucher has been sent via email for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
                ]);
                return redirect()->back()->with('voucher', 'Voucher has been sent to customer successfully');
            } catch (HttpException $ex) {
                return $ex;
            }
            break;

            case 'hotel':

            $pdf                        = Pdf::loadView('bookings.hotel.voucher', compact('booking', 'terms', 'company', 'inclusions', 'exclusions'));
            $filename                   = 'Hotel-voucher.pdf';

            $data["email"] = $booking->customer->email;
            $data["title"] = "Booking Voucher (" . $company->name . ")";

            try {
                $results = Mail::send('emails.voucher', $data, function ($message) use ($data, $pdf, $filename) {
                    $message->from('contact@junglesafariindia.in')
                    ->to($data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), $filename);
                });

                $comment                = new LeadComment();
                $comment->lead_id       = $booking->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "voucher sent";
                $comment->comment       = "Hotel Voucher has been sent to customer email by " . Auth::user()->name;
                $comment->save();
                UserActivity::create([
                    'user_id' => Auth::user()->id,
                    'type'    => 'voucher sent',
                    'comment' => 'A Hotel Booking voucher has been sent via email for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
                ]);
                return redirect()->back()->with('voucher', 'Voucher has been sent to customer successfully');
            } catch (HttpException $ex) {
                return $ex;
            }
            break;

            case 'safari':

            $pdf                        = Pdf::loadView('bookings.safari.voucher', compact('booking', 'terms', 'company', 'inclusions', 'exclusions'));
            $filename                   = 'Safari-voucher.pdf';

            $data["email"] = $booking->customer->email;
            $data["title"] = "Booking Voucher (" . $company->name . ")";

            try {
                $results = Mail::send('emails.voucher', $data, function ($message) use ($data, $pdf, $filename) {
                    $message->from('contact@junglesafariindia.in')
                    ->to($data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), $filename);
                });

                $comment                = new LeadComment();
                $comment->lead_id       = $booking->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "voucher sent";
                $comment->comment       = "Safari Voucher has been sent to customer email by " . Auth::user()->name;
                $comment->save();
                UserActivity::create([
                    'user_id' => Auth::user()->id,
                    'type'    => 'voucher sent',
                    'comment' => 'A Safari Booking voucher has been sent via email for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
                ]);
                return redirect()->back()->with('voucher', 'Voucher has been sent to customer successfully');
            } catch (HttpException $ex) {
                return $ex;
            }
            break;

            case 'tour':
            $booking_type               = bookingType($id);
            $data["email"] = $booking->customer->email;
            $data["title"] = "Booking Voucher (" . $company->name . ")";
            $oMerger = PDFMerger::init();
                // cab-booking
            if (in_array("cab", $booking_type)) {

                $pdf                        = Pdf::loadView('bookings.cab.voucher', compact('booking', 'terms', 'inclusions', 'exclusions', 'company'));
                Storage::put('public/uploads/bookings/vouchers/' . $id . '/Cab-voucher.pdf', $pdf->output());
                $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Cab-voucher.pdf', 'all');
            }

                //hotel-booking
            if (in_array("hotel", $booking_type)) {

                $pdf                        = Pdf::loadView('bookings.hotel.voucher', compact('booking', 'terms', 'inclusions', 'exclusions', 'company'));
                Storage::put('public/uploads/bookings/vouchers/' . $id . '/Hotel-voucher.pdf', $pdf->output());
                $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Hotel-voucher.pdf', 'all');
            }

                // safari-booking
            if (in_array("safari", $booking_type)) {

                foreach ($booking->safaris as $key => $safari) {
                    $pdf                        = Pdf::loadView('bookings.tour.voucher-safari', compact('booking', 'safari', 'terms', 'inclusions', 'exclusions', 'company'));
                    Storage::put('public/uploads/bookings/vouchers/' . $id . '/Safari-voucher' . $key . '.pdf', $pdf->output());
                    $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Safari-voucher' . $key . '.pdf', 'all');
                }
            }
            $filename                   = 'Tour-voucher.pdf';
                // Create an instance of PDFMerger





            $oMerger->merge();
            $oMerger->save(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf', 'file');
            $path = public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf';
            try {
                $results = Mail::send('emails.voucher', $data, function ($message) use ($data, $path, $filename) {
                    $message->from('contact@junglesafariindia.in')
                    ->to($data["email"])
                    ->subject($data["title"])
                    ->attach($path);
                });

                $comment                = new LeadComment();
                $comment->lead_id       = $booking->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "voucher sent";
                $comment->comment       = "Tour Vouchers has been sent to customer email by " . Auth::user()->name;
                $comment->save();
                UserActivity::create([
                    'user_id' => Auth::user()->id,
                    'type'    => 'voucher sent',
                    'comment' => 'Tour Booking vouchers has been sent via email for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
                ]);
                return redirect()->back()->with('voucher', 'Voucher has been sent to customer successfully');
            } catch (HttpException $ex) {
                return $ex;
            }

            break;
            case 'package':
            $oMerger = PDFMerger::init();
            $data["email"] = $booking->customer->email;
            $data["title"] = "Booking Voucher (" . $company->name . ")";
            $booking_type = bookingType($id);
                // cab-booking
            if (in_array("cab", $booking_type)) {

                foreach ($booking->cabs as $key => $cab) {
                    $pdf                        = Pdf::loadView('bookings.package.voucher-cab', compact('booking', 'cab', 'terms', 'inclusions', 'exclusions', 'company'));
                    Storage::put('public/uploads/bookings/vouchers/' . $id . '/Cab-voucher' . $key . '.pdf', $pdf->output());
                    $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Cab-voucher' . $key . '.pdf', 'all');
                }
            }

            if (in_array("hotel", $booking_type)) {

                foreach ($booking->hotels as $key => $hotel) {
                    $pdf                        = Pdf::loadView('bookings.package.voucher-hotel', compact('booking', 'hotel', 'terms', 'inclusions', 'exclusions', 'company'));
                    Storage::put('public/uploads/bookings/vouchers/' . $id . '/Hotel-voucher' . $key . '.pdf', $pdf->output());
                    $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Hotel-voucher' . $key . '.pdf', 'all');
                }
            }

                // safari-booking
            if (in_array("safari", $booking_type)) {

                foreach ($booking->safaris as $key => $safari) {
                    $pdf                        = Pdf::loadView('bookings.package.voucher-safari', compact('booking', 'safari', 'terms', 'inclusions', 'exclusions', 'company'));
                    Storage::put('public/uploads/bookings/vouchers/' . $id . '/Safari-voucher' . $key . '.pdf', $pdf->output());
                    $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Safari-voucher' . $key . '.pdf', 'all');
                }
            }

                // Create an instance of PDFMerger





            $oMerger->merge();
            $oMerger->save(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf', 'file');
            $path = public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf';
            $filename                   = 'Package-voucher.pdf';
            try {
                $results = Mail::send('emails.voucher', $data, function ($message) use ($data, $path, $filename) {
                    $message->from('contact@junglesafariindia.in')
                    ->to($data["email"])
                    ->subject($data["title"])
                    ->attach($path);
                });

                $comment                = new LeadComment();
                $comment->lead_id       = $booking->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "voucher sent";
                $comment->comment       = "Package Vouchers has been sent to customer email by " . Auth::user()->name;
                $comment->save();
                UserActivity::create([
                    'user_id' => Auth::user()->id,
                    'type'    => 'voucher sent',
                    'comment' => 'Package Booking vouchers has been sent via email for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
                ]);
                return redirect()->back()->with('voucher', 'Voucher has been sent to customer successfully');
            } catch (HttpException $ex) {
                return $ex;
            }
            break;
        }
    }

    public function generatePermitLink(Request $request)
    {
        $link = new PermitLink;
        $link->date = date('Y-m-d');
        $link->slug = Str::random(40);
        $link->booking_ids = $request->booking_ids;
        $link->safari_date = $request->filter_date;
        $link->save();

        return Response()->json($link->slug);
    }

    public function getPermits($slug)
    {
        $link_exists = PermitLink::where('slug', $slug)->exists();
        if ($link_exists) {
            $link = PermitLink::where('slug', $slug)->first();
            $bookings = Booking::whereIn('id', $link->booking_ids)->get();
            return view('bookings.permit', compact('link', 'bookings'));
        } else {
            abort('404');
        }
    }

    public function downloadPermit($id)
    {
        $booking = Booking::find($id);
        $permits = BookingSafariPermit::where('booking_id', $id)->get();
        $oMerger = PDFMerger::init();
        foreach ($permits as $permit) {
            $oMerger->addPDF(public_path() . '/storage/uploads/bookings/permits/' . $id . '/' . $permit->permit, 'all');
        }


        $oMerger->merge();
        $oMerger->save(public_path() . '/storage/uploads/bookings/permits/' . $id . '/' . $booking->customer->name . '.pdf', 'file');
        $path = public_path() . '/storage/uploads/bookings/permits/' . $id . '/' . $booking->customer->name . '.pdf';
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    public function downloadPackagePermit($id)
    {
        $safari  = BookingSafari::where('id', $id)->first();
        $booking = Booking::find($safari->booking_id);
        $permits = BookingSafariPermit::where('booking_id', $safari->booking_id)->where('safari_id', $id)->get();
        $oMerger = PDFMerger::init();
        foreach ($permits as $permit) {
            $oMerger->addPDF(public_path() . '/storage/uploads/bookings/permits/package/' . $safari->booking_id . '/' . $permit->permit, 'all');
        }


        $oMerger->merge();
        $oMerger->save(public_path() . '/storage/uploads/bookings/permits/package/' . $safari->booking_id . '/' . $booking->customer->name . '.pdf', 'file');
        $path = public_path() . '/storage/uploads/bookings/permits/package/' . $safari->booking_id . '/' . $booking->customer->name . '.pdf';
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    public function downloadTourPermit($id)
    {
        $safari  = BookingSafari::where('id', $id)->first();
        $booking = Booking::find($safari->booking_id);

        $permits = BookingSafariPermit::where('booking_id', $safari->booking_id)->where('safari_id', $id)->get();
        $oMerger = PDFMerger::init();
        foreach ($permits as $permit) {
            $oMerger->addPDF(public_path() . '/storage/uploads/bookings/permits/' . $safari->booking_id . '/' . $permit->permit, 'all');
        }


        $oMerger->merge();
        $oMerger->save(public_path() . '/storage/uploads/bookings/permits/' . $safari->booking_id . '/' . $booking->customer->name . '.pdf', 'file');
        $path = public_path() . '/storage/uploads/bookings/permits/' . $safari->booking_id . '/' . $booking->customer->name . '.pdf';
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    public function cancelBooking(Request $request)
    {
        $cancel_exists =  BookingCancel::where('booking_id', $request->booking_id)->exists();

        if ($cancel_exists) {

            $cancel_id =  BookingCancel::where('booking_id', $request->booking_id)->value('id');
            $cancel_data = BookingCancel::find($cancel_id);
            $cancel_data->booking_id = $request->booking_id;
            $cancel_data->reason = $request->reason;
            $cancel_data->cancellation_charges = $request->cancellation_charges;
            $cancel_data->permit_cancellation_charges = $request->permit_cancellation_charges;
            $cancel_data->save();
        } else {

            $cancel_data = new BookingCancel;
            $cancel_data->booking_id = $request->booking_id;
            $cancel_data->reason = $request->reason;
            $cancel_data->cancellation_charges = $request->cancellation_charges;
            $cancel_data->permit_cancellation_charges = $request->permit_cancellation_charges;
            $cancel_data->save();
        }

        return redirect()->route('bookings.index')->with('success', 'Booking cancel successfully.');;
    }
    public function cancelBookingRequest(Request $request){

        $cancellation_request = BookingCancellationRequest::find($request->request_id);
        $cancel_exists =  BookingCancel::where('booking_id', $cancellation_request->booking_id)->exists();

        if ($cancel_exists) {
            
            $cancel_id =  BookingCancel::where('booking_id', $cancellation_request->booking_id)->value('id');
            $cancel_data = BookingCancel::find($cancel_id);
            $cancel_data->booking_id = $cancellation_request->booking_id;
            $cancel_data->reason = $request->reason;
            $cancel_data->cancellation_charges = $request->cancellation_charges;
            $cancel_data->permit_cancellation_charges = $request->permit_cancellation_charges;
            $cancel_data->save();
        } else {

            $cancel_data = new BookingCancel;
            $cancel_data->booking_id = $cancellation_request->booking_id;
            $cancel_data->reason = $request->reason;
            $cancel_data->cancellation_charges = $request->cancellation_charges;
            $cancel_data->permit_cancellation_charges = $request->permit_cancellation_charges;
            $cancel_data->save();
            UserActivity::create([
                    'user_id' => Auth::user()->id,
                    'type'    => 'Booking Cancel',
                    'comment' => 'Booking has been cancel <a href="'.route('bookings.show', $cancellation_request->booking_id).'">Booking No. '.$cancellation_request->booking_id.'</a>'
                ]);
        }

        $cancellation_request->update(['status'=> true]);

        return redirect()->back()->with('success', 'Booking cancel successfully.');
    }

    public function countries(Request $request)
    {
        $html = '';


        if ($request->nationality == 'Foreigner') {
            $countries = Country::get(['country']);
            foreach ($countries as $country) {
                $html .= '<option value=' . $country->country . '>' . $country->country . '</option>';
            }
        }

        if ($request->nationality == 'Indian') {
            $states = State::get(['state']);

            foreach ($states as $state) {
                $html .= '<option value=' . $state->state . '>' . $state->state . '</option>';
            }
        }
        return response()->json($html);
    }

    public function sendLink($id)
    {

        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
        $booking                    = Booking::find($id);
        switch ($booking->type) {
            case 'cab':
            $shortURLObject = $builder->destinationUrl(route('cab-booking.voucher', $id))->make();
            $shortURL = $shortURLObject->default_short_url;
            break;

            case 'hotel':
            $shortURLObject = $builder->destinationUrl(route('hotel-booking.voucher', $id))->make();
            $shortURL = $shortURLObject->default_short_url;
            break;

            case 'safari':
            $shortURLObject = $builder->destinationUrl(route('safari-booking.voucher', $id))->make();
            $shortURL = $shortURLObject->default_short_url;
            break;

            case 'tour':
            $shortURLObject = $builder->destinationUrl(route('tour-booking.voucher', $id))->make();
            $shortURL = $shortURLObject->default_short_url;
            break;
            case 'package':
            $shortURLObject = $builder->destinationUrl(route('package-booking.voucher', $id))->make();
            $shortURL = $shortURLObject->default_short_url;
            break;
        }

        return view('bookings.send-link', compact('shortURL', 'booking'));
    }

    public function sendWhatsappMessage(Request $request)
    {
        $booking = Booking::find($request->id)->load('customer','lead');

        $name = @$booking->lead->user->name;
        $mobile = @$booking->lead->user->phone;



        switch ($booking->type) {
            case 'cab':
            $path = 'storage/uploads/bookings/vouchers/'.$booking->id.'/vouchers.pdf';
            break;

            case 'hotel':
            $path = 'storage/uploads/bookings/vouchers/'.$booking->id.'/Hotel-voucher.pdf';
            break;

            case 'safari':
            $path = 'storage/uploads/bookings/vouchers/'.$booking->id.'/Safari-voucher.pdf';
            break;

            case 'tour':
            $path = 'storage/uploads/bookings/vouchers/'.$booking->id.'/Tour-voucher.pdf';
            break;
            case 'package':
            $path = 'storage/uploads/bookings/vouchers/'.$booking->id.'/vouchers.pdf';
            break;
        }

        $this->createAndSaveBoucher($booking->type, $booking->id);
        

        $ch = curl_init();

        $mobile_no = $booking->customer->mobile;

        $params = [
            "messaging_product" => "whatsapp", 
            "recipient_type" => "individual", 
            "to" => (strlen($mobile_no) <=10) ? '91'.$mobile_no : $mobile_no,
            "type" => "template", 
            "template" => [
                "name" => "booking_voucher", 
                "language" => [
                    "code" => "en_US"
                ], 
                "components" => [
                    [
                        "type" => "header", 
                        "parameters" => [
                            [
                                "type" => "text", 
                                "text" => @$booking->customer->name 
                            ] 
                        ]
                    ],
                    [
                        "type" => "body", 
                        "parameters" => [                           
                            [
                                "type" => "text", 
                                "text" => @$name ?? 'Abhishek'
                            ],
                            [
                                "type" => "text", 
                                "text" => @$mobile ?? "919971717045"
                            ],
                        ] 
                    ],
                    [
                        "type" => "button", 
                        "sub_type" => "url",
                        "index" => 0,
                        "parameters" => [
                            [
                                "type" => "text", 
                                "text" => @$path 
                            ] 
                        ] 
                    ] 
                ] 
            ] 
        ]; 

        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v16.0/'.env('WHATSAPP_API_CODE').'/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $headers = array();
        $headers[] = 'Authorization: Bearer '.env('WHATSAPP_API_SECRET');
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $data = json_decode($result, 1);

        curl_close($ch);

        if ($data && isset($data['error']) && !empty( $data['error'])) {

            return redirect()->route('bookings.send-voucher-link',$request->id)->with('error', $data['error']['message']);
        }
        
        $booking->share_count = ($booking->share_count)?($booking->share_count+1):1;
        $booking->save();
        $comment                = new LeadComment();
        $comment->lead_id       = $booking->lead_id;
        $comment->comment_by    = Auth::user()->id;
        $comment->type          = "voucher sent";
        $comment->comment       = "Voucher has been sent to customer number whatsapp  by " . Auth::user()->name;
        $comment->save();

        return redirect()->route('bookings.send-voucher-link',$request->id)->with('success', 'message sent successfully');
    }

    public function createAndSaveBoucher($type, $id)
    {

        $booking                    = Booking::find($id)->load('customer', 'user', 'cab', 'hotel', 'safari', 'items', 'customer_details');
        $booking->mail_sent         = 'yes';
        $booking->save();
        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/' . $company->logo) : '';
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();

        switch ($type) {
            case 'cab':

            $booking_cab                = BookingCab::where('booking_id', $id)->get()->toArray();

            $pdf                        = Pdf::loadView('bookings.cab.voucher', compact('booking', 'terms', 'company', 'booking_cab', 'inclusions', 'exclusions'));

            Storage::put('public/uploads/bookings/vouchers/' . $id . '/Cab-voucher.pdf', $pdf->output());

            break;

            case 'hotel':

            $pdf                        = Pdf::loadView('bookings.hotel.voucher', compact('booking', 'terms', 'company', 'inclusions', 'exclusions'));
            Storage::put('public/uploads/bookings/vouchers/' . $id . '/Hotel-voucher.pdf', $pdf->output());

            break;

            case 'safari':

            $pdf                        = Pdf::loadView('bookings.safari.voucher', compact('booking', 'terms', 'company', 'inclusions', 'exclusions'));
            Storage::put('public/uploads/bookings/vouchers/' . $id . '/Safari-voucher.pdf', $pdf->output());
            $filename                   = 'Safari-voucher.pdf';

            break;

            case 'tour':
            $booking_type               = bookingType($id);
            $oMerger = PDFMerger::init();
                // cab-booking
            if (in_array("cab", $booking_type)) {

                $pdf                        = Pdf::loadView('bookings.cab.voucher', compact('booking', 'terms', 'inclusions', 'exclusions', 'company'));
                Storage::put('public/uploads/bookings/vouchers/' . $id . '/Cab-voucher.pdf', $pdf->output());
                $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Cab-voucher.pdf', 'all');
            }

                //hotel-booking
            if (in_array("hotel", $booking_type)) {

                $pdf                        = Pdf::loadView('bookings.hotel.voucher', compact('booking', 'terms', 'inclusions', 'exclusions', 'company'));
                Storage::put('public/uploads/bookings/vouchers/' . $id . '/Hotel-voucher.pdf', $pdf->output());
                $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Hotel-voucher.pdf', 'all');
            }

                // safari-booking
            if (in_array("safari", $booking_type)) {

                foreach ($booking->safaris as $key => $safari) {
                    $pdf                        = Pdf::loadView('bookings.tour.voucher-safari', compact('booking', 'safari', 'terms', 'inclusions', 'exclusions', 'company'));
                    Storage::put('public/uploads/bookings/vouchers/' . $id . '/Safari-voucher' . $key . '.pdf', $pdf->output());
                    $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Safari-voucher' . $key . '.pdf', 'all');
                }
            }
            $filename                   = 'Tour-voucher.pdf';

            $oMerger->merge();
            $oMerger->save(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf', 'file');
            $path = public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf';

            break;
            case 'package':
            $oMerger = PDFMerger::init();
            $data["email"] = $booking->customer->email;
            $data["title"] = "Booking Voucher (" . $company->name . ")";
            $booking_type = bookingType($id);
                // cab-booking
            if (in_array("cab", $booking_type)) {

                foreach ($booking->cabs as $key => $cab) {
                    $pdf                        = Pdf::loadView('bookings.package.voucher-cab', compact('booking', 'cab', 'terms', 'inclusions', 'exclusions', 'company'));
                    Storage::put('public/uploads/bookings/vouchers/' . $id . '/Cab-voucher' . $key . '.pdf', $pdf->output());
                    $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Cab-voucher' . $key . '.pdf', 'all');
                }
            }

            if (in_array("hotel", $booking_type)) {

                foreach ($booking->hotels as $key => $hotel) {
                    $pdf                        = Pdf::loadView('bookings.package.voucher-hotel', compact('booking', 'hotel', 'terms', 'inclusions', 'exclusions', 'company'));
                    Storage::put('public/uploads/bookings/vouchers/' . $id . '/Hotel-voucher' . $key . '.pdf', $pdf->output());
                    $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Hotel-voucher' . $key . '.pdf', 'all');
                }
            }

                // safari-booking
            if (in_array("safari", $booking_type)) {

                foreach ($booking->safaris as $key => $safari) {
                    $pdf                        = Pdf::loadView('bookings.package.voucher-safari', compact('booking', 'safari', 'terms', 'inclusions', 'exclusions', 'company'));
                    Storage::put('public/uploads/bookings/vouchers/' . $id . '/Safari-voucher' . $key . '.pdf', $pdf->output());
                    $oMerger->addPDF(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/Safari-voucher' . $key . '.pdf', 'all');
                }
            }

            $oMerger->merge();
            $oMerger->save(public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf', 'file');
            $path = public_path() . '/storage/uploads/bookings/vouchers/' . $id . '/vouchers.pdf';
            $filename                   = 'Package-voucher.pdf';
            break;
        }
    }

    public function cancellationRequests(Request $request){
        $filter_name                = $request->filter_name;      
        $filter_mobile              = $request->filter_mobile; 
        $filter_type                = $request->filter_type;            
        $filter_date                = $request->filter_date;      
        $filter_request_status      = $request->filter_request_status;
        $filter_created_at          = $request->filter_created_at; 
        $filter_updated_at          = $request->filter_updated_at; 

        DB::table('booking_cancellation_requests')->where('seen', false)->update(['seen'=> true]);
        $requests = BookingCancellationRequest::with('booking', 'customer');

        if (isset($filter_name)) {
            $requests = $requests->whereHas('customer', function ($q) use ($filter_name) {
                $q->where(function ($q) use ($filter_name) {
                    $q->where('name', 'LIKE', '%' . $filter_name . '%');
                });
            });
        }
       

        if (isset($filter_mobile)) {
            $requests = $requests->whereHas('customer', function ($q) use ($filter_mobile) {
                $q->where(function ($q) use ($filter_mobile) {
                    $q->where('mobile', 'LIKE', '%' . $filter_mobile . '%');
                });
            });
        }

        if (isset($filter_type)) {
            $requests = $requests->whereHas('booking', function ($q) use ($filter_type) {
                $q->where(function ($q) use ($filter_type) {
                    $q->where('type', 'LIKE', '%' . $filter_type . '%');
                });
            });
        }

        if (isset($filter_type)) {
            $requests = $requests->whereHas('booking', function ($q) use ($filter_type) {
                $q->where(function ($q) use ($filter_type) {
                    $q->where('type', 'LIKE', '%' . $filter_type . '%');
                });
            });
        }

        if (isset($filter_date)) {
            $requests = $requests->whereHas('booking', function ($q) use ($filter_date) {
                $q->where(function ($q) use ($filter_date) {
                    $q->where('created_at', 'LIKE', '%' . $filter_date . '%');
                });
            });
        }

        if (isset($filter_created_at)) {
            $requests = $requests->whereDate('created_at', $filter_created_at);
        }

        if (isset($filter_updated_at)) {
            $requests = $requests->whereDate('updated_at', $filter_updated_at);
        }

        if (isset($filter_request_status)) {
            $requests = $requests->where('status', $filter_request_status);
        }

        $requests = $requests->latest()->paginate(20);
        return view('bookings.cancel',  compact('requests', 'filter_name', 'filter_mobile', 'filter_date', 'filter_request_status', 'filter_created_at', 'filter_updated_at', 'filter_type'));
    }

    public function getBookingByCustomer(Request $request){
        $bookings = Booking::where('customer_id',$request->customer_id)->latest()->get();

        return response()->json([
                        'bookings' => $bookings,
                        'status' => 200,
                    ]);
    }

    public function approvalAmount(Request $request){
       

        $cr = BookingCancellationRequest::find($request->request_id);

        BookingCancellationRequest::where('id',$request->request_id)->update([
           'approval_amount' => $request->amount,
           'approval_status' => 0
        ]);

        RefundHistory::create([

            'booking_id' => $cr->booking_id,
            'customer_id' => $cr->customer_id,
            'admin_id'    => Auth::user()->id,
            'cancellation_id' => $cr->id,
            'note'            => $request->note,
            'amount'          => $request->amount,
            'status'          => 'Generated'

        ]);

        return redirect()->back()->with('success','Amount added successfully for approval');
    }

    public function trackRefund($id){

        $history = RefundHistory::where('booking_id',$id)->orderBy('id','desc')->paginate(10);
        
        return view('bookings.refund-track',compact('history'));

    }

}
