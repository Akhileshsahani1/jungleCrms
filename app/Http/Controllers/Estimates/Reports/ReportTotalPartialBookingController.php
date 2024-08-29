<?php

namespace App\Http\Controllers\Estimates\Reports;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Booking;
use App\Models\BookingCab;
use App\Models\BookingHotel;
use App\Models\BookingItem;
use App\Models\BookingSafari;
use App\Models\BookingSafariCustomer;
use App\Models\BookingSafariPermit;
use App\Models\PermitLink;
use App\Models\BookingCancel;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\State;
use App\Models\Company;
use App\Models\Term;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Vendor;
use ArielMejiaDev\LarapexCharts\LarapexChart;


class ReportTotalPartialBookingController extends Controller
{
    public function __construct(LarapexChart $chart)
    {
        // Middleware only applied to these methods
        $this->middleware('auth', [
            'only' => [
                'index' // Could add bunch of more methods too
            ]
        ]);

        $this->chart = $chart;
    }

    public function build($data): \ArielMejiaDev\LarapexCharts\BarChart
    {

        $date = array();
        $booking_date = array();
        $countdate = array();
        foreach($data as $row) {
            $date[] = $row['date'];
            $countdate[$row['date']][] = $row['date'];
        }

        $ndate = array_reverse(array_values(array_unique($date)));
        $countForChart = array();
        foreach(array_reverse($countdate) as $key => $value) {
            $countForChart[] = count($value);
        }
       $newDate = implode(',', array_map(function($i){return "'".$i."'";}, $ndate));

        return $this->chart->barChart()
        ->setTitle('Partial Bookings')
        ->addData('No of Partial Booking', $countForChart)
        ->setXAxis($ndate)
        ->setGrid();

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
        $filter_daterange           = $request->filter_daterange;

        $bookings = Booking::with('customer', 'user', 'safari');
        if (isset($filter_name)) {
            $bookings->whereHas('customer', function ($q) use ($filter_name) {
                $q->where(function ($q) use ($filter_daterangefilter_name) {
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

        if(isset($filter_daterange)) {
            $dateArray = explode(' - ', $filter_daterange);
            $bookings->whereBetween('date',  [$dateArray[0], trim($dateArray[1])]);
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
            $bookings = $bookings->where('payment_status' , 'partially paid')->latest()->paginate(150);
            $chart = $this->build($bookings);
            
        } elseif (Auth::user()->hasRole('fresher')) {
            $bookings = $bookings->where('payment_status' , 'partially paid')->latest()->paginate();
        } else {
            $bookings = $bookings->where('assigned_to', Auth::user()->id)->where('payment_status' , 'partially paid')->latest()->paginate(150);
        }

        $totalBookingPartialPaidAmount = 0;
        foreach($bookings as $booking) {
            if($booking['payment_status'] == 'partially paid') {
                $totalBookingPartialPaidAmount = $totalBookingPartialPaidAmount + $booking->items->sum('amount');
            }
        }

        return view('reports.totalpartialbooking', compact('totalBookingPartialPaidAmount','chart', 'filter_date',  'filter_name' , 'filter_daterange', 'filter_time', 'filter_order_date', 'filter_user', 'filter_type', 'filter_sanctuary', 'filter_booking_status', 'filter_payment_status', 'users', 'bookings', 'filter_mobile', 'vendors', 'filter_vendor', 'filter_permit_uploaded'));
       
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
        $estimate = Estimate::find($id);
        switch ($estimate->type) {
            case 'cab':
                return redirect()->route('cab-estimate.show', $id);
                break;
            case 'hotel':
                return redirect()->route('hotel-estimate.show', $id);
                break;
            case 'safari':
                return redirect()->route('safari-estimate.show', $id);
                break;
            case 'tour':
                return redirect()->route('tour-estimate.show', $id);
                break;
            case 'package':
                return redirect()->route('package-estimate.show', $id);
                break;
        }


        return redirect()->route('estimates.index')->with('error', 'Something went wrong.');
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

    
}
