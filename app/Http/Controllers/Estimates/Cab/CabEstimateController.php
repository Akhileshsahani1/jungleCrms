<?php

namespace App\Http\Controllers\Estimates\Cab;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateCab;
use App\Models\EstimateCabOption;
use App\Models\EstimateInclusion;
use App\Models\EstimateExclusion;
use App\Models\EstimateTerm;
use App\Models\Inclusion;
use App\Models\Exclusion;
use App\Models\Lead;
use App\Models\PaymentMode;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Destination;
use App\Models\DestinationIternary;
use App\Models\EstimateCabHalt;
use App\Models\Iternary;
use App\Models\EstimateIternary;
use App\Models\LeadComment;
use App\Models\TermsAndCondition;
use App\Models\UserActivity;

class CabEstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mobile                 = session()->get('mobile');       
        $payment_modes          = PaymentMode::where('status', '1')->get(['id', 'name']);
        $inclusions             = Inclusion::where('type', 'cab')->get();
        $exclusions             = Exclusion::where('type', 'cab')->get();
        $terms                  = Term::where('mode', 'estimate')->where('type', 'cab')->get();
        $iternaries             = Destination::get();
        if (isset($mobile)) {
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [];
        } else {
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('estimates.cab.create', compact('customer_exists', 'customer', 'payment_modes', 'inclusions', 'exclusions', 'terms', 'iternaries'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);       
        $payment_modes      = PaymentMode::where('status', '1')->get(['id', 'name']);
        $inclusions         = Inclusion::where('type', 'cab')->get();
        $exclusions         = Exclusion::where('type', 'cab')->get();
        $terms              = Term::where('mode', 'estimate')->where('type', 'cab')->get();
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [];
        $iternaries         = Destination::get();
        return view('estimates.cab.convert', compact('lead', 'customer_exists', 'customer', 'payment_modes', 'inclusions', 'exclusions', 'terms', 'iternaries'));
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
            'trip_type'             => 'required',
            'vehicle_type'          => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
            'days'                  => 'required',
            'pick_up'               => 'required',
            'drop'                  => 'required',
            'pickup_time'           => 'required',
            'total_riders'          => 'required',
            'website'               => $request->has('lead_id') ? '' : 'required',
            'payment_modes'         => 'required|array|min:1',   
            'payment_type'          => 'required|array|min:1',         
        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'trip_type.required'                => 'The Trip Type field can not be blank.',           
            'vehicle_type.required'             => 'Please select vehicle type',
            'start_date.required'               => 'Please enter journey start date.',
            'end_date.required'                 => 'Please enter journey end date.',
            'days.required'                     => 'Please enter no of days.',
            'pick_up.required'                  => 'Please enter Pickup point',
            'drop.required'                     => 'Please enter Drop point',
            'pickup_time.required'              => 'Please enter Pickup time',
            'total_riders.required'             => 'Please enter no of riders.',
            'website.required'                  => 'Please select any Website',
            'payment_modes.required'            => 'Please select any Payment Mode',
            'payment_type.required'             => 'Please select any Payment Type',
        ];

        $this->validate($request, $rules, $messages);

        $estimate = new Estimate;
        $estimate->type                 = 'cab';
        $estimate->customer_id          = $request->customer_id;
        $estimate->lead_id              = $request->has('lead_id') ? $request->lead_id : null;
        $estimate->assigned_to          = $request->has('lead_id') ? Lead::find($request->lead_id)->assigned_to : null;
        $estimate->source               = $request->has('lead_id') ? 'converted' : 'custom';
        $estimate->date                 = date("Y-m-d");
        $estimate->time                 = date("H:i:s");
        $estimate->gst_filed            = $request->gst_filed;
        $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->payment_modes        = $request->payment_modes;
        $estimate->iternary_state       = $request->iternary_state;
        $estimate->duration             = $request->duration;
        $estimate->iternary             = $request->iternary;
        $estimate->payment_type         = implode(",", $request->payment_type);
        if ($request->has('lead_id')) {
            $lead                       = Lead::find($request->lead_id);
            $estimate->website          = $lead->website;
        } else {
            $estimate->website          = $request->website;
        }
        $estimate->save();

        $cab = new EstimateCab;
        $cab->estimate_id               = $estimate->id;
        $cab->trip_type                 = $request->trip_type;
        $cab->pickup_medium             = 'any';
        $cab->vehicle_type              = $request->vehicle_type;
        $cab->start_date                = Carbon::parse($request->start_date)->format('Y-m-d');
        $cab->end_date                  = Carbon::parse($request->end_date)->format('Y-m-d');
        $cab->days                      = $request->days;
        $cab->pick_up                   = $request->pick_up;
        $cab->drop                      = $request->drop;
        $cab->pickup_time               = $request->pickup_time;
        $cab->total_riders              = $request->total_riders;
        $cab->no_of_cab                 = $request->no_of_cab;
        $cab->note                      = $request->note;
        $cab->save();

        if (!empty($request->option) && is_array($request->option)) {
            foreach ($request->option as $key => $value) {

                $total_without_gst      = $value['amount'] - $value['discount'];
                $gst                    = round(($estimate->gst_filed / 100) * $total_without_gst);
                $total_with_gst         = $total_without_gst + $gst;
                $pg_charges             = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                $option_total           = $total_with_gst + $pg_charges;

                $option                  = new EstimateCabOption;
                $option->estimate_id     = $estimate->id;
                $option->estimate_cab_id = $cab->id;
                $option->content         = $value['content'];
                $option->amount          = $value['amount'];
                $option->discount        = $value['discount'];
                $option->total           = $option_total;
                $option->save();
            }
        }

        if (!empty($request->halts) && is_array($request->halts)) {
            foreach ($request->halts as $key => $value) {
                $halt                  = new EstimateCabHalt();
                $halt->estimate_id     = $estimate->id;
                $halt->estimate_cab_id = $cab->id;
                $halt->halt            = $value['halt'];
                $halt->start           = $value['start'];
                $halt->end             = $value['end'];
                $halt->save();
            }
        }

        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new EstimateInclusion;
                $inclusion->estimate_id     = $estimate->id;
                $inclusion->content         = $value['content'];
                $inclusion->save();
            }
        }

        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new EstimateExclusion;
                $exclusion->estimate_id     = $estimate->id;
                $exclusion->content         = $value['content'];
                $exclusion->save();
            }
        }

        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new EstimateTerm;
                $term->estimate_id     = $estimate->id;
                $term->content         = $value['content'];
                $term->save();
            }
        }

        if (!empty($request->iternaries) && is_array($request->iternaries)) {
            foreach ($request->iternaries as $key => $value) {
                $iternary             = new EstimateIternary;
                $iternary->estimate_id  = $estimate->id;
                $iternary->title        = $value['title'];
                $iternary->text         = $value['text'];
                $iternary->save();
            }
        }

        if ($request->has('lead_id')) {
            $lead                       = Lead::find($request->lead_id);
            $lead->lead_status          = 4;
            $lead->timestamps           = false;
            $lead->save();

                $comment                = new LeadComment();
                $comment->lead_id       = $request->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "estimate generated";
                $comment->comment       = "Cab Estimate has been generated by " . Auth::user()->name;
                $comment->save();
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate generated',
            'comment' => 'A Cab Estimate has been generated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
        ]);

        return redirect()->route('estimates.index')->with('success', 'Estimate created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estimate           = Estimate::find($id)->load('cab', 'cab_options', 'customer', 'inclusions', 'exclusions', 'terms');
        $payment_modes      = PaymentMode::where('status', '1')->get();
        $payment            = EstimateCabOption::where('estimate_id', $id)->where('accepted', 'yes')->value('total');
        $total              = $estimate->payment == 'half' ? $payment / 2 : $payment;       
        $company            = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
        $company->path      = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo) : '';
        $content            = TermsAndCondition::first();
        return view('estimates.cab.show', compact('estimate', 'payment_modes', 'total', 'company', 'content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estimate           = Estimate::find($id)->load('cab', 'cab_options');
        $customer_exists    = Customer::where('id', $estimate->customer_id)->exists();
        $customer           = $customer_exists ? Customer::find($estimate->customer_id) : [];      
        $payment_modes      = PaymentMode::where('status', '1')->get(['id', 'name']);
        $inclusions         = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions         = EstimateExclusion::where('estimate_id', $id)->get();
        $terms              = EstimateTerm::where('estimate_id', $id)->get();        
        $iternaries         = Destination::get();
        $iternarie_options  = DestinationIternary::where('destination_id', $estimate->iternary_state)->where('duration', $estimate->duration)->get();

        return view('estimates.cab.edit', compact('estimate', 'customer_exists', 'customer', 'payment_modes', 'inclusions', 'exclusions', 'terms', 'iternaries', 'iternarie_options'));
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
            'trip_type'             => 'required',
            'vehicle_type'          => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
            'days'                  => 'required',
            'pick_up'               => 'required',
            'drop'                  => 'required',
            'pickup_time'           => 'required',
            'total_riders'          => 'required',
            'payment_modes'         => 'required|array|min:1',
            'payment_type'          => 'required|array|min:1',
            'website'               => 'required',           
        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'trip_type.required'                => 'The Trip Type field can not be blank.',            
            'vehicle_type.required'             => 'Please select vehicle type',
            'start_date.required'               => 'Please enter journey start date.',
            'end_date.required'                 => 'Please enter journey end date.',
            'days.required'                     => 'Please enter no of days.',
            'pick_up.required'                  => 'Please enter Pickup point',
            'drop.required'                     => 'Please enter Drop point',
            'pickup_time.required'              => 'Please enter Pickup time',
            'total_riders.required'             => 'Please enter no of riders.',
            'payment_modes.required'            => 'Please select any Payment Mode',
            'payment_type.required'             => 'Please select any Payment Type',
            'website.required'                  => 'Please select any Website',
        ];

        $this->validate($request, $rules, $messages);

        $estimate = Estimate::find($id);
        $estimate->customer_id          = $request->customer_id;
        $estimate->lead_id              = isset($request->lead_id) ? $request->lead_id : null;
        $estimate->payment_modes        = $request->payment_modes;
        $estimate->estimate_status      = 'waiting';
        $estimate->website              = $request->website;
        $estimate->gst_filed            = $request->gst_filed;
        $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->iternary_state       = $request->iternary_state;
        $estimate->duration             = $request->duration;
        $estimate->iternary             = $request->iternary;
        $estimate->payment_type         = implode(",", $request->payment_type);
        $estimate->save();

        $cab_estimate_id                = EstimateCab::where('estimate_id', $id)->value('id');

        $cab                            = EstimateCab::find($cab_estimate_id);
        $cab->estimate_id               = $estimate->id;
        $cab->trip_type                 = $request->trip_type;
        $cab->pickup_medium             = 'any';
        $cab->vehicle_type              = $request->vehicle_type;
        $cab->start_date                = Carbon::parse($request->start_date)->format('Y-m-d');
        $cab->end_date                  = Carbon::parse($request->end_date)->format('Y-m-d');
        $cab->days                      = $request->days;
        $cab->pick_up                   = $request->pick_up;
        $cab->drop                      = $request->drop;
        $cab->pickup_time               = $request->pickup_time;
        $cab->total_riders              = $request->total_riders;
        $cab->no_of_cab                 = $request->no_of_cab;
        $cab->note                      = $request->note;
        $cab->save();

        EstimateCabOption::where('estimate_id', $id)->delete();
        if (!empty($request->option) && is_array($request->option)) {
            foreach ($request->option as $key => $value) {

                $total_without_gst      = $value['amount'] - $value['discount'];
                $gst                    = round(($estimate->gst_filed / 100) * $total_without_gst);
                $total_with_gst         = $total_without_gst + $gst;
                $pg_charges             = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                $option_total           = $total_with_gst + $pg_charges;

                $option                  = new EstimateCabOption;
                $option->estimate_id     = $estimate->id;
                $option->estimate_cab_id = $cab->id;
                $option->content         = $value['content'];
                $option->amount          = $value['amount'];
                $option->discount        = $value['discount'];
                $option->total           = $option_total;
                $option->save();
            }
        }

        EstimateCabHalt::where('estimate_id', $id)->delete();
        if (!empty($request->halts) && is_array($request->halts)) {
            foreach ($request->halts as $key => $value) {
                $halt                  = new EstimateCabHalt();
                $halt->estimate_id     = $estimate->id;
                $halt->estimate_cab_id = $cab->id;
                $halt->halt            = $value['halt'];
                $halt->start           = $value['start'];
                $halt->end             = $value['end'];
                $halt->save();
            }
        }

        EstimateInclusion::where('estimate_id', $id)->delete();
        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new EstimateInclusion;
                $inclusion->estimate_id     = $estimate->id;
                $inclusion->content         = $value['content'];
                $inclusion->save();
            }
        }

        EstimateExclusion::where('estimate_id', $id)->delete();
        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new EstimateExclusion;
                $exclusion->estimate_id     = $estimate->id;
                $exclusion->content         = $value['content'];
                $exclusion->save();
            }
        }

        EstimateTerm::where('estimate_id', $id)->delete();
        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new EstimateTerm;
                $term->estimate_id     = $estimate->id;
                $term->content         = $value['content'];
                $term->save();
            }
        }
        EstimateIternary::where('estimate_id', $id)->delete();
        if (!empty($request->iternaries) && is_array($request->iternaries)) {
            foreach ($request->iternaries as $key => $value) {
                $iternary               = new EstimateIternary;
                $iternary->estimate_id  = $estimate->id;
                $iternary->title        = $value['title'];
                $iternary->text         = $value['text'];
                $iternary->save();
            }
        }
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate updated',
            'comment' => 'A Cab Estimate has been updated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
        ]);
        return redirect()->route('estimates.index')->with('success', 'Estimate updated successfully');
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

    public function accept(Request $request, $id)
    {
        $rules = [
            'accept'           => 'required',                
        ];

        $messages = [
            'accept.required'              => 'Please read and accept the Terms & conditions carefully!',           
        ];

        $this->validate($request, $rules, $messages);

        $option             = EstimateCabOption::find($id);
        $option->accepted   = 'yes';
        $option->save();


        Estimate::where('id', $option->estimate_id)->update(['estimate_status' => 'accepted', 'payment' => $request->payamount]);
        return redirect()->back()->with('success', 'Estimate accepted successfully');
    }
}
