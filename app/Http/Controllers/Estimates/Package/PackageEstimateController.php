<?php

namespace App\Http\Controllers\Estimates\Package;

use App\Http\Controllers\Controller;
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
use App\Models\EstimateDestination;
use App\Models\{EstimateFlight,EstimateFlightOptions};

class PackageEstimateController extends Controller
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
        $inclusions             = Inclusion::where('type', 'package')->get();
        $exclusions             = Exclusion::where('type', 'package')->get();
        $payment_modes          = PaymentMode::where('status', '1')->get(['id', 'name']);
        $terms                  = Term::where('type', 'package')->get();
        $hotels                 = Hotel::where('status', 1)->get(['id', 'name']);
        $destinations           = Hotel::select('city as destination')->distinct('city')->get();
        $iternaries             = Destination::get();

        $estimate_type          = [];
        if (isset($mobile)) {
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [];
        } else {
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('estimates.package.create', compact('customer_exists', 'customer', 'inclusions', 'exclusions', 'payment_modes', 'terms', 'hotels', 'destinations', 'estimate_type','iternaries'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $inclusions         = Inclusion::where('type', 'package')->get();
        $exclusions         = Exclusion::where('type', 'package')->get();
        $payment_modes      = PaymentMode::where('status', '1')->get(['id', 'name']);
        $terms              = Term::where('type', 'package')->get();
        $hotels             = Hotel::where('status', 1)->get(['id', 'name']);
        $destinations       = Hotel::select('city as destination')->distinct('city')->get();
        $iternaries             = Destination::get();
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [];
        $estimate_type      = [];
        $estimate_destinations = EstimateDestination::all();
        return view('estimates.package.convert', compact('lead', 'customer_exists', 'customer', 'inclusions', 'exclusions', 'payment_modes', 'terms', 'hotels', 'destinations', 'estimate_type','iternaries','estimate_destinations'));
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

        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'estimate_type.required'            => 'Please select estimate type from list',
            'payment_modes.required'            => 'Please select any Payment Mode',
            'payment_type.required'             => 'Please select any Payment Type',
            'website.required'          => 'Please select any Website',
        ];

        $this->validate($request, $rules, $messages);

        $estimate = new Estimate;
        $estimate->type                 = 'package';
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
        $estimate->destination_id       = $request->destination_id;
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

            if (!empty($request->trip) && is_array($request->trip)) {
                foreach ($request->trip as $key => $trip) {
                    $cab                            = new EstimateCab;
                    $cab->estimate_id               = $estimate->id;
                    $cab->trip_type                 = $trip['trip_type'];
                    $cab->pickup_medium             = 'any';
                    $cab->vehicle_type              = $trip['cab_type'];
                    $cab->start_date                = Carbon::parse($trip['start_date'])->format('Y-m-d');
                    $cab->end_date                  = Carbon::parse($trip['end_date'])->format('Y-m-d');
                    $cab->days                      = $trip['days'];
                    $cab->pick_up                   = $trip['pick_up'];
                    $cab->drop                      = $trip['drop'];
                    $cab->pickup_time               = $trip['pickup_time'];
                    $cab->total_riders              = $trip['total_riders'];
                    $cab->no_of_cab                 = $trip['no_of_cab'];
                    $cab->note                      = $trip['cab_note'];
                    $cab->save();

                    if (!empty($trip['halts']) && is_array($trip['halts'])) {
                        foreach ($trip['halts'] as $key => $value) {
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
            }

            if (!empty($request->cab_option) && is_array($request->cab_option)) {
                foreach ($request->cab_option as $key => $value) {

                    $cab_option                  = new EstimateCabOption;
                    $cab_option->estimate_id     = $estimate->id;
                    $cab_option->content         = $value['content'];
                    $cab_option->amount          = $value['amount'];
                    $cab_option->discount        = $value['discount'];
                    $cab_option->total           = $value['amount'] - $value['discount'];
                    $cab_option->save();
                }
            }
        }
          
        if (in_array('flight', $request->estimate_type)) {
                    $flight                            = new EstimateFlight;
                    $flight->estimate_id               = $estimate->id;
                    $flight->trip_type                 = $request->flight_trip_type;
                    $flight->adults                    = $request->flight_adults;
                    $flight->childs                    = $request->flight_childs;
                    $flight->infants                   = $request->flight_infants;
                    $flight->save();

            if (!empty($request->flighttrip) && is_array($request->flighttrip)) {
                foreach ($request->flighttrip as $key => $trip) {
                   $f_option                       = new EstimateFlightOptions;
                   $f_option->estimate_id          = $estimate->id;
                   $f_option->estimate_flight_id   = $flight->id;
                   $f_option->type                 = $trip['journey_type'];
                   $f_option->travel_date          = $trip['start_date'];
                   $f_option->from                 = $trip['from'];
                   $f_option->to                   = $trip['to'];
                   $f_option->travel_class         = $trip['travel_class'];
                   $f_option->airport_name_from    = $trip['airport_name_from'];
                   $f_option->airport_name_to      = $trip['airport_name_to'];
                   $f_option->cancellation_charges = $trip['cancellation_charges'];
                   $f_option->airline_name         = $trip['airline_name'];
                   $f_option->departure_time       = $trip['departure_time'];
                   $f_option->reach_time           = $trip['reach_time'];
                   $f_option->stops                = $trip['stops'];
                   $f_option->flight_no            = $trip['flight_no'];
                   $f_option->cabin_bag            = $trip['cabin_bag'];
                   $f_option->bag_weight           = $trip['bag_weight'];
                   $f_option->cancellation         = $trip['cancellation'];
                   $f_option->meal                 = $trip['meal'];
                   $f_option->price                = $trip['price'];
                   $f_option->discount             = $trip['discount'];
                   $f_option->save();
                   
                }
             }
        }

        if(in_array('hotel', $request->estimate_type)) {
            if (!empty($request->hotel) && is_array($request->hotel)) {
                foreach ($request->hotel as $key => $value) {

                    $hotel                            = new EstimateHotel;
                    $hotel->estimate_id               = $estimate->id;
                    $hotel->adult                     = $value['adults'];
                    $hotel->child                     = $value['childs'];
                    $hotel->room                      = $value['room'];
                    $hotel->bed                       = $value['bed'];
                    $hotel->check_in                  = $value['check_in'];
                    $hotel->check_out                 = $value['check_out'];
                    $hotel->destination               = $value['destination'];
                    $hotel->note                      = $value['hotel_note'];
                    $hotel->save();

                    $option                             = new EstimateHotelDestinationOption;
                    $option->estimate_id                = $estimate->id;
                    $option->estimate_hotel_id          = $hotel->id;
                    $option->hotel_id                   = $value['hotel'];
                    $option->room_id                    = $value['hotel_room'];
                    $option->service_id                 = $value['service'];
                    $option->amount                     = $value['amount'];
                    $option->discount                   = $value['discount'];
                    $option->total                      = $value['amount'] - $value['discount'];
                    $option->save();

                }
            }
        }
        // dd($request);

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
            // echo $safari->id;die;

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
            $comment->comment       = "Package Estimate has been generated by " . Auth::user()->name;
            $comment->save();
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate generated',
            'comment' => 'A Package Estimate has been generated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
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
        $estimate               = Estimate::find($id)->load('safari', 'safari_options', 'cab', 'cab_options', 'hotel', 'hotel_options','flight','flight_options');
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
        return view('estimates.package.show', compact('content','estimate', 'payment_modes', 'estimate_type', 'total', 'hotel_total', 'company','local_address', 'payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estimate               = Estimate::find($id)->load('safari', 'safari_options', 'cab', 'cab_options', 'hotels', 'hotels.option');
        // $customers              = Customer::get(['id', 'name', 'mobile']);
        $payment_modes          = PaymentMode::where('status', '1')->get(['id', 'name']);
        $inclusions             = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions             = EstimateExclusion::where('estimate_id', $id)->get();
        $terms                  = EstimateTerm::where('estimate_id', $id)->get();
        $customer_exists        = Customer::where('id', $estimate->customer_id)->exists();
        $customer               = $customer_exists ? Customer::find($estimate->customer_id) : [];
        $hotels                 = Hotel::where('status', 1)->get(['id', 'name']);
        $destinations           = Hotel::select('city as destination')->distinct('city')->get();
        $iternaries             = Destination::get();
        $iternarie_options      = DestinationIternary::where('destination_id',$estimate->iternary_state)->where('duration',$estimate->duration)->get();
        $estimate_type          = [];

        $cab_estimate_exists    = EstimateCab::where('estimate_id', $id)->exists();
        if ($cab_estimate_exists) {
            array_push($estimate_type, 'cab');
        }
        $flight_estimate_exists    = EstimateFlight::where('estimate_id', $id)->exists();
        if ($flight_estimate_exists) {
            array_push($estimate_type, 'flight');
        }
        $safari_estimate_exists = EstimateSafari::where('estimate_id', $id)->exists();
        if ($safari_estimate_exists) {
            array_push($estimate_type, 'safari');
        }
        $hotel_estimate_exists  = EstimateHotel::where('estimate_id', $id)->exists();
        if ($hotel_estimate_exists) {
            array_push($estimate_type, 'hotel');
        }
        $estimate_destinations = EstimateDestination::all();

        return view('estimates.package.edit', compact('estimate', 'customer_exists', 'customer', 'hotels', 'destinations', 'payment_modes', 'inclusions', 'exclusions','terms', 'estimate_type','iternaries','iternarie_options','estimate_destinations'));
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

        ];

        $messages = [
            'customer_id.required'              => 'Please select customer from list',
            'estimate_type.required'            => 'Please select estimate type from list',
            'payment_modes.required'            => 'Please select any Payment Mode',
            'website.required'                   => 'Please select any Website',
        ];

        $this->validate($request, $rules, $messages);

        $estimate                       = Estimate::find($id);
        $estimate->type                 = 'package';
        $estimate->customer_id          = $request->customer_id;
        $estimate->estimate_status      = 'waiting';
        $estimate->website              = $request->website;
        $estimate->gst_filed            = $request->gst_filed;
        $estimate->pg_charges_filed     = $request->pg_charges_filed;
        $estimate->payment_modes        = $request->payment_modes;
        $estimate->iternary_state       = $request->iternary_state;
        $estimate->duration             = $request->duration;
        $estimate->iternary             = $request->iternary;
        $estimate->destination_id       = $request->destination_id;
        $estimate->payment_type         = implode(",", $request->payment_type);

        $estimate->save();

        if (!in_array('cab', $request->estimate_type)) {
            EstimateCab::where('estimate_id', $id)->delete();
            EstimateCabOption::where('estimate_id', $id)->delete();
        }

        if (in_array('cab', $request->estimate_type)) {
            EstimateCab::where('estimate_id', $id)->delete();
            EstimateCabHalt::where('estimate_id', $id)->delete();
            if (!empty($request->trip) && is_array($request->trip)) {
                foreach ($request->trip as $key => $trip) {
                    $cab                            = new EstimateCab;
                    $cab->estimate_id               = $estimate->id;
                    $cab->trip_type                 = $trip['trip_type'];
                    $cab->pickup_medium             = 'any';
                    $cab->vehicle_type              = $trip['cab_type'];
                    $cab->start_date                = Carbon::parse($trip['start_date'])->format('Y-m-d');
                    $cab->end_date                  = Carbon::parse($trip['end_date'])->format('Y-m-d');
                    $cab->days                      = $trip['days'];
                    $cab->pick_up                   = $trip['pick_up'];
                    $cab->drop                      = $trip['drop'];
                    $cab->pickup_time               = $trip['pickup_time'];
                    $cab->total_riders              = $trip['total_riders'];
                    $cab->no_of_cab                 = $trip['no_of_cab'];
                    $cab->note                      = $trip['cab_note'];
                    $cab->save();
                   
                    if (!empty($trip['halts']) && is_array($trip['halts'])) {
                        foreach ($trip['halts'] as $key => $value) {
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
                
            }

            EstimateCabOption::where('estimate_id', $id)->delete();
            if (!empty($request->cab_option) && is_array($request->cab_option)) {
                foreach ($request->cab_option as $key => $value) {

                    $cab_option                  = new EstimateCabOption;
                    $cab_option->estimate_id     = $estimate->id;
                    $cab_option->content         = $value['content'];
                    $cab_option->amount          = $value['amount'];
                    $cab_option->discount        = $value['discount'];
                    $cab_option->total           = $value['amount'] - $value['discount'];
                    $cab_option->save();
                }
            }
        }

        if (!in_array('flight', $request->estimate_type)) {
            EstimateFlight::where('estimate_id', $id)->delete();
            EstimateFlightOptions::where('estimate_id', $id)->delete();
        }

        if (in_array('flight', $request->estimate_type)) {
             EstimateFlight::where('estimate_id', $id)->delete();
            EstimateFlightOptions::where('estimate_id', $id)->delete();
            
                    $flight                            = new EstimateFlight;
                    $flight->estimate_id               = $estimate->id;
                    $flight->trip_type                 = $request->flight_trip_type;
                    $flight->adults                    = $request->flight_adults;
                    $flight->childs                    = $request->flight_childs;
                    $flight->infants                   = $request->flight_infants;
                    $flight->save();

            if (!empty($request->flighttrip) && is_array($request->flighttrip)) {
                foreach ($request->flighttrip as $key => $trip) {
                   $f_option                       = new EstimateFlightOptions;
                   $f_option->estimate_id          = $estimate->id;
                   $f_option->estimate_flight_id   = $flight->id;
                   $f_option->type                 = $trip['journey_type'];
                   $f_option->travel_date          = $trip['start_date'];
                   $f_option->from                 = $trip['from'];
                   $f_option->to                   = $trip['to'];
                   $f_option->travel_class         = $trip['travel_class'];
                   $f_option->airport_name_from    = $trip['airport_name_from'];
                   $f_option->airport_name_to      = $trip['airport_name_to'];
                   $f_option->cancellation_charges = $trip['cancellation_charges'];
                   $f_option->airline_name         = $trip['airline_name'];
                   $f_option->departure_time       = $trip['departure_time'];
                   $f_option->reach_time           = $trip['reach_time'];
                   $f_option->stops                = $trip['stops'];
                   $f_option->flight_no            = $trip['flight_no'];
                   $f_option->cabin_bag            = $trip['cabin_bag'];
                   $f_option->bag_weight           = $trip['bag_weight'];
                   $f_option->cancellation         = $trip['cancellation'];
                   $f_option->meal                 = $trip['meal'];
                   $f_option->price                = $trip['price'];
                   $f_option->discount             = $trip['discount'];
                   $f_option->save();
                   
                }
             }
        }


        $hotel_estimate_exists  = EstimateHotel::where('estimate_id', $id)->exists();

        if ($hotel_estimate_exists) {
            $hotel_estimate_id = EstimateHotel::where('estimate_id', $id)->value('id');
        }

        if (!in_array('hotel', $request->estimate_type) && $hotel_estimate_exists) {
            EstimateHotel::where('estimate_id', $id)->delete();
            EstimateHotelDestination::where('estimate_id', $id)->delete();
            EstimateHotelDestinationOption::where('estimate_id', $id)->delete();
        }

        if (in_array('hotel', $request->estimate_type)) {
            EstimateHotel::where('estimate_id', $id)->delete();
            EstimateHotelDestination::where('estimate_id', $id)->delete();
            EstimateHotelDestinationOption::where('estimate_id', $id)->delete();

            if (!empty($request->hotel) && is_array($request->hotel)) {
                foreach ($request->hotel as $key => $value) {

                    $hotel                            = new EstimateHotel;
                    $hotel->estimate_id               = $estimate->id;
                    $hotel->adult                     = $value['adults'];
                    $hotel->child                     = $value['childs'];
                    $hotel->room                      = $value['room'];
                    $hotel->bed                       = $value['bed'];
                    $hotel->check_in                  = $value['check_in'];
                    $hotel->check_out                 = $value['check_out'];
                    $hotel->destination               = $value['destination'];
                    $hotel->note                      = $value['hotel_note'];
                    $hotel->save();

                    $option                             = new EstimateHotelDestinationOption;
                    $option->estimate_id                = $estimate->id;
                    $option->estimate_hotel_id          = $hotel->id;
                    $option->hotel_id                   = $value['hotel'];
                    $option->room_id                    = $value['hotel_room'];
                    $option->service_id                 = $value['service'];
                    $option->amount                     = $value['amount'];
                    $option->discount                   = $value['discount'];
                    $option->total                      = $value['amount'] - $value['discount'];
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
            'comment' => 'A Package Estimate has been updated <a href="'.route('estimates.show', $estimate->id).'">Estimate No. '.$estimate->id.'</a>'
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
        Estimate::where('id', $id)->update(['estimate_status' => 'accepted', 'payment' => $request->payamount]);
        return redirect()->back()->with('success', 'Estimate accepted successfully');
    }
}
