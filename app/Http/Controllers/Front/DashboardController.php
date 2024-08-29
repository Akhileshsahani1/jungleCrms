<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCancellationRequest;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $estimates_count = Estimate::where('customer_id', Auth::guard('customer')->user()->id)->with('customer', 'user')->count();
        $bookings_count  = Booking::where('customer_id', Auth::guard('customer')->user()->id)->with('customer', 'user', 'safari')->count();
        $tickets_count = Support::where('customer_id', Auth::guard('customer')->user()->id)->count();
        $approval_requests = BookingCancellationRequest::with('booking','refund_history')->where('customer_id',Auth::guard('customer')->user()->id,)->where('approval_amount','!=',null)->where('approval_status','=',0)->get();
        
        $rejections = BookingCancellationRequest::with('booking','refund_history')->where('customer_id',Auth::guard('customer')->user()->id,)->where('approval_amount','!=',null)->where('approval_status','=',2)->paginate(5);
        
        return view('front.dashboard', compact('estimates_count', 'bookings_count', 'tickets_count','approval_requests','rejections'));
    }

    public function myAccountForm()
    {
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        return view('front.my-account', compact('customer'));
    }

    public function myAccount(Request $request, $id)
    {

        $this->validate($request, [
            'name'      =>  'required',
            'email'     =>  'required',
            'mobile'     =>  ['required', Rule::unique('customers')->ignore($id),],
            'state'     =>  'required',
            'country'     =>  'required',
            'address'   =>  'required',
        ]);

        $customer                  = Customer::find($id);
        $customer->name            = $request->name;
        $customer->email           = $request->email;
        $customer->mobile          = $request->mobile;
        $customer->address         = $request->address;
        $customer->state           = $request->state;
        $customer->country         = $request->country;
        $customer->company         = $request->company;
        $customer->gstin           = $request->gstin;
        $customer->dob             = $request->dob;
        $customer->anniversary     = $request->anniversary;
        $customer->save();

        return redirect()->route('dashboard.my-account')->with('success', 'Your Account updated Successfully');
    }
}
