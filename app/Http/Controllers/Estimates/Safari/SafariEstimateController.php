<?php

namespace App\Http\Controllers\Estimates\Safari;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateInclusion;
use App\Models\EstimateExclusion;
use App\Models\EstimateSafari;
use App\Models\EstimateSafariOption;
use App\Models\EstimateTerm;
use App\Models\Inclusion;
use App\Models\Exclusion;
use App\Models\Lead;
use App\Models\Company;
use App\Models\LeadComment;
use App\Models\LocalAddress;
use App\Models\PaymentMode;
use App\Models\Term;
use App\Models\TermsAndCondition;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SafariEstimateController extends Controller
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
        $inclusions             = Inclusion::where('type', 'safari')->get();
        $exclusions             = Exclusion::where('type', 'safari')->get();
        $payment_modes          = PaymentMode::get(['id', 'name']);
        $terms                  = Term::where('type', 'safari')->get();
        if(isset($mobile)){
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [] ;
        }else{
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('estimates.safari.create', compact('customer_exists', 'customer', 'inclusions', 'exclusions', 'terms', 'payment_modes'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $inclusions         = Inclusion::where('type', 'safari')->get();
        $exclusions         = Exclusion::where('type', 'safari')->get();
        $payment_modes      = PaymentMode::get(['id', 'name']);
        $terms              = Term::where('type', 'safari')->get();
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [] ;
        return view('estimates.safari.convert', compact('lead', 'customer_exists', 'customer', 'inclusions', 'exclusions', 'terms', 'payment_modes'));
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
            'sanctuary'             => 'required',
            'mode'                  => 'required',
            'zone'                  => ($request->sanctuary == 'gir' || $request->sanctuary == 'ranthambore')  ? 'required' : '',
            'area'                  => $request->sanctuary != 'gir' ? 'required' : '',
            'adult'                 => $request->sanctuary == 'gir' ? 'required' : '',
            'child'                 => $request->sanctuary == 'gir' ? 'required' : '',
            'total_person'          => $request->sanctuary == 'gir' ? '' : 'required',
            'vehicle_type'          => $request->sanctuary == 'ranthambore' ? 'required' : '',
            'type'                  => $request->sanctuary == 'ranthambore' ? 'required' : '',
            'nationality'           => 'required',
            'date'                  => 'required',
            'time'                  => 'required',
            'website'               => $request->has('lead_id')?'':'required',
            'payment_modes'         => 'required|array|min:1',    
            'payment_type'          => 'required|array|min:1',        
        ];

        $messages = [
            'customer_id.required'      => 'Please select customer from list',
            'sanctuary.required'        => 'Please select Sanctuary.',
            'mode.required'             => 'Please select Mode of Vehicle.',
            'area.required'             => 'Please select Safari Area.',
            'zone.required'             => 'Please select Safari Zone.',
            'adult.required'            => 'Please enter No of Adults.',
            'child.required'            => 'Please enter No of Children.',
            'total_person.required'     => 'Please enter No of Person.',
            'nationality.required'      => 'Please select Nationality.',
            'vehicle_type.required'     => 'Please select Vehicle Type.',
            'booking_type.required'     => 'Please select Booking Type.',
            'date.required'             => 'Please select Safari Date.',
            'time.required'             => 'Please enter Safari Time.',
            'website.required'          => 'Please select any Website',
            'payment_modes.required'    => 'Please select any Payment Mode',
            'payment_type.required'     => 'Please select any Payment Type',
        ];

        $this->validate($request, $rules, $messages);

        $estimate = new Estimate;
        $estimate->type                 = 'safari';
        $estimate->customer_id          = $request->customer_id;
        $estimate->lead_id              = $request->has('lead_id') ? $request->lead_id : null;
        $estimate->assigned_to          = $request->has('lead_id') ? Lead::find($request->lead_id)->assigned_to : null;
        $estimate->source               = $request->has('lead_id') ? 'converted' : 'custom';
        $estimate->date                 = date("Y-m-d");
        $estimate->gst_filed            = $request->gst_filed;
        $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->time                 = date("H:i:s");
        $estimate->payment_modes        = $request->payment_modes;
        $estimate->payment_type         = implode(",", $request->payment_type);
         if($request->has('lead_id')){
            $lead = Lead::find($request->lead_id);
            $estimate->website                 = $lead->website;
        }else{
            $estimate->website                 = $request->website;
        }
        $estimate->save();

        $safari                            = new EstimateSafari;
        $safari->estimate_id               = $estimate->id;
        $safari->sanctuary                 = $request->sanctuary;
        $safari->mode                      = $request->mode;
        $safari->area                      = $request->has('area') ? $request->area : null;
        $safari->zone                      = $request->has('zone') ? $request->zone : null;
        $safari->adult                     = $request->has('adult') ? $request->adult : null;
        $safari->child                     = $request->has('child') ? $request->child : null;
        $safari->total_person              = $request->has('total_person') ? $request->total_person : $request->adult + $request->child;
        $safari->vehicle_type              = $request->has('vehicle_type') ? $request->vehicle_type : null;
        $safari->date                      = Carbon::parse($request->date)->format('Y-m-d');
        $safari->time                      = $request->time;
        $safari->nationality               = $request->nationality;
        $safari->note                      = $request->note;
        $safari->jeeps                     = $request->jeeps;
        $safari->type                      = $request->has('type') ? $request->type : null;;
        $safari->save();

        if (!empty($request->option) && is_array($request->option)) {
            foreach ($request->option as $key => $value) {

                $total_without_gst              = $value['amount'] - $value['discount'];
                $gst                            = round(($estimate->gst_filed / 100) * $total_without_gst);
                $total_with_gst                 = $total_without_gst + $gst;
                $pg_charges                     = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                $option_total                   = $total_with_gst + $pg_charges;

                $option                         = new EstimateSafariOption;
                $option->estimate_id            = $estimate->id;
                $option->estimate_safari_id     = $safari->id;
                $option->content                = $value['content'];
                $option->amount                 = $value['amount'];
                $option->discount               = $value['discount'];
                $option->total                  = $option_total;
                $option->save();
            }
        }

        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new EstimateInclusion;
                $inclusion->estimate_id     = $estimate->id;
                $inclusion->content         = $value['content'];
                $inclusion->filter          = $request->sanctuary;
                $inclusion->save();
            }
        }

        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new EstimateExclusion;
                $exclusion->estimate_id     = $estimate->id;
                $exclusion->content         = $value['content'];
                $exclusion->filter          = $request->sanctuary;
                $exclusion->save();
            }
        }


        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new EstimateTerm;
                $term->estimate_id     = $estimate->id;
                $term->content         = $value['content'];
                $term->filter          = $request->sanctuary;
                $term->save();
            }
        }

        if($request->has('lead_id')){
            $lead                       = Lead::find($request->lead_id);
            $lead->lead_status          = 4;
            $lead->timestamps           = false;
            $lead->save();

            $comment                = new LeadComment();
            $comment->lead_id       = $request->lead_id;
            $comment->comment_by    = Auth::user()->id;
            $comment->type          = "estimate generated";
            $comment->comment       = "Safari Estimate has been generated by " . Auth::user()->name;
            $comment->save();
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate generated',
            'comment' => 'A Safari Estimate has been generated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
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

        $estimate             = Estimate::find($id)->load('safari', 'safari_options', 'customer', 'inclusions', 'exclusions','terms');
        $content                = TermsAndCondition::first();
        $payment_modes        = PaymentMode::where('status', '1')->get();
        $payment                = EstimateSafariOption::where('estimate_id', $id)->where('accepted','yes')->value('total');
        $total                = $estimate->payment == 'half' ? $payment / 2 : $payment;
        // $company              = Company::where('default', 'yes')->first();
        $company                    = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        $local_address        = LocalAddress::where('sanctuary', $estimate->safari->sanctuary)->first();

        return view('estimates.safari.show', compact('estimate', 'payment_modes', 'total','company', 'local_address', 'content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $estimate           = Estimate::find($id)->load('safari', 'safari_options');
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $payment_modes      = PaymentMode::where('status', '1')->get(['id', 'name']);
        $inclusions         = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions         = EstimateExclusion::where('estimate_id', $id)->get();
        $terms              = EstimateTerm::where('estimate_id', $id)->get();
        $customer_exists    = Customer::where('id', $estimate->customer_id)->exists();
        $customer           = $customer_exists ? Customer::find($estimate->customer_id) : [];

        return view('estimates.safari.edit', compact('estimate', 'customer_exists', 'customer', 'payment_modes', 'inclusions', 'exclusions', 'terms'));
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
            'sanctuary'             => 'required',
            'mode'                  => 'required',
            'zone'                  => ($request->sanctuary == 'gir' || $request->sanctuary == 'ranthambore') ? 'required' : '',
            'area'                  => $request->sanctuary != 'gir' ? 'required' : '',
            'adult'                 => $request->sanctuary == 'gir' ? 'required' : '',
            'child'                 => $request->sanctuary == 'gir' ? 'required' : '',
            'total_person'          => $request->sanctuary == 'gir' ? '' : 'required',
            'vehicle_type'          => $request->sanctuary == 'ranthambore' ? 'required' : '',
            'type'                  => $request->sanctuary == 'ranthambore' ? 'required' : '',
            'nationality'           => 'required',
            'date'                  => 'required',
            'time'                  => 'required',
            'payment_modes'         => 'required|array|min:1',
            'payment_type'          => 'required|array|min:1',
             'website'              => 'required',            
        ];

        $messages = [
            'customer_id.required'      => 'Please select customer from list',
            'sanctuary.required'        => 'Please select Sanctuary.',
            'mode.required'             => 'Please select Mode of Vehicle.',
            'area.required'             => 'Please select Safari Area.',
            'zone.required'             => 'Please select Safari Zone.',
            'adult.required'            => 'Please enter No of Adults.',
            'child.required'            => 'Please enter No of Children.',
            'total_person.required'     => 'Please enter No of Person.',
            'nationality.required'      => 'Please select Nationality.',
            'vehicle_type.required'     => 'Please select Vehicle Type.',
            'booking_type.required'     => 'Please select Booking Type.',
            'date.required'             => 'Please select Safari Date.',
            'time.required'             => 'Please enter Safari Time.',
            'payment_modes.required'    => 'Please select any Payment Mode',
            'payment_type.required'     => 'Please select any Payment Type',
            'website.required'          => 'Please select any Website',
        ];

        $this->validate($request, $rules, $messages);

        $estimate = Estimate::find($id);
        $estimate->type                 = 'safari';
        $estimate->customer_id          = $request->customer_id;
        $estimate->payment_modes        = $request->payment_modes;
        $estimate->website              = $request->website;
        $estimate->gst_filed            = $request->gst_filed;
        $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->estimate_status      = 'waiting';
        $estimate->payment_type         = implode(",", $request->payment_type);
        $estimate->save();

        $safari_estimate_id                = EstimateSafari::where('estimate_id', $id)->value('id');

        $safari                            = EstimateSafari::find($safari_estimate_id);
        $safari->estimate_id               = $estimate->id;
        $safari->sanctuary                 = $request->sanctuary;
        $safari->mode                      = $request->mode;
        $safari->area                      = $request->has('area') ? $request->area : null;
        $safari->zone                      = $request->has('zone') ? $request->zone : null;
        $safari->adult                     = $request->has('adult') ? $request->adult : null;
        $safari->child                     = $request->has('child') ? $request->child : null;
        $safari->total_person              = $request->has('total_person') ? $request->total_person : $request->adult + $request->child;
        $safari->vehicle_type              = $request->has('vehicle_type') ? $request->vehicle_type : null;
        $safari->date                      = Carbon::parse($request->date)->format('Y-m-d');
        $safari->time                      = $request->time;
        $safari->nationality               = $request->nationality;
        $safari->note                      = $request->note;
        $safari->jeeps                     = $request->jeeps;
        $safari->type                      = $request->has('type') ? $request->type : null;;

        $safari->save();

        EstimateSafariOption::where('estimate_id', $id)->delete();
        if (!empty($request->option) && is_array($request->option)) {
            foreach ($request->option as $key => $value) {

                $total_without_gst              = $value['amount'] - $value['discount'];
                $gst                            = round(($estimate->gst_filed / 100) * $total_without_gst);
                $total_with_gst                 = $total_without_gst + $gst;
                $pg_charges                     = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                $option_total                   = $total_with_gst + $pg_charges;

                $option                         = new EstimateSafariOption;
                $option->estimate_id            = $estimate->id;
                $option->estimate_safari_id     = $safari->id;
                $option->content                = $value['content'];
                $option->amount                 = $value['amount'];
                $option->discount               = $value['discount'];
                $option->total                  = $option_total;
                $option->save();
            }
        }
        EstimateInclusion::where('estimate_id', $id)->delete();
        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new EstimateInclusion;
                $inclusion->estimate_id     = $estimate->id;
                $inclusion->content         = $value['content'];
                $inclusion->filter          = $request->sanctuary;
                $inclusion->save();
            }
        }

        EstimateExclusion::where('estimate_id', $id)->delete();
        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new EstimateExclusion;
                $exclusion->estimate_id     = $estimate->id;
                $exclusion->content         = $value['content'];
                $exclusion->filter          = $request->sanctuary;
                $exclusion->save();
            }
        }

        EstimateTerm::where('estimate_id', $id)->delete();
        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new EstimateTerm;
                $term->estimate_id     = $estimate->id;
                $term->content         = $value['content'];
                $term->filter          = $request->sanctuary;
                $term->save();
            }

        }
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate updated',
            'comment' => 'A Safari Estimate has been updated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
        ]);

        return redirect()->route('estimates.index')->with('success', 'Estimate created successfully');
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
        
        $option = EstimateSafariOption::find($id);
        $option->accepted = 'yes';
        $option->save();

        Estimate::where('id', $option->estimate_id)->update(['estimate_status' => 'accepted', 'payment' => $request->payamount]);
        return redirect()->back()->with('success', 'Estimate accepted successfully');
    }
}
