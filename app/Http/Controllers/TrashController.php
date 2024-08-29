<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\LeadFollowUp;
use App\Models\LeadReminder;
use App\Models\LeadStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Ladumor\OneSignal\OneSignal;

use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateCab;
use App\Models\EstimateCabOption;
use App\Models\EstimateHotel;
use App\Models\EstimateHotelDestination;
use App\Models\EstimateHotelDestinationOption;
use App\Models\EstimateHotelOption;
use App\Models\EstimateInclusion;
use App\Models\EstimateExclusion;
use App\Models\EstimateSafari;
use App\Models\EstimateSafariOption;
use App\Models\EstimateTerm;
use App\Models\Hotel;
use App\Models\Inclusion;
use App\Models\Exclusion;
use App\Models\Lead;
use App\Models\PaymentMode;
use App\Models\Term;
use App\Models\Company;
use App\Models\LocalAddress;
use App\Models\Destination;
use App\Models\DestinationIternary;
use App\Models\EstimateCabHalt;
use App\Models\Iternary;
use App\Models\EstimateIternary;
use App\Models\LeadComment;
use App\Models\TermsAndCondition;
use App\Models\UserActivity;
use App\Models\EstimateDestination;
use App\Models\{EstimateFlight,EstimateFlightOptions};

class TrashController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
     public function leads(Request $request)
    {
        $statuses               = LeadStatus::get(['id', 'name']);
        $users                  = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        })->get(['id', 'name', 'is_active']);

        $filter_status          = $request->input('filter_status');
        $filter_name            = $request->input('filter_name');
        $filter_website         = $request->input('filter_website');
        $filter_user            = $request->input('filter_user');
        $filter_mobile          = $request->input('filter_mobile');
        $filter_date_assigned   = $request->input('filter_date_assigned');
        $filter_date_from       = $request->input('filter_date_from');
        $filter_date_to         = $request->input('filter_date_to');
        $filter_user_assigned   = $request->input('filter_user_assigned');

        $leads = Lead::with('user', 'estimate', 'booking')->onlyTrashed();


        if ($request->filter_status) {
            $leads->where('lead_status', '=', $request->input('filter_status'));
        }

        if ($request->filter_name) {
            $leads->where('name', 'LIKE', '%' . $request->input('filter_name') . '%');
        }

        if ($request->filter_mobile) {
            $leads->where('mobile', 'LIKE', '%' . $request->input('filter_mobile') . '%')->groupBy('mobile');
        }

        if ($request->filter_email) {
            $leads->where('email', 'LIKE', '%' . $request->input('filter_email') . '%')->groupBy('email');
        }

        if ($request->filter_website) {
            $leads->where('website', 'LIKE', '%' . $request->input('filter_website') . '%');
        }

        if ($request->filter_user) {
            $leads->where('assigned_to', $request->input('filter_user'));
        }

        if ($request->filter_user_assigned) {
            $leads->where('assigned_to', $request->input('filter_user_assigned'));
        }

        if ($request->filter_date_assigned) {
            $assigned   = date("Y-m-d", strtotime($request->input('filter_date_assigned')));
            $leads->whereDate('date_assigned', $assigned);
        }

        if ($request->filter_date_from && $request->filter_date_to) {

            $from   = date("Y-m-d", strtotime($request->input('filter_date_from')));
            $to     = date('Y-m-d', strtotime($request->input('filter_date_to')));
            $leads->whereBetween('date', [$from, $to]);
        }

        if ($request->filter_date_from) {
            $from   = date("Y-m-d", strtotime($request->input('filter_date_from')));
            $leads->whereDate('date', '>=', $from);
        }

        if ($request->filter_date_to) {
            $to     = date('Y-m-d', strtotime($request->input('filter_date_to')));
            $leads->whereDate('date', '<=', $to);
        }        

        if (Auth::user()->hasAnyRole('administrator|team lead|agent')) {

            $leads = $leads->orderBy('updated_at', 'desc')->latest()->paginate(20);

        } elseif (Auth::user()->hasRole('fresher')) {

            $leads = $leads->whereIn('assigned_to', [Auth::User()->id, 2])->groupBy('mobile')->orderBy('updated_at', 'desc')->latest()->paginate(20);
        
        } elseif (Auth::user()->hasRole('team-lead')) {

            $roles = Auth::user()->roles->pluck('name')->toArray();

            $leads = $leads->whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id, 2])->groupBy('mobile')->orderBy('updated_at', 'desc')->latest()->paginate(20);
        
        } else {

            $roles = Auth::user()->roles->pluck('name')->toArray();
            if(Auth::user()->assign_lead == 0){
                $leads = $leads->whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id, 2])->groupBy('mobile')->orderBy('updated_at', 'desc')->latest()->paginate(20);
            }else{
                $leads = $leads->whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id])->groupBy('mobile')->orderBy('updated_at', 'desc')->latest()->paginate(20);
            }
           
            return view('leads.user-list', compact('leads', 'filter_status', 'filter_name', 'filter_user', 'filter_website', 'filter_date_from', 'filter_date_to', 'statuses', 'users', 'filter_date_assigned', 'filter_user_assigned'));
        
        }

        return view('trash.lead', compact('leads', 'filter_status', 'filter_name', 'filter_user', 'filter_website', 'filter_date_from', 'filter_date_to', 'statuses', 'users', 'filter_date_assigned', 'filter_mobile', 'filter_user_assigned'));
    }
    public function restoreLeads($id){
            Lead::withTrashed()->find($id)->restore();
            UserActivity::create([
                'user_id' => Auth::user()->id,
                'type'    => 'lead updated',
                'comment' => 'A <a href="'.route('leads.show', $id).'">Lead No. '.$id.'</a> restored successfully'
            ]);
            return redirect()->back()->with('success', 'Lead Restore successfully!');
    }
    public function deleteLead($id){

        Lead::withTrashed()->find($id)->forceDelete();
         UserActivity::create([
                'user_id' => Auth::user()->id,
                'type'    => 'lead updated',
                'comment' => 'A Lead No. '.$id.' deleted successfully'
            ]);
        return redirect()->back()->with('success', 'Lead deleted successfully!');

    }
    public function massDelete(Request $request)
    {
        $lead_ids = $request->arr;

        foreach ($lead_ids as $lead_id) {
            Lead::withTrashed()->find($lead_id)->forceDelete();
             UserActivity::create([
                'user_id' => Auth::user()->id,
                'type'    => 'lead updated',
                'comment' => 'A Lead No. '.$lead_id.' deleted successfully'
            ]);

        }
        return Response()->json('Lead Deleted Successfully');
    }
    //Estimates
     public function estimates(Request $request)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        })->get(['id', 'name']);

        $filter_name                = $request->filter_name;
        $filter_customer            = $request->filter_customer;
        $filter_mobile              = $request->filter_mobile;
        $filter_email               = $request->filter_email;
        $filter_date                = $request->filter_date;
        $filter_user                = $request->filter_user;
        $filter_payment_status      = $request->filter_payment_status;
        $filter_sanctuary           = $request->filter_sanctuary;
        $filter_estimate_status     = $request->filter_estimate_status;
        $filter_website             = $request->filter_website;

        $estimates = Estimate::with('customer', 'user')->onlyTrashed();

          if(isset($filter_name)) {
            $estimates->whereHas('customer', function($q) use ($filter_name) {
                $q->where(function($q) use ($filter_name) {
                    $q->where('name', 'LIKE', '%' . $filter_name . '%');
                });
            });

          }

          if(isset($filter_customer)) {
            $estimates->whereHas('customer', function($q) use ($filter_customer) {
                $q->where(function($q) use ($filter_customer) {
                    $q->where('id', $filter_customer);
                });
            });

          }

          if(isset($filter_mobile)) {
            $estimates->whereHas('customer', function($q) use ($filter_mobile) {
                $q->where(function($q) use ($filter_mobile) {
                    $q->where('mobile', 'LIKE', '%' . $filter_mobile . '%');
                });
            });

          }

          if(isset($filter_email)) {
            $estimates->whereHas('customer', function($q) use ($filter_email) {
                $q->where(function($q) use ($filter_email) {
                    $q->where('email', 'LIKE', '%' . $filter_email . '%');
                });
            });

          }

          if(isset($filter_date)) {
            $estimates->where('date', $filter_date);
          }

          if(isset($filter_user)) {
           $estimates->where('assigned_to',$filter_user);
         }

         if(isset($filter_website)) {
            $estimates->where('website',$filter_website);
          }

          if(isset($filter_payment_status)) {
            if($filter_payment_status=='partially_paid'){
           $estimates->where('payment_status','partially paid');
           }else{
             $estimates->where('payment_status',$filter_payment_status);
           }
         }

          if(isset($filter_sanctuary)) {
            $estimates->whereHas('safari', function($q) use ($filter_sanctuary) {
                $q->where(function($q) use ($filter_sanctuary) {
                    $q->where('sanctuary', 'LIKE', '%' . $filter_sanctuary . '%');
                });
            });
          }
          if(isset($filter_estimate_status)) {
           $estimates->where('estimate_status',$filter_estimate_status);
         }

         if(Auth::user()->hasAnyRole('administrator|agent')){

          $estimates = $estimates->latest()->paginate(20);

          } elseif (Auth::user()->hasRole('fresher')){

              $estimates = $estimates->latest()->paginate(20);

          }  elseif (Auth::user()->hasRole('team-lead')){

            $estimates = $estimates->whereIn('website',  Auth::user()->roles->pluck('name')->toArray())->latest()->paginate(20);

        }else {

              $estimates = $estimates->where('assigned_to', Auth::user()->id)->latest()->paginate(20);

          }

        return view('trash.estimates.estimates', compact('users', 'filter_email',  'filter_website', 'filter_sanctuary', 'estimates', 'filter_name', 'filter_date', 'filter_user', 'filter_payment_status', 'filter_estimate_status', 'filter_mobile'));
    }
      public function restoreEstimates($id){
            Estimate::withTrashed()->find($id)->restore();
            UserActivity::create([
                'user_id' => Auth::user()->id,
                'type'    => 'estimate updated',
                'comment' => 'A trash Estimate has been restored <a href="'.route('estimates.show', $id).'">Estimate No. '.$id.'</a>'
            ]);
            return redirect()->back()->with('success', 'Estimate Restore successfully!');
    }
    public function deleteEstimate($id){

        Estimate::withTrashed()->find($id)->forceDelete();
        EstimateCab::where('estimate_id', $id)->delete();
        EstimateCabOption::where('estimate_id', $id)->delete();
        EstimateSafari::where('estimate_id', $id)->delete();
        EstimateSafariOption::where('estimate_id', $id)->delete();
        EstimateHotel::where('estimate_id', $id)->delete();
        EstimateHotelOption::where('estimate_id', $id)->delete();
        EstimateInclusion::where('estimate_id', $id)->delete();
        EstimateTerm::where('estimate_id', $id)->delete();
         UserActivity::create([
                'user_id' => Auth::user()->id,
                'type'    => 'estimate updated',
                'comment' => 'A trash Estimate has been deleted Estimate No. '.$id.'</a>'
            ]);
        return redirect()->back()->with('success', 'Estimate deleted successfully!');

    }
    public function showEstimate($id)
    {
        $estimate = Estimate::withTrashed()->find($id);
        switch ($estimate->type) {
            case 'cab':
                $estimate           = Estimate::withTrashed()->find($id)->load('cab', 'cab_options', 'customer', 'inclusions', 'exclusions', 'terms');
                $payment_modes      = PaymentMode::where('status', '1')->get();
                $payment            = EstimateCabOption::where('estimate_id', $id)->where('accepted', 'yes')->value('total');
                $total              = $estimate->payment == 'half' ? $payment / 2 : $payment;       
                $company            = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
                $company->path      = isset($company->logo) ? asset('storage/uploads/company/' . $company->logo) : '';
                $content            = TermsAndCondition::first();
                return view('trash.estimates.cab.show', compact('estimate', 'payment_modes', 'total', 'company', 'content'));
                break;
            case 'hotel':
                $estimate             = Estimate::withTrashed()->find($id)->load('hotel', 'hotel_options', 'customer', 'inclusions', 'exclusions','terms');
                $payment_modes        = PaymentMode::where('status', '1')->get();
                $payment              = EstimateHotelOption::where('estimate_id', $id)->where('accepted','yes')->value('total');
                $total                = $estimate->payment == 'half' ? $payment / 2 : $payment;
                // $company              = Company::where('default', 'yes')->first();
                $content                = TermsAndCondition::first();
                 $company                    = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
                $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
                return view('trash.estimates.hotel.show', compact('estimate', 'payment_modes', 'total','company', 'content'));
                break;
            case 'safari':
                 $estimate             = Estimate::withTrashed()->find($id)->load('safari', 'safari_options', 'customer', 'inclusions', 'exclusions','terms');
                $content                = TermsAndCondition::first();
                $payment_modes        = PaymentMode::where('status', '1')->get();
                $payment                = EstimateSafariOption::where('estimate_id', $id)->where('accepted','yes')->value('total');
                $total                = $estimate->payment == 'half' ? $payment / 2 : $payment;
                // $company              = Company::where('default', 'yes')->first();
                $company                    = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
                $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
                $local_address        = LocalAddress::where('sanctuary', $estimate->safari->sanctuary)->first();

                return view('trash.estimates.safari.show', compact('estimate', 'payment_modes', 'total','company', 'local_address', 'content'));
                break;
            case 'tour':
                $estimate               = Estimate::withTrashed()->find($id)->load('safari', 'safari_options', 'cab', 'cab_options', 'hotel', 'hotel_options');
                $payment_modes          = PaymentMode::where('status', '1')->get();
                $estimate_type          = estimateType($estimate->id);
                $payment                = tourTotal($estimate->id);
                $total                  = $estimate->payment == 'half' ? $payment / 2 : $payment;
                $content                = TermsAndCondition::first();
                $hotel_amount           = EstimateHotelOption::where('estimate_id', $id)->where('accepted', 'yes')->value('amount');        
                $company                    = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
                $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
                if(in_array('safari', $estimate_type)){
                    $local_address      = LocalAddress::where('sanctuary', $estimate->safari->sanctuary)->first();
                }else{
                    $local_address      = null;
                }

                return view('trash.estimates.tour.show', compact('estimate', 'payment_modes', 'estimate_type', 'total','company','hotel_amount', 'local_address', 'content'));
                break;
            case 'package':
                $estimate               = Estimate::withTrashed()->find($id)->load('safari', 'safari_options', 'cab', 'cab_options', 'hotel', 'hotel_options');
                $payment_modes          = PaymentMode::where('status', '1')->get();
                $estimate_type          = estimateType($estimate->id);
                $payment                = getPackageTotal($id);
                $content                = TermsAndCondition::first();
                $total                  = $estimate->payment == 'half' ? $payment / 2 : $payment;
                $hotel_amount           = EstimateHotelDestinationOption::where('estimate_id', $id)->sum('amount');
                $hotel_discount         = EstimateHotelDestinationOption::where('estimate_id', $id)->sum('discount');
                $hotel_total            = $hotel_amount - $hotel_discount;
                // $company                = Company::where('default', 'yes')->first();
                $company                    = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
                $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
                if(in_array('safari', $estimate_type)){
                    $local_address      = LocalAddress::where('sanctuary', $estimate->safari->sanctuary)->first();
                }else{
                    $local_address      = null;
                }
                return view('trash.estimates.package.show', compact('content','estimate', 'payment_modes', 'estimate_type', 'total', 'hotel_total', 'company','local_address', 'payment'));
               
                break;
        }


        return redirect()->route('trash-estimates')->with('error', 'Something went wrong.');
    }

}
