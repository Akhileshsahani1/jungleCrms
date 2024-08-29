<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use App\Models\LeadReminder;
use App\Models\LeadStatus;
use App\Models\User;
use App\Models\CountryState;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // All Counts

        $customers_count        = Customer::count();
        $statuses               = LeadStatus::get(['id', 'name']);

        // Today's Count

        $customers_today        = Customer::whereDate('created_at', Carbon::today())->count();

        $leads                  = Lead::with('user','estimate', 'booking');
        $bookings               = Booking::with('customer', 'user', 'safari');
        $estimates              = Estimate::with('customer', 'user');
 
        $m_ls = [];
        $d_m_bs = [];
        $c_m_bs = [];
        $direct_bookings=0;
        $converted_bookings=0;
        $admin=false;
        $previous_months=[];
        if (Auth::user()->hasAnyRole('administrator|team lead|agent')) {
            $leads_count            = Lead::count();
            $estimates_count        = Estimate::count();
            $bookings_count         = Booking::count();

            $leads_today            = Lead::whereDate('created_at', Carbon::today())->count();
            $estimates_today        = Estimate::whereDate('created_at', Carbon::today())->count();
            $bookings_today         = Booking::whereDate('created_at', Carbon::today())->count();

            $leads              = $leads->latest()->take(10)->get();
            $estimates          = $estimates->latest()->take(10)->get();
            $bookings           = $bookings->latest()->take(10)->get();
            // graph code start here
            if (Auth::user()->hasRole('administrator')){
                 $admin=true;

                $direct_bookings          = Booking::where('source','direct')->count();
                $converted_bookings       = Booking::where('source','converted')->count();
                $direct_monthly_bookings  = Booking::select(
                                    DB::raw("(COUNT(*)) as count"),
                                    DB::raw("MONTHNAME(created_at) as month_name")
                                )
                                ->where('source','direct')
                                ->whereYear('created_at', date('Y'))
                                ->groupBy('month_name')
                                ->get()
                                ->toArray();
                $converted_montly_bookings = Booking::select(
                                    DB::raw("(COUNT(*)) as count"),
                                    DB::raw("MONTHNAME(created_at) as month_name")
                                )
                                ->where('source','converted')
                                ->whereYear('created_at', date('Y'))
                                ->groupBy('month_name')
                                ->get()
                                ->toArray();
                $currentDate = Carbon::now()->startOfMonth();
                while ($currentDate->year == Carbon::now()->year) {
                  $previous_months[] = $currentDate->format('F');
                  $currentDate->subMonth();
                } 
                $previous_months = array_reverse($previous_months);
                $d_m_b = [];
                foreach($direct_monthly_bookings as $month){
                       $d_m_b[$month['month_name']]=$month['count'];
                }
                $c_m_b = [];
                foreach($converted_montly_bookings as $month){
                       $c_m_b[$month['month_name']]=$month['count'];
                }
                foreach($previous_months as $pvm){
                       $d_m_bs[]=(isset($d_m_b[$pvm]))?$d_m_b[$pvm]:0;
                       $c_m_bs[]=(isset($c_m_b[$pvm]))?$c_m_b[$pvm]:0;
                }
            //end graph code

            }
        } elseif (Auth::user()->hasRole('fresher')) {
            $leads_count            = Lead::count();
            $estimates_count        = Estimate::count();
            $bookings_count         = Booking::count();
            $leads_today            = Lead::whereDate('created_at', Carbon::today())->count();
            $estimates_today        = Estimate::whereDate('created_at', Carbon::today())->count();
            $bookings_today         = Booking::whereDate('created_at', Carbon::today())->count();
            $leads              = $leads->latest()->take(10)->get();
            $estimates          = $estimates->latest()->take(10)->get();
            $bookings           = $bookings->latest()->take(10)->get();
        } else {
            $roles              = Auth::user()->roles->pluck('name')->toArray();
            $leads_count            = Lead::whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id, 2])->count();
            $estimates_count        = Estimate::where('assigned_to', Auth::user()->id)->count();
            $bookings_count         = Booking::where('assigned_to', Auth::user()->id)->count();

            $leads_today            = Lead::whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id, 2])->whereDate('created_at', Carbon::today())->count();
            $estimates_today        = Estimate::whereIn('assigned_to', [Auth::User()->id])->whereDate('created_at', Carbon::today())->count();
            $bookings_today         = Booking::whereIn('assigned_to', [Auth::User()->id])->whereDate('created_at', Carbon::today())->count();

            $leads              = $leads->whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id, 2])->latest()->take(10)->get();
            $estimates          = $estimates->where('assigned_to', Auth::user()->id)->latest()->take(10)->get();
            $bookings           = $bookings->where('assigned_to', Auth::user()->id)->latest()->take(10)->get();
        }
         if( $admin){
             $follow_ups =  LeadFollowUp::whereDate('datetime', Carbon::now()->format('Y-m-d'))->where('done', false)->get();
         }else{
            $follow_ups =  LeadFollowUp::where('user_id', Auth::user()->id)->whereDate('datetime', Carbon::now()->format('Y-m-d'))->where('done', false)->get();
        }

        return view('dashboard', compact('leads_count', 'estimates_count', 'bookings_count', 'customers_count', 'leads_today', 'estimates_today', 'bookings_today', 'customers_today', 'leads', 'estimates', 'bookings','direct_bookings','converted_bookings','previous_months','d_m_bs','c_m_bs','admin','statuses', 'follow_ups'));
    }

    public function reminder(Request $request)
    {
        $userId     = Auth::user()->id;
        $reminders  = LeadReminder::with('lead');
        $reminders->where('receiver', $userId);
        $reminders->where('seen', 0);
        $reminders->whereDate('datetime', Carbon::now()->toDateString());
        $reminders->whereTime('datetime', '<', Carbon::now()->toTimeString());
        $reminders  = $reminders->latest()->get();

        foreach ($reminders as $reminder) {
            $reminder->receiver_name    = User::find($reminder->receiver)->name;
            $reminder->sender_name      = User::find($reminder->sender)->name;
        }

        $now =  Carbon::now()->format('d-m-Y g:i:A');

        if (count($reminders) < 1) {
            $output = '<span class="dropdown-item dropdown-header"><strong>Notifications</strong></span>';
            $output .= '<div class="dropdown-divider"></div>';
            $output .= '<a href="javascript:void(0)" class="dropdown-item dropdown-footer">No New Notifications</a>';
        } else {

            $output = '';
            $output .= '<span class="dropdown-item dropdown-header"><strong>Notifications</strong></span>';
            $output .= '<div class="dropdown-divider"></div>';

            foreach ($reminders as $reminder) {
                $route = route('leads.show', ['lead' => $reminder->lead_id, 'reminder_id' => $reminder->id]);
                $output .= '<div class="media">';
                $output .= ' <i class="far fa-bell mr-2 mt-3 ml-2" style="text-align:center;width: 2.0rem;"></i>';
                $output .= '<div class="media-body">';
                $output .= '<h3 class="dropdown-item-title">';
                $output .=  $reminder->sender_name;
                $output .= '</h3>';
                $output .= '<a href="' . $route . '"><p class="text-sm">Please Check Lead for <strong>' . $reminder->lead->website . '</strong></p></a>';
                $output .= '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ' . $now . '</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="dropdown-divider"></div>';
            }
        }

        return response()->json($output);
    }
    public function getLeadData_old(Request $request) //Renamed By Shahwaj ON 17 Oct, 2023
    {
            $status = $request->lead_status;
            $total_leads = ($status)?Lead::where('lead_status',$status)->count():Lead::count();
           
            if($status){
               $current_month = Lead::select('*')->where('lead_status',$status)
                ->whereMonth('created_at', Carbon::now()->month)
            ->count();
            }else{
                $current_month = Lead::select('*')
                 ->whereMonth('created_at', Carbon::now()->month)
            ->count();
            }
           

            if($status){
               $total_previous_month_lead = Lead::select('*')->where('lead_status',$status)->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();
            }else{
                $total_previous_month_lead = Lead::select('*')->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();
            }
            
             if($status){
            $month_leads = Lead::select(
                                    DB::raw("(COUNT(*)) as count"),
                                    DB::raw("MONTHNAME(created_at) as month_name"),
                                
                                )
                                  ->where('lead_status',$status)
                                ->whereYear('created_at', date('Y'))
                                ->groupBy('month_name')
                                ->get()
                                ->toArray();
            }else{
                 $month_leads = Lead::select(
                                    DB::raw("(COUNT(*)) as count"),
                                    DB::raw("MONTHNAME(created_at) as month_name"),
                                )
                                ->whereYear('created_at', date('Y'))
                                ->groupBy('month_name')
                                ->get()
                                ->toArray();
            }
            $currentDate = Carbon::now()->startOfMonth();
            while ($currentDate->year == Carbon::now()->year) {
              $previous_months[] = $currentDate->format('F');
              $currentDate->subMonth();
            } 
            $previous_months = array_reverse($previous_months);
            $m_l = [];
            foreach($month_leads as $month){
                   $m_l[$month['month_name']]=$month['count'];
            }
            $m_ls = [];
            foreach($previous_months as $m){
                       $m_ls[]=(isset($m_l[$m]))?$m_l[$m]:0;
                }
            $output = array(
                'total_leads'=>$total_leads,
                'current_month'=>$current_month,
                'total_previous_month_lead'=>$total_previous_month_lead,
                'previous_months'=>$previous_months,
                'm_ls'  => $m_ls,

            );

         return response()->json($output);
    }
    public function getLeadData(Request $request)
    {
            $status     = $request->lead_status;
            
           
            if($status){

                $fromDate   = explode("/", $request->fromDate);
                $toDate     = explode("/", $request->toDate);
                $from       = $fromDate[2]."-".$fromDate[1]."-".$fromDate[0] ." 00:00:00";
                $to         = $toDate[2]."-".$toDate[1]."-".$toDate[0] ." 23:59:59";
                $total_leads = Lead::where('lead_status',$status)->whereBetween('created_at', [$from, $to])->count();
                $selected_leads =  Lead::selectRaw("(COUNT(*)) as count, DATE_FORMAT(created_at, '%d-%m-%Y') as date")
                        ->whereBetween('created_at', [$from, $to])
                        ->where('lead_status',$status)
                        ->groupByRaw("DATE_FORMAT(created_at, '%d-%m-%Y')")

                        ->get()->toArray();
                        // print_r($selected_leads);die;
            }else{
                $total_leads = Lead::where('lead_status',4)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
                 $selected_leads = Lead::selectRaw("(COUNT(*)) as count, DATE_FORMAT(created_at, '%d-%m-%Y') as date")
                                ->where('lead_status',4)
                                ->whereMonth('created_at', date('m'))
                                ->whereYear('created_at', date('Y'))
                                ->groupByRaw("DATE_FORMAT(created_at, '%d-%m-%Y')")
                                ->get()
                                ->toArray();
                                
            }
            $m_l = [];
            $m_c = [];
            foreach($selected_leads as $month){
                $m_l[]=$month['date'];
                $m_c[]=$month['count'];
            }
            $colors = [];
            for ($i=0; $i<count($selected_leads); $i++) {
                $colors[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
            }
            $output = array(
                'total_leads'=>$total_leads,
                'selected_leads'=>$selected_leads,
                "colors"    => $colors,
                "m_l"    => $m_l,
                "m_c"    => $m_c,

            );
            // dd($output);

         return response()->json($output);
    }
    public function getSaleData(Request $request)
    {
          
        if($request->type!="sale"){
            $fromDate   = explode("/", $request->fromDate);
            $toDate     = explode("/", $request->toDate);
            $from       = $fromDate[2]."-".$fromDate[1]."-".$fromDate[0] ." 00:00:00";
            $to         = $toDate[2]."-".$toDate[1]."-".$toDate[0] ." 23:59:59";
            $direct_bookings_count          = Booking::where('source','direct')->whereBetween('created_at', [$from, $to]);
            if($request->website!=""){
                $direct_bookings_count = $direct_bookings_count->where('website', $request->website);
            }
            $direct_bookings_count = $direct_bookings_count->count();

            $converted_bookings_count     = Booking::where('source','converted')->whereBetween('created_at', [$from, $to]);
            if($request->website!=""){
                $converted_bookings_count = $converted_bookings_count->where('website', $request->website);
            }
            $converted_bookings_count     = $converted_bookings_count->count();
        }else{
            $direct_bookings_count        = Booking::where('source','direct')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            if($request->website!=""){
                $direct_bookings_count = $direct_bookings_count->where('website', $request->website);
            }
            $direct_bookings_count        =  $direct_bookings_count->count();
            $converted_bookings_count     = Booking::where('source','converted')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            if($request->website!=""){
                $converted_bookings_count = $converted_bookings_count->where('website', $request->website);
            }
            $converted_bookings_count     = $converted_bookings_count->count();
        }
       
      
        $direct_bookings  = Booking::selectRaw("(COUNT(*)) as count, DATE_FORMAT(created_at, '%d-%m-%Y') as date")->where('source','direct');
        if(isset($request->type) && $request->type=="sale" ){
            $direct_bookings = $direct_bookings->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
        }else{
            $direct_bookings = $direct_bookings->whereBetween('created_at', [$from, $to]);
        }
        if($request->website!=""){
            $direct_bookings = $direct_bookings->where('website', $request->website);
        }
        $direct_bookings = $direct_bookings->groupByRaw("DATE_FORMAT(created_at, '%d-%m-%Y')")->get()->toArray();

        $converted_bookings = Booking::selectRaw("(COUNT(*)) as count, DATE_FORMAT(created_at, '%d-%m-%Y') as date")->where('source','converted');
        if(isset($request->type) && $request->type=="sale" ){
            $converted_bookings = $converted_bookings->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
        }else{
            $converted_bookings = $converted_bookings->whereBetween('created_at', [$from, $to]);
        }
        if($request->website!=""){
            $converted_bookings = $converted_bookings->where('website', $request->website);
        }
        $converted_bookings = $converted_bookings->groupByRaw("DATE_FORMAT(created_at, '%d-%m-%Y')")->get()->toArray();

            $d_date = [];
            $d_count = [];
            $c_date = [];
            $c_count = [];
            foreach($direct_bookings as $direct){
                $d_date[]=$direct['date'];
                $d_count[]=$direct['count'];
            }
            foreach($converted_bookings as $val){
                $c_date[]=$val['date'];
                $c_count[]=$val['count'];
            }
            $colors = [];
            for ($i=0; $i<count($direct_bookings); $i++) {
                $colors[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
            }
            $output = array(
                'directCount'=>$direct_bookings_count,
                'convertedCount'=>$converted_bookings_count,
                'direct_bookings'=>$direct_bookings,
                'converted_bookings'=>$converted_bookings,
                "colors"    => $colors,
                "d_date"    => $d_date,
                "d_count"    => $d_count,
                "c_date"    => $c_date,
                "c_count"    => $c_count,

            );
            // dd($output);

         return response()->json($output);
    }
    public function getStatesByCountry($country)
    {
        $states = CountryState::where('country',$country)->get(['state']);
        

         return response()->json(['success' => true,'states'=>$states]);
    }
}
