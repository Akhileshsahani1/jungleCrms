<?php

namespace App\Http\Controllers\Bookings\Safari;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingExclusion;
use App\Models\BookingInclusion;
use App\Models\BookingItem;
use App\Models\BookingSafari;
use App\Models\BookingSafariCustomer;
use App\Models\BookingSafariPermit;
use App\Models\BookingTerm;
use App\Models\CancelSafari;
use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateExclusion;
use App\Models\EstimateInclusion;
use App\Models\EstimateSafariOption;
use App\Models\EstimateTerm;
use App\Models\Exclusion;
use App\Models\Inclusion;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\State;
use App\Models\Term;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SafariBookingController extends Controller
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
        $states                 = State::get(['id', 'state']);
        $vendors                = Vendor::all();
        $inclusions             = Inclusion::where('type', 'safari')->get();
        $exclusions             = Exclusion::where('type', 'safari')->get();
        $terms                  = Term::where('mode', 'voucher')->where('type', 'safari')->get();
        if(isset($mobile)){
            $customer_exists    = Customer::where('mobile', $mobile)->exists();
            $customer           = $customer_exists ? Customer::where('mobile', $mobile)->first() : [] ;
        }else{
            $customer_exists    = false;
            $customer           = [];
        }
        session()->forget('mobile');
        return view('bookings.safari.create', compact('customer_exists', 'customer', 'states', 'vendors', 'inclusions', 'exclusions', 'terms'));
    }

    public function convert($id)
    {
        $lead               = Lead::find($id);
        $vendors            = Vendor::all();
        $inclusions         = Inclusion::where('type', 'safari')->get();
        $exclusions         = Exclusion::where('type', 'safari')->get();
        $terms              = Term::where('mode', 'voucher')->where('type', 'safari')->get();
        $states             = State::get(['id', 'state']);
        $customer_exists    = Customer::where('mobile', $lead->mobile)->exists();
        $customer           = $customer_exists ? Customer::where('mobile', $lead->mobile)->first() : [] ;

        return view('bookings.safari.convert', compact('lead', 'customer_exists', 'customer', 'states', 'vendors', 'inclusions', 'exclusions', 'terms'));
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
            'zone'                  => ($request->sanctuary == 'gir' || $request->sanctuary == 'ranthambore' ) ? 'required' : '',
            'area'                  => $request->sanctuary != 'gir' ? 'required' : '',
            'adult'                 => $request->sanctuary == 'gir' ? 'required' : '',
            'child'                 => $request->sanctuary == 'gir' ? 'required' : '',
            'total_person'          => $request->sanctuary == 'gir' ? '' : 'required',
            'vehicle_type'          => $request->sanctuary == 'ranthambore' ? 'required' : '',
            'type'                  => $request->sanctuary == 'ranthambore' ? 'required' : '',
            'nationality'           => 'required',
            'date'                  => 'required',
            'jeeps'                  => 'required',
            'time'                  => 'required',
            'amount'                => 'required',
            'vendor'                => 'required',
             'website'               => 'required',            
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
            'amount.required'           => 'Please enter Total Amount.',
            'vendor.required'           => 'Please choose Vendor.',
            'website.required'                   => 'Please enter Website',
        ];

        $this->validate($request, $rules, $messages);
        $website = $request->website;
        switch ($request->sanctuary) {
            case 'gir':
               $website = 'girlionsafari.com';
                break;
            case 'jim':
                $website = 'jimcorbett.in';
                break;
            case 'ranthambore':
                $website = 'ranthamboretigerreserve.in';
                break;
            case 'tadoba':
                $website = 'tadobapark.com';
                break;

        }


        $booking                       = new Booking;
        $booking->type                 = 'safari';
        $booking->customer_id          = $request->customer_id;
        $booking->lead_id              = $request->has('lead_id') ? $request->lead_id : null;
        $booking->estimate_id          = $request->has('estimate_id') ? $request->estimate_id : null;
        $booking->assigned_to          = $request->has('lead_id') ? Lead::find($request->lead_id)->assigned_to : null;
        $booking->source               = $request->has('lead_id') ? 'converted' : 'custom';
        $booking->website              = $website;        
        $booking->date                 = date("Y-m-d");
        $booking->time                 = date("H:i:s");
        $booking->save();

        if ($request->hasfile('image')) {
            $image              = $request->file('image');
            $name               = $image->getClientOriginalName();
            $image->storeAs('uploads/bookings/customers/'.$booking->id, $name, 'public');

            Booking::find($booking->id)->update(['image' => $name]);
        }

        $safari                            = new BookingSafari;
        $safari->booking_id                = $booking->id;
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
        $safari->amount                    = $request->amount;
        $safari->safari_due_amount         = $request->safari_due_amount;
        $safari->note                      = $request->note;
        $safari->jeeps                     = $request->jeeps;
        $safari->vendor                    = $request->vendor;
        $safari->type                      = $request->has('type') ? $request->type : null;;
        $safari->save();

        $company_state                  = Company::where('default', 'yes')->value('state');
        $customr_state                  = Customer::find($request->customer_id)->state;
        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){

               $item                  = new BookingItem;
               $item->booking_id      = $booking->id;
               $item->particular      = $value['particular'];
               $item->amount          = $value['amount'];
               $item->rate            = $value['rate'];
               $item->gst             = $company_state == $customr_state ? 'SGST@CGST' : 'IGST';
               $item->save();

            }
        }

        if (!empty($request->customer) && is_array($request->customer)) {
            foreach ($request->customer as $key => $value) {

                $option                         = new BookingSafariCustomer;
                $option->booking_id             = $booking->id;
                $option->name                   = $value['name'];
                $option->age                    = $value['age'];
                $option->gender                 = $value['gender'];
                $option->nationality            = $value['nationality'];
                $option->state                  = $value['state'];
                $option->idproof                = $value['idproof'];
                $option->idproof_no             = $value['idproof_no'];
                $option->save();
            }
        }

        if($request->has('lead_id')){
            $lead                       = Lead::find($request->lead_id);
            $lead->payment_status       = 'paid';
            $lead->lead_status          = 4;
            $lead->timestamps           = false;
            $lead->save();

                $comment                = new LeadComment();
                $comment->lead_id       = $request->lead_id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "booking generated";
                $comment->comment       = "Safari Booking has been generated by " . Auth::user()->name;
                $comment->save();
        }

        if($request->has('estimate_id')){
            Transaction::where('estimate_id', $request->estimate_id)->update(['booking_id' => $booking->id]);

            $payment_status = Estimate::find($request->estimate_id)->payment_status;
            Booking::where('id', $booking->id)->update(['payment_status' => $payment_status]);
        }

        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new BookingInclusion();
                $inclusion->booking_id     = $booking->id;
                $inclusion->content         = $value['content'];
                $inclusion->save();
            }
        }
       
        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new BookingExclusion();
                $exclusion->booking_id      = $booking->id;
                $exclusion->content         = $value['content'];
                $exclusion->save();
            }
        }

        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new BookingTerm();
                $term->booking_id      = $booking->id;
                $term->content         = $value['content'];
                $term->save();
            }
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking generated',
            'comment' => 'A Safari Booking has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);

        return redirect()->route('bookings.index')->with('success', 'Safari Booking created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $booking = Booking::find($id)->load('customer', 'user','safari', 'items', 'customer_details');
        $cancel  = CancelSafari::with('members')->where('booking_id',$id)->first();
        return view('bookings.safari.show', compact('booking','cancel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking            = Booking::find($id)->load('safari', 'items', 'customer_details');
        // $customers          = Customer::get(['id', 'name', 'mobile']);
        $states             = State::get(['id', 'state']);
        $countries          = Country::get(['country']);
        $customer_exists    = Customer::where('id', $booking->customer_id)->exists();
        $vendors            = Vendor::all();
        $customer           = $customer_exists ? Customer::find($booking->customer_id) : [];
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();

        return view('bookings.safari.edit', compact('booking', 'customer_exists', 'customer', 'states', 'countries', 'vendors', 'inclusions', 'exclusions', 'terms'));
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
            'zone'                  => ($request->sanctuary == 'gir' || $request->sanctuary == 'ranthambore' ) ? 'required' : '',
            'area'                  => $request->sanctuary != 'gir' ? 'required' : '',
            'adult'                 => $request->sanctuary == 'gir' ? 'required' : '',
            'child'                 => $request->sanctuary == 'gir' ? 'required' : '',
            'total_person'          => $request->sanctuary == 'gir' ? '' : 'required',
            'vehicle_type'          => $request->sanctuary == 'ranthambore' ? 'required' : '',
            'type'                  => $request->sanctuary == 'ranthambore' ? 'required' : '',
            'nationality'           => 'required',
            'date'                  => 'required',
            'time'                  => 'required',
            'amount'                => 'required',
            'vendor'                => 'required',
            'website'               => 'required',            
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
            'amount.required'           => 'Please enter Total Amount.',
            'vendor.required'           => 'Please choose Vendor.',
            'website.required'          => 'Please enter Website',
        ];

        $this->validate($request, $rules, $messages);

        $website = $request->website;
        switch ($request->sanctuary) {
            case 'gir':
               $website = 'girlionsafari.com';
                break;
            case 'jim':
                $website = 'jimcorbett.in';
                break;
            case 'ranthambore':
                $website = 'ranthamboretigerreserve.in';
                break;
            case 'tadoba':
                $website = 'tadobapark.com';
                break;

        }

        $booking                       = Booking::find($id);
        $booking->customer_id          = $request->customer_id;
        $booking->website              = $website;       
        $booking->save();

        if ($request->hasfile('image')) {
            $image              = $request->file('image');
            $name               = $image->getClientOriginalName();
            $image->storeAs('uploads/bookings/customers/'.$id, $name, 'public');

            Booking::find($id)->update(['image' => $name]);
        }

        $safari_booking_id                = BookingSafari::where('booking_id', $id)->value('id');

        $safari                            = BookingSafari::find($safari_booking_id);
        $safari->booking_id                = $booking->id;
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
        $safari->amount                    = $request->amount;
        $safari->note                      = $request->note;
        $safari->jeeps                     = $request->jeeps;
        $safari->vendor                    = $request->vendor;
        $safari->safari_due_amount         = $request->safari_due_amount;
        $safari->type                      = $request->has('type') ? $request->type : null;;
        $safari->save();

        BookingItem::where('booking_id', $id)->delete();
        $company_state                  = Company::where('default', 'yes')->value('state');
        $customr_state                  = Customer::find($request->customer_id)->state;
        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){

               $item                  = new BookingItem;
               $item->booking_id      = $booking->id;
               $item->particular      = $value['particular'];
               $item->amount          = $value['amount'];
               $item->rate            = $value['rate'];
               $item->gst             = $company_state == $customr_state ? 'SGST@CGST' : 'IGST';
               $item->save();

            }
        }

        BookingSafariCustomer::where('booking_id', $id)->delete();
        if (!empty($request->customer) && is_array($request->customer)) {
            foreach ($request->customer as $key => $value) {

                $option                         = new BookingSafariCustomer;
                $option->booking_id             = $booking->id;
                $option->name                   = $value['name'];
                $option->age                    = $value['age'];
                $option->gender                 = $value['gender'];
                $option->nationality            = $value['nationality'];
                $option->state                  = $value['state'];
                $option->idproof                = $value['idproof'];
                $option->idproof_no             = $value['idproof_no'];
                $option->save();
            }
        }

        BookingInclusion::where('booking_id', $id)->delete();
        if (!empty($request->inclusion) && is_array($request->inclusion)) {
            foreach ($request->inclusion as $key => $value) {
                $inclusion                  = new BookingInclusion();
                $inclusion->booking_id     = $booking->id;
                $inclusion->content         = $value['content'];
                $inclusion->save();
            }
        }

        BookingExclusion::where('booking_id', $id)->delete();
        if (!empty($request->exclusion) && is_array($request->exclusion)) {
            foreach ($request->exclusion as $key => $value) {
                $exclusion                  = new BookingExclusion();
                $exclusion->booking_id      = $booking->id;
                $exclusion->content         = $value['content'];
                $exclusion->save();
            }
        }

        BookingTerm::where('booking_id', $id)->delete();
        if (!empty($request->term) && is_array($request->term)) {
            foreach ($request->term as $key => $value) {
                $term                  = new BookingTerm();
                $term->booking_id      = $booking->id;
                $term->content         = $value['content'];
                $term->save();
            }
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'booking updated',
            'comment' => 'A Safari Booking has been updated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);

        return redirect()->route('bookings.index')->with('success', 'Safari Booking updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BookingSafariPermit::find($id)->delete();
        return redirect()->back()->with('permit', 'Permit Deleted Successfully');
    }

    public function booking($id)
    {
        $booking                    = Estimate::find($id)->load('safari');
        $booking->items             = [];
        $booking->customer_details  = [];
        $booking->option_selected   = EstimateSafariOption::where('estimate_id', $id)->where('accepted', 'yes')->first();
        $states                     = State::get(['id', 'state']);
        $vendors                    = Vendor::all();
        $customer_exists            = Customer::where('id', $booking->customer_id)->exists();
        $customer                   = $customer_exists ? Customer::find($booking->customer_id) : [];
        $inclusions                 = EstimateInclusion::where('estimate_id', $id)->get();
        $exclusions                 = EstimateExclusion::where('estimate_id', $id)->get();
        $terms                      = Term::where('mode', 'voucher')->where('type', 'cab')->where('filter', $booking->safari->sanctuary)->get();
        return view('bookings.safari.estimate.booking', compact('booking', 'states', 'vendors', 'customer_exists', 'customer', 'id', 'inclusions', 'exclusions', 'terms'));
    }

    public function upload(Request $request, $id){



        $booking          = Booking::find($id);

        if($booking->type == 'package'){

            $this->validate($request, [
                'permits'      => 'required',
                'safari_date'  => 'required',
            ]);

            if ($request->hasfile('permits')) {
                foreach ($request->file('permits') as $permit) {
                    $name = $permit->getClientOriginalName();
                    $permit->storeAs('uploads/bookings/permits/package/' . $id . '/', $name, 'public');
                    $booking->permits()->create([
                        'permit' => $name,
                        'safari_id' => $request->safari_date
                    ]);
                }
            }

        }elseif($booking->type == 'tour'){

            $this->validate($request, [
                'permits'      => 'required',
                'safari_date'  => 'required',
            ]);

            if ($request->hasfile('permits')) {
                foreach ($request->file('permits') as $permit) {
                    $name = $permit->getClientOriginalName();
                    $permit->storeAs('uploads/bookings/permits/' . $id . '/', $name, 'public');
                    $booking->permits()->create([
                        'permit' => $name,
                        'safari_id' => $request->safari_date
                    ]);
                }
            }

        }else{
            $this->validate($request, [
                'permits'      => 'required',
            ]);

            if ($request->hasfile('permits')) {
                foreach ($request->file('permits') as $permit) {
                    $name = $permit->getClientOriginalName();
                    $permit->storeAs('uploads/bookings/permits/' . $id . '/', $name, 'public');
                    $booking->permits()->create([
                        'permit' => $name
                    ]);
                }
            }
        }



        return redirect()->back()->with('permit', 'Permit Uploaded Successfully');
    }

    public function voucher($id){
        $booking                    = Booking::find($id)->load('customer', 'user','safari', 'items', 'customer_details');
        $booking->voucher_generated = 'yes';
        $booking->save();

        if(isset($booking->lead_id)){
            $comment                = new LeadComment();
            $comment->lead_id       = $booking->lead_id;
            $comment->comment_by    = Auth::user()->id;
            $comment->type          = "voucher generated";
            $comment->comment       = "Safari Voucher has been generated by " . Auth::user()->name;
            $comment->save();
        }

        $company                    = Company::where('websites', 'LIKE', '%' . $booking->website . '%')->first();
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo):'';
        $inclusions         = BookingInclusion::where('booking_id', $id)->get();
        $exclusions         = BookingExclusion::where('booking_id', $id)->get();
        $terms              = BookingTerm::where('booking_id', $id)->get();
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'voucher generated',
            'comment' => 'A Safari Booking voucher has been generated for <a href="'.route('bookings.show', $booking->id).'">Booking No. '.$booking->id.'</a>'
        ]);
        $pdf                        = Pdf::loadView('bookings.safari.voucher', compact('booking','terms','company', 'inclusions', 'exclusions'));

        return $pdf->download('Safari-voucher.pdf');
    }
}
