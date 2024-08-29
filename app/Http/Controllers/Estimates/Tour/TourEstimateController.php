<?php

namespace App\Http\Controllers\Estimates\Tour;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateCab;
use App\Models\EstimateCabOption;
use App\Models\EstimateHotel;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

class TourEstimateController extends Controller
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
        $inclusions             = Inclusion::where('type', 'tour')->get();
        $exclusions             = Exclusion::where('type', 'tour')->get();
        $payment_modes          = PaymentMode::where('status', '1')->get(['id', 'name']);
        $terms                  = Term::where('type', 'tour')->get();
        $hotels                 = Hotel::where('status', 1)->get(['id', 'name']);
        $estimate_type          = [];
        $iternaries             = Destination::get();
        if (isset($mobile)) {
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [];
        } else {
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('estimates.tour.create', compact('customer_exists', 'customer', 'inclusions', 'exclusions', 'payment_modes', 'terms', 'hotels', 'estimate_type','iternaries'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        $inclusions         = Inclusion::where('type', 'tour')->get();
        $exclusions         = Exclusion::where('type', 'tour')->get();
        $payment_modes      = PaymentMode::where('status', '1')->get(['id', 'name']);
        $terms              = Term::where('type', 'tour')->get();
        $hotels             = Hotel::where('status', 1)->get(['id', 'name']);
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [];
        $iternaries         = Destination::get();
        $estimate_type      = [];
        // dd($payment_modes);
        return view('estimates.tour.convert', compact('lead', 'customer_exists', 'customer', 'inclusions', 'exclusions','payment_modes', 'terms', 'hotels', 'estimate_type','iternaries'));
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
            'estimate_type'         => 'required|array|min:1',
            'payment_modes'         => 'required|array|min:1',
            'payment_type'          => 'required|array|min:1',
            'website'               => $request->has('lead_id')?'':'required',
            'trip_type'             =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'cab_type'              =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'start_date'            =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'end_date'              =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'days'                  =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'pick_up'               =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'drop'                  =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'pickup_time'           =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'total_riders'          =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'adults'                =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'childs'                =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'room'                  =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'bed'                   =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'check_in'              =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'check_out'             =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'destination'           =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'sanctuary'             =>  in_array('safari', $request->estimate_type) ? 'required' : '',           

        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'estimate_type.required'            => 'Please select estimate type from list',
            'payment_modes.required'            => 'Please select any Payment Mode',
            'website.required'                  => 'Please select any Website',
            'trip_type.required'                => 'The Trip Type field can not be blank.',          
            'cab_type.required'                 => 'Please select vehicle type',
            'start_date.required'               => 'Please enter journey start date.',
            'end_date.required'                 => 'Please enter journey end date.',
            'days.required'                     => 'Please enter no of days.',
            'pick_up.required'                  => 'Please enter Pickup point',
            'drop.required'                     => 'Please enter Drop point',
            'pickup_time.required'              => 'Please enter Pickup time',
            'total_riders.required'             => 'Please enter no of riders.',
            'adults.required'                   => 'Please enter No of Adults.',
            'childs.required'                   => 'Please enter No of Children.',
            'room.required'                     => 'Please enter No of Rooms.',
            'bed.required'                      => 'Please enter No of Beds.',
            'check_in.required'                 => 'Please enter Check In date.',
            'check_out.required'                => 'Please enter Check Out date.',
            'destination.required'              => 'Please enter Destination.',
            'sanctuary.required'                => 'Please select Sanctuary.',           
        ];

        $this->validate($request, $rules, $messages);

        $estimate = new Estimate;
        $estimate->type                 = 'tour';
        $estimate->customer_id          = $request->customer_id;
        $estimate->lead_id              = $request->has('lead_id') ? $request->lead_id : null;
        $estimate->assigned_to          = $request->has('lead_id') ? Lead::find($request->lead_id)->assigned_to : null;
        $estimate->source               = $request->has('lead_id') ? 'converted' : 'custom';
        $estimate->date                 = date("Y-m-d");
        $estimate->time                 = date("H:i:s");
        $estimate->gst_filed            = $request->gst_filed;
        $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->iternary_state       = $request->iternary_state;
        $estimate->duration             = $request->duration;
        $estimate->iternary             = $request->iternary;
        $estimate->payment_modes        = $request->payment_modes;
        $estimate->payment_type         = implode(",", $request->payment_type);
         if($request->has('lead_id')){
            $lead = Lead::find($request->lead_id);
            $estimate->website                 = $lead->website;
        }else{
            $estimate->website                 = $request->website;
        }
        $estimate->save();

        if (in_array('cab', $request->estimate_type)) {

            $cab = new EstimateCab;
            $cab->estimate_id               = $estimate->id;
            $cab->trip_type                 = $request->trip_type;
            $cab->pickup_medium             = 'any';
            $cab->vehicle_type              = $request->cab_type;
            $cab->start_date                = Carbon::parse($request->start_date)->format('Y-m-d');
            $cab->end_date                  = Carbon::parse($request->end_date)->format('Y-m-d');
            $cab->days                      = $request->days;
            $cab->pick_up                   = $request->pick_up;
            $cab->drop                      = $request->drop;
            $cab->pickup_time               = $request->pickup_time;
            $cab->total_riders              = $request->total_riders;
            $cab->no_of_cab                 = $request->no_of_cab;
            $cab->note                      = $request->cab_note;
            $cab->save();

            if (!empty($request->cab_option) && is_array($request->cab_option)) {
                foreach ($request->cab_option as $key => $value) {

                    $cab_option                  = new EstimateCabOption;
                    $cab_option->estimate_id     = $estimate->id;
                    $cab_option->estimate_cab_id = $cab->id;
                    $cab_option->content         = $value['content'];
                    $cab_option->amount          = $value['amount'];
                    $cab_option->discount        = $value['discount'];
                    $cab_option->total           = $value['amount'] - $value['discount'];
                    $cab_option->save();
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
        }


        if (in_array('hotel', $request->estimate_type)) {

            $hotel                            = new EstimateHotel;
            $hotel->estimate_id               = $estimate->id;
            $hotel->adult                     = $request->adults;
            $hotel->child                     = $request->childs;
            $hotel->room                      = $request->room;
            $hotel->bed                       = $request->bed;
            $hotel->check_in                  = Carbon::parse($request->check_in)->format('Y-m-d');
            $hotel->check_out                 = Carbon::parse($request->check_out)->format('Y-m-d');
            $hotel->destination               = $request->destination;
            $hotel->note                      = $request->hotel_note;
            $hotel->save();

            if (!empty($request->option) && is_array($request->option)) {
                foreach ($request->option as $key => $value) {

                    $option                     = new EstimateHotelOption;
                    $option->estimate_id        = $estimate->id;
                    $option->estimate_hotel_id  = $hotel->id;
                    $option->hotel_id           = $value['hotel_id'];
                    $option->room_id            = $value['room_id'];
                    $option->service_id         = $value['service_id'];
                    $option->amount             = $value['amount'];
                    $option->discount           = $value['discount'];
                    $option->total              = $value['amount'] - $value['discount'];
                    $option->save();
                }
            }
        }



        if (in_array('safari', $request->estimate_type)) {           
            if (!empty($request->safari) && is_array($request->safari)) {
                foreach ($request->safari as $key => $value) {
                    $safari                            = new EstimateSafari;
                    $safari->estimate_id               = $estimate->id;
                    $safari->sanctuary                 = $request->sanctuary;
                    $safari->mode                      = $value['mode'];
                    $safari->area                      = array_key_exists('area', $value) ? $value['area'] : null;
                    $safari->zone                      = array_key_exists('zone', $value) ? $value['zone'] : null;
                    $safari->adult                     = array_key_exists('adult', $value) ? $value['adult'] : null;
                    $safari->child                     = array_key_exists('child', $value) ? $value['child'] : null;
                    $safari->total_person              = array_key_exists('total_person', $value)  ?  $value['total_person'] : $value['adult'] + $value['child'];
                    $safari->vehicle_type              = array_key_exists('vehicle_type', $value) ? $value['vehicle_type'] : null;
                    $safari->date                      = Carbon::parse($value['date'])->format('Y-m-d');
                    $safari->time                      = $value['time'];
                    $safari->nationality               = $value['nationality'];
                    $safari->note                      = $value['note'];
                    $safari->jeeps                     = $value['jeeps'];
                    $safari->type                      = array_key_exists('type', $value) ? $value['type'] : null;
                    $safari->save();
                }
            }

            if (!empty($request->safari_option) && is_array($request->safari_option)) {
                foreach ($request->safari_option as $key => $value) {

                    $safari_option                         = new EstimateSafariOption;
                    $safari_option->estimate_id            = $estimate->id;
                    $safari_option->estimate_safari_id     = $safari->id;
                    $safari_option->content                = $value['content'];
                    $safari_option->amount                 = $value['amount'];
                    $safari_option->discount               = $value['discount'];
                    $safari_option->total                  = $value['amount'] - $value['discount'];
                    $safari_option->save();
                }
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
            foreach($request->iternaries as $key => $value){
                $iternary             = new EstimateIternary;
                $iternary->estimate_id  = $estimate->id;
                $iternary->title        = $value['title'];
                $iternary->text         = $value['text'];
                $iternary->save();
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
            $comment->comment       = "Tour Estimate has been generated by " . Auth::user()->name;
            $comment->save();
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate generated',
            'comment' => 'A Tour Estimate has been generated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
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
        $estimate               = Estimate::find($id)->load('safari', 'safari_options', 'cab', 'cab_options', 'hotel', 'hotel_options');
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

        return view('estimates.tour.show', compact('estimate', 'payment_modes', 'estimate_type', 'total','company','hotel_amount', 'local_address', 'content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estimate               = Estimate::find($id)->load('safari', 'safari_options', 'cab', 'cab_options', 'hotel', 'hotel_options');      
        $payment_modes          = PaymentMode::where('status', '1')->get(['id', 'name']);
        $inclusions             = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions             = EstimateExclusion::where('estimate_id', $id)->get();
        $terms                  = EstimateTerm::where('estimate_id', $id)->get();
        $customer_exists        = Customer::where('id', $estimate->customer_id)->exists();
        $customer               = $customer_exists ? Customer::find($estimate->customer_id) : [];
        $hotels                 = Hotel::where('status', 1)->get(['id', 'name']);
        $estimate_type          = [];
          $iternaries             = Destination::get();
        $iternarie_options      = DestinationIternary::where('destination_id',$estimate->iternary_state)->where('duration',$estimate->duration)->get();

        $cab_estimate_exists    = EstimateCab::where('estimate_id', $id)->exists();
        if ($cab_estimate_exists) {
            array_push($estimate_type, 'cab');
        }
        $safari_estimate_exists = EstimateSafari::where('estimate_id', $id)->exists();
        if ($safari_estimate_exists) {
            array_push($estimate_type, 'safari');
        }
        $hotel_estimate_exists  = EstimateHotel::where('estimate_id', $id)->exists();
        if ($hotel_estimate_exists) {
            array_push($estimate_type, 'hotel');
        }

        return view('estimates.tour.edit', compact('estimate', 'customer_exists', 'customer', 'hotels', 'payment_modes', 'inclusions', 'exclusions', 'terms', 'estimate_type','iternaries','iternarie_options'));
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
            'estimate_type'         => 'required|array|min:1',
            'payment_modes'         => 'required|array|min:1',
            'payment_type'          => 'required|array|min:1',
             'website'              => 'required',

            'trip_type'             =>  in_array('cab', $request->estimate_type) ? 'required' : '',            
            'cab_type'              =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'start_date'            =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'end_date'              =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'days'                  =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'pick_up'               =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'drop'                  =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'pickup_time'           =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'total_riders'          =>  in_array('cab', $request->estimate_type) ? 'required' : '',
            'adults'                =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'childs'                =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'room'                  =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'bed'                   =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'check_in'              =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'check_out'             =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'destination'           =>  in_array('hotel', $request->estimate_type) ? 'required' : '',
            'sanctuary'             =>  in_array('safari', $request->estimate_type) ? 'required' : '',

        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'estimate_type.required'            => 'Please select estimate type from list',
            'payment_modes.required'            => 'Please select any Payment Mode',
            'website.required'                  => 'Please select any Website',
            'trip_type.required'                => 'The Trip Type field can not be blank.',
            'pickup_medium.required'            => 'Please select pickup medium',
            'cab_type.required'                 => 'Please select vehicle type',
            'start_date.required'               => 'Please enter journey start date.',
            'end_date.required'                 => 'Please enter journey end date.',
            'days.required'                     => 'Please enter no of days.',
            'pick_up.required'                  => 'Please enter Pickup point',
            'drop.required'                     => 'Please enter Drop point',
            'pickup_time.required'              => 'Please enter Pickup time',
            'total_riders.required'             => 'Please enter no of riders.',
            'adults.required'                   => 'Please enter No of Adults.',
            'childs.required'                   => 'Please enter No of Children.',
            'room.required'                     => 'Please enter No of Rooms.',
            'bed.required'                      => 'Please enter No of Beds.',
            'check_in.required'                 => 'Please enter Check In date.',
            'check_out.required'                => 'Please enter Check Out date.',
            'destination.required'              => 'Please enter Destination.',
            'sanctuary.required'                => 'Please select Sanctuary.',
        ];

        $this->validate($request, $rules, $messages);

        $estimate                       = Estimate::find($id);
        $estimate->type                 = 'tour';
        $estimate->customer_id          = $request->customer_id;
        $estimate->estimate_status      = 'waiting';
        $estimate->website              = $request->website;
        $estimate->gst_filed            = $request->gst_filed;
        $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->payment_modes        = $request->payment_modes;
        $estimate->iternary_state       = $request->iternary_state;
        $estimate->duration             = $request->duration;
        $estimate->iternary             = $request->iternary;
        $estimate->payment_type         = implode(",", $request->payment_type);
        $estimate->save();

        $cab_estimate_exists    = EstimateCab::where('estimate_id', $id)->exists();

        if ($cab_estimate_exists) {
            $cab_estimate_id = EstimateCab::where('estimate_id', $id)->value('id');
        }

        if (!in_array('cab', $request->estimate_type) && $cab_estimate_exists) {
            EstimateCab::where('estimate_id', $id)->delete();
            EstimateCabOption::where('estimate_id', $id)->delete();
        }

        if (in_array('cab', $request->estimate_type)) {

            $cab                            = $cab_estimate_exists ? EstimateCab::find($cab_estimate_id) : new EstimateCab;
            $cab->estimate_id               = $estimate->id;
            $cab->trip_type                 = $request->trip_type;
            $cab->pickup_medium             = 'any';
            $cab->vehicle_type              = $request->cab_type;
            $cab->start_date                = Carbon::parse($request->start_date)->format('Y-m-d');
            $cab->end_date                  = Carbon::parse($request->end_date)->format('Y-m-d');
            $cab->days                      = $request->days;
            $cab->pick_up                   = $request->pick_up;
            $cab->drop                      = $request->drop;
            $cab->pickup_time               = $request->pickup_time;
            $cab->total_riders              = $request->total_riders;
            $cab->no_of_cab                 = $request->no_of_cab;
            $cab->note                      = $request->cab_note;
            $cab->save();

            EstimateCabOption::where('estimate_id', $id)->delete();
            if (!empty($request->cab_option) && is_array($request->cab_option)) {
                foreach ($request->cab_option as $key => $value) {

                    $cab_option                  = new EstimateCabOption;
                    $cab_option->estimate_id     = $estimate->id;
                    $cab_option->estimate_cab_id = $cab->id;
                    $cab_option->content         = $value['content'];
                    $cab_option->amount          = $value['amount'];
                    $cab_option->discount        = $value['discount'];
                    $cab_option->total           = $value['amount'] - $value['discount'];
                    $cab_option->save();
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
        }


        $hotel_estimate_exists  = EstimateHotel::where('estimate_id', $id)->exists();

        if ($hotel_estimate_exists) {
            $hotel_estimate_id = EstimateHotel::where('estimate_id', $id)->value('id');
        }

        if (!in_array('hotel', $request->estimate_type) && $hotel_estimate_exists) {
            EstimateHotel::where('estimate_id', $id)->delete();
            EstimateHotelOption::where('estimate_id', $id)->delete();
        }

        if (in_array('hotel', $request->estimate_type)) {

            $hotel                            = $hotel_estimate_exists ? EstimateHotel::find($hotel_estimate_id) : new EstimateHotel;
            $hotel->estimate_id               = $estimate->id;
            $hotel->adult                     = $request->adults;
            $hotel->child                     = $request->childs;
            $hotel->room                      = $request->room;
            $hotel->bed                       = $request->bed;
            $hotel->check_in                  = Carbon::parse($request->check_in)->format('Y-m-d');
            $hotel->check_out                 = Carbon::parse($request->check_out)->format('Y-m-d');
            $hotel->destination               = $request->destination;
            $hotel->note                      = $request->hotel_note;
            $hotel->save();

            EstimateHotelOption::where('estimate_id', $id)->delete();
            if (!empty($request->option) && is_array($request->option)) {
                foreach ($request->option as $key => $value) {

                    $option                     = new EstimateHotelOption;
                    $option->estimate_id        = $estimate->id;
                    $option->estimate_hotel_id  = $hotel->id;
                    $option->hotel_id           = $value['hotel_id'];
                    $option->room_id            = $value['room_id'];
                    $option->service_id         = $value['service_id'];
                    $option->amount             = $value['amount'];
                    $option->discount           = $value['discount'];
                    $option->total              = $value['amount'] - $value['discount'];
                    $option->save();
                }
            }
        }


        $safari_estimate_exists = EstimateSafari::where('estimate_id', $id)->exists();
        if ($safari_estimate_exists) {
            $safari_estimate_id = EstimateSafari::where('estimate_id', $id)->value('id');
        }

        if (!in_array('safari', $request->estimate_type) && $safari_estimate_exists) {
            EstimateSafari::where('estimate_id', $id)->delete();
            EstimateSafariOption::where('estimate_id', $id)->delete();
        }

        if (in_array('safari', $request->estimate_type)) {
            EstimateSafari::where('estimate_id', $id)->delete();
            if (!empty($request->safari) && is_array($request->safari)) {
                foreach ($request->safari as $key => $value) {
                    $safari                            = new EstimateSafari;
                    $safari->estimate_id               = $estimate->id;
                    $safari->sanctuary                 = $request->sanctuary;
                    $safari->mode                      = $value['mode'];
                    $safari->area                      = array_key_exists('area', $value) ? $value['area'] : null;
                    $safari->zone                      = array_key_exists('zone', $value) ? $value['zone'] : null;
                    $safari->adult                     = array_key_exists('adult', $value) ? $value['adult'] : null;
                    $safari->child                     = array_key_exists('child', $value) ? $value['child'] : null;
                    $safari->total_person              = array_key_exists('total_person', $value)  ?  $value['total_person'] : $value['adult'] + $value['child'];
                    $safari->vehicle_type              = array_key_exists('vehicle_type', $value) ? $value['vehicle_type'] : null;
                    $safari->date                      = Carbon::parse($value['date'])->format('Y-m-d');
                    $safari->time                      = $value['time'];
                    $safari->nationality               = $value['nationality'];
                    $safari->note                      = $value['note'];
                    $safari->jeeps                     = $value['jeeps'];
                    $safari->type                      = array_key_exists('type', $value) ? $value['type'] : null;
                    $safari->save();
                }
            }

            EstimateSafariOption::where('estimate_id', $id)->delete();
            if (!empty($request->safari_option) && is_array($request->safari_option)) {
                foreach ($request->safari_option as $key => $value) {

                    $safari_option                         = new EstimateSafariOption;
                    $safari_option->estimate_id            = $estimate->id;
                    $safari_option->estimate_safari_id     = $safari->id;
                    $safari_option->content                = $value['content'];
                    $safari_option->amount                 = $value['amount'];
                    $safari_option->discount               = $value['discount'];
                    $safari_option->total                  = $value['amount'] - $value['discount'];
                    $safari_option->save();
                }
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
            foreach($request->iternaries as $key => $value){
                $iternary             = new EstimateIternary;
                $iternary->estimate_id  = $estimate->id;
                $iternary->title        = $value['title'];
                $iternary->text         = $value['text'];
                $iternary->save();
            }
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate updated',
            'comment' => 'A Tour Estimate has been updated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
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

    public function accept($id)
    {     
        // dd($id);
        $option = EstimateHotelOption::find($id);
        $option->accepted = 'yes';
        $option->save();

        Estimate::where('id', $option->estimate_id)->update(['estimate_status' => 'accepted']);
        return redirect()->back()->with('success', 'Estimate accepted successfully');
    }
}
