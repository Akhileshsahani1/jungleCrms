<?php

namespace App\Http\Controllers\Estimates;

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
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\PaymentMode;
use App\Models\TermsAndCondition;
use App\Models\EstimateHotelDestinationOption;
use App\Models\LocalAddress;
use App\Models\Company;
use App\Models\UserActivity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class EstimateController extends Controller
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
        $filter_estimate_type       = $request->filter_estimate_type;

        $estimates = Estimate::with('customer', 'user');

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

         if(isset($filter_estimate_type)) {
            $estimates->where('type', $filter_estimate_type);
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

        return view('estimates.list', compact('users', 'filter_email',  'filter_website', 'filter_sanctuary', 'estimates', 'filter_name', 'filter_date', 'filter_user', 'filter_payment_status', 'filter_estimate_status', 'filter_mobile','filter_estimate_type'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estimate = Estimate::find($id);
        switch ($estimate->type) {
            case 'cab':
                return redirect()->route('cab-estimate.edit', $id);
                break;
            case 'hotel':
                return redirect()->route('hotel-estimate.edit', $id);
                break;
            case 'safari':
                return redirect()->route('safari-estimate.edit', $id);
                break;
            case 'tour':
                return redirect()->route('tour-estimate.edit', $id);
                break;
            case 'package':
                return redirect()->route('package-estimate.edit', $id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $estimate = Estimate::find($id);
        $estimate->reason = $request->reason;
        $estimate->deleted_by = Auth::user()->id;
        $estimate->save();
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'estimate updated',
            'comment' => 'A Estimate has been Deleted Estimate No. '.$estimate->id.'.'
        ]);
        $estimate->delete();
        // EstimateCab::where('estimate_id', $id)->delete();
        // EstimateCabOption::where('estimate_id', $id)->delete();
        // EstimateSafari::where('estimate_id', $id)->delete();
        // EstimateSafariOption::where('estimate_id', $id)->delete();
        // EstimateHotel::where('estimate_id', $id)->delete();
        // EstimateHotelOption::where('estimate_id', $id)->delete();
        // EstimateInclusion::where('estimate_id', $id)->delete();
        // EstimateTerm::where('estimate_id', $id)->delete();

        return redirect()->back()->with('success', 'Estimate deleted successfully');
    }

    function paymentSuccess(Request $request){

        $estimate                   = Estimate::findOrFail($request->estimate_id);
        $estimate->payment_status   = 'paid';
        $estimate->save();

        $transaction                    = new Transaction;
        $transaction->estimate_id       = $request->estimate_id;
        $transaction->customer_id       = $estimate->customer_id;
        $transaction->date              = date('Y-m-d');
        $transaction->amount            = $request->amount;
        $transaction->mode              = 'RazorPay';
        $transaction->transaction_id    = $request->razorpay_payment_id;
        $transaction->save();

        if($estimate->lead_id){
            Lead::where('id', $estimate->lead_id)->update(['payment_status' => 'paid']);
            $comment                = new LeadComment();
            $comment->lead_id       = $estimate->lead_id;
            $comment->comment_by    = Auth::user()->id;
            $comment->type          = "paid";
            $comment->comment       = "Payment of Rs.". $request->amount ." is added by " . Auth::user()->name;
            $comment->save();
        }

        $arr = array('msg' => 'Payment successfully credited', 'status' => true);
        return Response()->json($arr);
    }

    public function reports_estimates(Request $request)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        })->get(['id', 'name']);

        $filter_name                = $request->filter_name;
        $filter_customer            = $request->filter_customer;
        $filter_mobile              = $request->filter_mobile;
        $filter_date                = $request->filter_date;
        $filter_user                = $request->filter_user;
        $filter_payment_status      = $request->filter_payment_status;
        $filter_sanctuary           = $request->filter_sanctuary;
        $filter_estimate_status     = $request->filter_estimate_status;

        $estimates = Estimate::with('customer', 'user');

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

          if(isset($filter_date)) {
            $estimates->where('date', $filter_date);
          }

          if(isset($filter_user)) {
           $estimates->where('assigned_to',$filter_user);
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

         if(Auth::user()->hasAnyRole('administrator|team lead|agent')){

          $estimates = $estimates->latest()->paginate(20);

          }elseif(Auth::user()->hasRole('fresher')){

              $estimates = $estimates->latest()->paginate(20);

          }else{

              $estimates = $estimates->where('assigned_to', Auth::user()->id)->latest()->paginate(20);

          }

        return view('estimates.list', compact('users', 'filter_sanctuary', 'estimates', 'filter_name', 'filter_date', 'filter_user', 'filter_payment_status', 'filter_estimate_status', 'filter_mobile'));
    }

    public function sendLink($id){

        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
        $type = Estimate::find($id)->type;
        $estimate = Estimate::find($id);
       if($type == 'cab'){
        $shortURLObject = $builder->destinationUrl(route('cab-estimate.show', $id))->make();
       }
       if($type == 'hotel'){
        $shortURLObject = $builder->destinationUrl(route('hotel-estimate.show', $id))->make();
       }
       if($type == 'safari'){
        $shortURLObject = $builder->destinationUrl(route('safari-estimate.show', $id))->make();
       }
       if($type == 'tour'){
        $shortURLObject = $builder->destinationUrl(route('tour-estimate.show', $id))->make();
       }
       if($type == 'package'){
        $shortURLObject = $builder->destinationUrl(route('package-estimate.show', $id))->make();
       }
        
        $shortURL = $shortURLObject->default_short_url;
        return view('estimates.send-link', compact('shortURL', 'estimate'));
    }

    public function sendWhatsappMessage(Request $request)
    {
        $type = Estimate::find($request->id)->type;
        $estimate = Estimate::find($request->id)->load('lead', 'cab', 'cab_options', 'customer', 'inclusions', 'terms');   
        $ch = curl_init();

        $mobile_no = $estimate->customer->mobile;
        $name = @$estimate->lead->user->name;
        $mobile = @$estimate->lead->user->phone;

        $params = [
            "messaging_product" => "whatsapp", 
            "recipient_type" => "individual", 
            "to" => (strlen($mobile_no) <=10) ? '91'.$mobile_no : $mobile_no,
            "type" => "template", 
            "template" => [
                "name" => "booking_estimate", 
                "language" => [
                    "code" => "en_US"
                ], 
                "components" => [
                    [
                        "type" => "header", 
                        "parameters" => [
                            [
                                "type" => "text", 
                                "text" => $estimate->customer->name 
                            ] 
                        ] 
                    ],
                    [
                        "type" => "body", 
                        "parameters" => [
                            [
                                "type" => "text", 
                                "text" => $request->link 
                            ],
                            [
                                "type" => "text", 
                                "text" => @$name ?? 'Abhishek'
                            ],
                            [
                                "type" => "text", 
                                "text" => @$mobile ?? "919971717045"
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
            
            return redirect()->route('estimates.send-link',$request->id)->with('error', $data['error']['message']);
        }
        $estimate->share_count = ($estimate->share_count)?($estimate->share_count+1):1;
        $estimate->save();
        if($estimate->lead_id){
        $comment                = new LeadComment();
        $comment->lead_id       = $estimate->lead_id;
        $comment->comment_by    = Auth::user()->id;
        $comment->type          = "estimate sent";
        $comment->comment       = "Estimates has been sent to customer number whatsapp  by " . Auth::user()->name;
        $comment->save();
        }

        return redirect()->route('estimates.send-link',$request->id)->with('success', 'message sent successfully');
    }

    public function sendLinkMessage(Request $request, $id){
        $type = Estimate::find($id)->type;
        $estimate           = Estimate::find($id)->load('cab', 'cab_options', 'customer', 'inclusions', 'terms');
        Http::get('http://login.pacttown.com/api/mt/SendSMS?user=N2RTECHNOLOGIES&password=994843&senderid=NTRTEC&channel=Trans&DCS=0&flashsms=0&number=9999577620&text=Your one time password to activate your accoun');
        return redirect()->back()->with('success', 'message sent successfully');
    }
     public function downloadEstimate($id){
        ini_set('max_execution_time', 3600); // 3600 seconds = 60 minutes
        set_time_limit(3600);
        
        $estimate = Estimate::find($id);
        switch ($estimate->type) {
            case 'cab':
                $estimate           = Estimate::find($id)->load('cab', 'cab_options', 'customer', 'inclusions', 'exclusions', 'terms');
                $payment_modes      = PaymentMode::where('status', '1')->get();
                $payment            = EstimateCabOption::where('estimate_id', $id)->where('accepted', 'yes')->value('total');
                $total              = $estimate->payment == 'half' ? $payment / 2 : $payment;       
                $company            = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
                $company->path      = isset($company->logo) ? asset('storage/uploads/company/' . $company->logo) : '';
                $content            = TermsAndCondition::first();

                $pdf = Pdf::loadView('estimates.cab.download', compact('estimate', 'payment_modes', 'total', 'company', 'content'));        

                return $pdf->download('Cab-estimate.pdf');
                break;

            case 'hotel':

               $estimate             = Estimate::find($id)->load('hotel', 'hotel_options', 'customer', 'inclusions', 'exclusions','terms');
                $payment_modes        = PaymentMode::where('status', '1')->get();
                $payment              = EstimateHotelOption::where('estimate_id', $id)->where('accepted','yes')->value('total');
                $total                = $estimate->payment == 'half' ? $payment / 2 : $payment;
                $content                = TermsAndCondition::first();
                 $company                    = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
                $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';

                $pdf = Pdf::loadView('estimates.hotel.download', compact('estimate', 'payment_modes', 'total','company', 'content'));        

                return $pdf->download('Hotel-estimate.pdf');

                break;
            case 'safari':
                $estimate             = Estimate::find($id)->load('safari', 'safari_options', 'customer', 'inclusions', 'exclusions','terms');
                $content                = TermsAndCondition::first();
                $payment_modes        = PaymentMode::where('status', '1')->get();
                $payment                = EstimateSafariOption::where('estimate_id', $id)->where('accepted','yes')->value('total');
                $total                = $estimate->payment == 'half' ? $payment / 2 : $payment;
                // $company              = Company::where('default', 'yes')->first();
                $company                    = Company::where('websites', 'LIKE', '%' . $estimate->website . '%')->first();
                $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
                $local_address        = LocalAddress::where('sanctuary', $estimate->safari->sanctuary)->first();

                 $pdf = Pdf::loadView('estimates.safari.download', compact('estimate', 'payment_modes', 'total','company', 'local_address', 'content'));        

                return $pdf->download('Safari-estimate.pdf');
                break;
            case 'tour':
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
                $pdf = Pdf::loadView('estimates.tour.download', compact('estimate', 'payment_modes', 'estimate_type', 'total','company','hotel_amount', 'local_address', 'content'));        

                return $pdf->download('Tour-estimate.pdf');
                break;
            case 'package':
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
                $pdf = Pdf::loadView('estimates.package.download', compact('content','estimate', 'payment_modes', 'estimate_type', 'total', 'hotel_total', 'company','local_address', 'payment'));        
                
                return $pdf->download('Package-estimate.pdf');
                break;
        }
        return redirect()->route('estimates.index')->with('error', 'Something went wrong.');
    }


}
