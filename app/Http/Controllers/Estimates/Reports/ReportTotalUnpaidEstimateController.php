<?php

namespace App\Http\Controllers\Estimates\Reports;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use App\Models\EstimateCab;
use App\Models\EstimateCabOption;
use App\Models\EstimateHotel;
use App\Models\EstimateHotelOption;
use App\Models\EstimateInclusion;
use App\Models\EstimateSafari;
use App\Models\EstimateSafariOption;
use App\Models\EstimateTerm;
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

class ReportTotalUnpaidEstimateController extends Controller
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
        ->setTitle('Unpaid Estimates')
        ->addData('No. of Unpaid Estimate', $countForChart)
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

        $filter_name                = $request->filter_name;
        $filter_customer            = $request->filter_customer;
        $filter_mobile              = $request->filter_mobile;
        $filter_user                = $request->filter_user;
        $filter_payment_status      = $request->filter_payment_status;
        $filter_sanctuary           = $request->filter_sanctuary;
        $filter_estimate_status     = $request->filter_estimate_status;
        $filter_daterange           = $request->filter_daterange;


          $reports_estimates = Estimate::with('customer', 'user');

          if(isset($filter_name)) {
            $reports_estimates->whereHas('customer', function($q) use ($filter_name) {
                $q->where(function($q) use ($filter_name) {
                    $q->where('name', 'LIKE', '%' . $filter_name . '%');
                });
            });
          }

          if(isset($filter_customer)) {
            $reports_estimates->whereHas('customer', function($q) use ($filter_customer) {
                $q->where(function($q) use ($filter_customer) {
                    $q->where('id', $filter_customer);
                });
            });
          }

          if(isset($filter_mobile)) {
            $reports_estimates->whereHas('customer', function($q) use ($filter_mobile) {
                $q->where(function($q) use ($filter_mobile) {
                    $q->where('mobile', 'LIKE', '%' . $filter_mobile . '%');
                });
            });
          }

          if(isset($filter_daterange)) {
            $dateArray = explode(' - ', $filter_daterange);
            $reports_estimates->whereBetween('date',  [$dateArray[0], trim($dateArray[1])]);
        }

          if(isset($filter_user)) {
           $reports_estimates->where('assigned_to',$filter_user);
          }
          if(isset($filter_payment_status)) {
            if($filter_payment_status=='partially_paid'){
           $reports_estimates->where('payment_status','partially paid');
           } else {
             $reports_estimates->where('payment_status',$filter_payment_status);
           }
         }

          if(isset($filter_sanctuary)) {
            $reports_estimates->whereHas('safari', function($q) use ($filter_sanctuary) {
                $q->where(function($q) use ($filter_sanctuary) {
                    $q->where('sanctuary', 'LIKE', '%' . $filter_sanctuary . '%');
                });
            });
          }
          if(isset($filter_estimate_status)) {
           $reports_estimates->where('estimate_status',$filter_estimate_status);
         }

         if(Auth::user()->hasAnyRole('administrator|team lead|agent')){

          $reports_estimates = $reports_estimates->where('payment_status', 'unpaid')->latest()->paginate(150);
          $chart = $this->build($reports_estimates);

          }elseif(Auth::user()->hasRole('fresher')){

              $reports_estimates = $reports_estimates->where('payment_status', 'unpaid')->latest()->paginate(150);

          } else {
              $reports_estimates = $reports_estimates->where('assigned_to', Auth::user()->id)->where('payment_status', 'unpaid')->latest()->paginate(150);

          }

        return view('reports.totalunpaidestimate', compact('chart', 'users', 'filter_sanctuary', 'reports_estimates', 'filter_name', 'filter_daterange', 'filter_user', 'filter_payment_status', 'filter_estimate_status', 'filter_mobile'));
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
