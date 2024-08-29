<?php

namespace App\Http\Controllers\Estimates\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateHotel;
use App\Models\EstimateHotelOption;
use App\Models\EstimateInclusion;
use App\Models\EstimateExclusion;
use App\Models\EstimateTerm;
use App\Models\Hotel;
use App\Models\Inclusion;
use App\Models\Exclusion;
use App\Models\Lead;
use App\Models\PaymentMode;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\LeadComment;
use App\Models\TermsAndCondition;
use App\Models\UserActivity;

class HotelEstimateController extends Controller
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
        //$customers              = Customer::get(['id', 'name', 'mobile']);
        $payment_modes          = PaymentMode::where('status', '1')->get(['id', 'name']);
        $hotels                 = Hotel::where('status', 1)->get(['id', 'name']);
        $inclusions             = Inclusion::where('type', 'hotel')->get();
        $exclusions             = Exclusion::where('type', 'hotel')->get();
        $terms                  = Term::where('type', 'hotel')->get();
        if (isset($mobile)) {
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [];
        } else {
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('estimates.hotel.create', compact('customer_exists', 'customer', 'inclusions', 'exclusions', 'terms', 'payment_modes', 'hotels'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $payment_modes      = PaymentMode::where('status', '1')->get(['id', 'name']);
        $hotels             = Hotel::where('status', 1)->get(['id', 'name']);
        $inclusions         = Inclusion::where('type', 'hotel')->get();
        $exclusions         = Exclusion::where('type', 'hotel')->get();
        $terms              = Term::where('type', 'hotel')->get();
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [];
        return view('estimates.hotel.convert', compact('lead', 'customer_exists', 'customer', 'inclusions', 'exclusions', 'terms', 'payment_modes', 'hotels'));
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
            'website'               => $request->has('lead_id')?'':'required',
            'payment_modes'         => 'required|array|min:1',  
            'payment_type'          => 'required|array|min:1',          
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
            'website.required'          => 'Please select any Website',
            'payment_modes.required'    => 'Please select any Payment Mode',
            'payment_type.required'     => 'Please select any Payment Type',
        ];

        $this->validate($request, $rules, $messages);

        $estimate = new Estimate;
        $estimate->type                 = 'hotel';
        $estimate->customer_id          = $request->customer_id;
        $estimate->lead_id              = $request->has('lead_id') ? $request->lead_id : null;
        $estimate->assigned_to          = $request->has('lead_id') ? Lead::find($request->lead_id)->assigned_to : null;
        $estimate->source               = $request->has('lead_id') ? 'converted' : 'custom';
        $estimate->date                 = date("Y-m-d");
        $estimate->time                 = date("H:i:s");
        $estimate->payment_modes        = $request->payment_modes;
        $estimate->gst_filed            = $request->gst_filed;
        $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->payment_type         = implode(",", $request->payment_type);

        if($request->has('lead_id')){
            $lead = Lead::find($request->lead_id);
            $estimate->website                 = $lead->website;
        }else{
            $estimate->website                 = $request->website;
        }


        $estimate->save();

        $hotel                            = new EstimateHotel;
        $hotel->estimate_id               = $estimate->id;
        $hotel->adult                      = $request->adult;
        $hotel->child                     = $request->child;
        $hotel->room                      = $request->room;
        $hotel->bed                       = $request->bed;
        $hotel->check_in                  = Carbon::parse($request->check_in)->format('Y-m-d');
        $hotel->check_out                 = Carbon::parse($request->check_out)->format('Y-m-d');
        $hotel->destination               = $request->destination;
        $hotel->note                      = $request->note;
        $hotel->inclusion_filter          = $request->inclusion_filter;
        $hotel->term_filter               = $request->term_filter;
        $hotel->save();

        if (!empty($request->option) && is_array($request->option)) {
            foreach ($request->option as $key => $value) {

                $total_without_gst          = $value['amount'] - $value['discount'];
                $gst                        = round(($estimate->gst_filed / 100) * $total_without_gst);
                $total_with_gst             = $total_without_gst + $gst;
                $pg_charges                 = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                $option_total               = $total_with_gst + $pg_charges;

                $option                     = new EstimateHotelOption;
                $option->estimate_id        = $estimate->id;
                $option->estimate_hotel_id  = $hotel->id;
                $option->hotel_id           = $value['hotel_id'];
                $option->room_id            = $value['room_id'];
                $option->service_id         = $value['service_id'];
                $option->amount             = $value['amount'];
                $option->discount           = $value['discount'];
                $option->total              = $option_total;
                $option->save();
            }
        }

        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new EstimateInclusion;
                $inclusion->estimate_id     = $estimate->id;
                $inclusion->content         = $value['content'];
                $inclusion->filter          = $request->inclusion_filter;
                $inclusion->save();
            }
        }

        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new EstimateExclusion;
                $exclusion->estimate_id     = $estimate->id;
                $exclusion->content         = $value['content'];
                $exclusion->filter          = $request->exclusion_filter;
                $exclusion->save();
            }
        }


        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new EstimateTerm;
                $term->estimate_id     = $estimate->id;
                $term->content         = $value['content'];
                $term->filter          = $request->term_filter;
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
            $comment->comment       = "Hotel Estimate has been generated by " . Auth::user()->name;
            $comment->save();
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate generated',
            'comment' => 'A Hotel Estimate has been generated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
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
        $estimate             = Estimate::find($id)->load('hotel', 'hotel_options', 'customer', 'inclusions', 'exclusions','terms');
        $payment_modes        = PaymentMode::where('status', '1')->get();
        $payment              = EstimateHotelOption::where('estimate_id', $id)->where('accepted','yes')->value('total');
        $total                = $estimate->payment == 'half' ? $payment / 2 : $payment;
        // $company              = Company::where('default', 'yes')->first();
        $content                = TermsAndCondition::first();
         $company                    = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        return view('estimates.hotel.show', compact('estimate', 'payment_modes', 'total','company', 'content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estimate           = Estimate::find($id)->load('hotel', 'hotel_options');
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $payment_modes      = PaymentMode::where('status', '1')->get(['id', 'name']);
        $inclusions         = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions         = EstimateExclusion::where('estimate_id', $id)->get();
        $terms              = EstimateTerm::where('estimate_id', $id)->get();
        $hotels             = Hotel::where('status', 1)->get(['id', 'name']);
        $customer_exists    = Customer::where('id', $estimate->customer_id)->exists();
        $customer           = $customer_exists ? Customer::find($estimate->customer_id) : [];

        return view('estimates.hotel.edit', compact('estimate', 'customer_exists', 'customer', 'payment_modes', 'inclusions', 'exclusions','hotels','terms'));
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
            'payment_modes'         => 'required|array|min:1',
            'payment_type'          => 'required|array|min:1',
            'website'              => 'required',
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
            'payment_modes.required'    => 'Please select any Payment Mode',
            'payment_type.required'     => 'Please select any Payment Type',
            'website.required'          => 'Please select any Website',
        ];

        $this->validate($request, $rules, $messages);

        $estimate                       = Estimate::find($id);
        $estimate->customer_id          = $request->customer_id;
        $estimate->payment_modes        = $request->payment_modes;
         $estimate->website              = $request->website;
         $estimate->gst_filed            = $request->gst_filed;
         $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->estimate_status      = 'waiting';
        $estimate->payment_type         = implode(",", $request->payment_type);
        $estimate->save();

        $hotel_estimate_id                = EstimateHotel::where('estimate_id', $id)->value('id');

        $hotel                            = EstimateHotel::find($hotel_estimate_id);
        $hotel->adult                     = $request->adult;
        $hotel->child                     = $request->child;
        $hotel->room                      = $request->room;
        $hotel->bed                       = $request->bed;
        $hotel->check_in                  = Carbon::parse($request->check_in)->format('Y-m-d');
        $hotel->check_out                 = Carbon::parse($request->check_out)->format('Y-m-d');
        $hotel->destination               = $request->destination;
        $hotel->note                      = $request->note;
        $hotel->inclusion_filter          = $request->inclusion_filter;
        $hotel->term_filter               = $request->term_filter;
        $hotel->save();

        EstimateHotelOption::where('estimate_id', $id)->delete();
        if (!empty($request->option) && is_array($request->option)) {
            foreach ($request->option as $key => $value) {

                $total_without_gst          = $value['amount'] - $value['discount'];
                $gst                        = ($estimate->gst_filed / 100) * $total_without_gst;
                $total_with_gst             = $total_without_gst + $gst;
                $pg_charges                 = ($estimate->pg_charges_filed / 100) * $total_with_gst;
                $option_total               = $total_with_gst + $pg_charges;

                $option                     = new EstimateHotelOption;
                $option->estimate_id        = $estimate->id;
                $option->estimate_hotel_id  = $hotel->id;
                $option->hotel_id           = $value['hotel_id'];
                $option->room_id            = $value['room_id'];
                $option->service_id         = $value['service_id'];
                $option->amount             = $value['amount'];
                $option->discount           = $value['discount'];
                $option->total              = $option_total;
                $option->save();
            }
        }

        EstimateInclusion::where('estimate_id', $id)->delete();
        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new EstimateInclusion;
                $inclusion->estimate_id     = $estimate->id;
                $inclusion->content         = $value['content'];
                $inclusion->filter          = $request->inclusion_filter;
                $inclusion->save();
            }
        }

        EstimateExclusion::where('estimate_id', $id)->delete();
        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new EstimateExclusion;
                $exclusion->estimate_id     = $estimate->id;
                $exclusion->content         = $value['content'];
                $exclusion->filter          = $request->exclusion_filter;
                $exclusion->save();
            }
        }

        EstimateTerm::where('estimate_id', $id)->delete();
        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new EstimateTerm;
                $term->estimate_id     = $estimate->id;
                $term->content         = $value['content'];
                $term->filter          = $request->term_filter;
                $term->save();
            }
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate updated',
            'comment' => 'A Hotel Estimate has been updated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
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

        $option = EstimateHotelOption::find($id);
        $option->accepted = 'yes';
        $option->save();

        Estimate::where('id', $option->estimate_id)->update(['estimate_status' => 'accepted', 'payment' => $request->payamount]);
        return redirect()->back()->with('success', 'Estimate accepted successfully');
    }
}
